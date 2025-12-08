<?php

namespace App\Http\Controllers\Farm;

use App\Http\Controllers\Controller;
use App\Models\Entry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class EntryController extends Controller
{
    /**
     * Display a listing of entries for the farm manager's farm.
     */
    public function index()
    {
        $farm = Auth::user()->farm;
        
        if (!$farm) {
            return redirect()->route('farm.dashboard')
                ->with('error', 'No farm assigned to your account. Please contact administrator.');
        }

        $entries = Entry::where('farm_id', $farm->id)
            ->orderBy('date', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('farm.entries.index', compact('entries', 'farm'));
    }

    /**
     * Show the form for creating a new entry.
     */
    public function create()
    {
        $farm = Auth::user()->farm;
        
        if (!$farm) {
            return redirect()->route('farm.dashboard')
                ->with('error', 'No farm assigned to your account. Please contact administrator.');
        }

        return view('farm.entries.create', compact('farm'));
    }

    /**
     * Store a newly created entry.
     */
    public function store(Request $request)
    {
        $farm = Auth::user()->farm;
        
        if (!$farm) {
            return redirect()->route('farm.dashboard')
                ->with('error', 'No farm assigned to your account.');
        }

        $validated = $request->validate([
            'date' => ['required', 'date', 'before_or_equal:today'],
            'fish_stock' => ['required', 'integer', 'min:0'],
            'feed_quantity' => ['required', 'numeric', 'min:0'],
            'mortality' => ['required', 'integer', 'min:0'],
            'water_temp' => ['nullable', 'numeric', 'min:0', 'max:50'],
            'remarks' => ['nullable', 'string', 'max:1000'],
        ]);

        // Check if entry already exists for this date
        $existingEntry = Entry::where('farm_id', $farm->id)
            ->where('date', $validated['date'])
            ->first();

        if ($existingEntry) {
            return back()
                ->withInput()
                ->withErrors(['date' => 'An entry already exists for this date. Please edit the existing entry instead.']);
        }

        // Create entry with editable_until set to 3 hours from now
        $entry = Entry::create([
            'farm_id' => $farm->id,
            'date' => $validated['date'],
            'fish_stock' => $validated['fish_stock'],
            'feed_quantity' => $validated['feed_quantity'],
            'mortality' => $validated['mortality'],
            'water_temp' => $validated['water_temp'] ?? null,
            'remarks' => $validated['remarks'] ?? null,
            'editable_until' => Carbon::now()->addHours(3),
        ]);

        return redirect()
            ->route('farm.entries.index')
            ->with('success', 'Daily entry added successfully! You can edit or delete it within 3 hours.');
    }

    /**
     * Show the form for editing the specified entry.
     */
    public function edit(Entry $entry)
    {
        $farm = Auth::user()->farm;
        
        if (!$farm || $entry->farm_id !== $farm->id) {
            abort(403, 'Unauthorized access.');
        }

        // Check if entry is still editable (within 3 hours)
        if (!$entry->isEditable()) {
            return redirect()
                ->route('farm.entries.index')
                ->with('error', 'This entry can no longer be edited. The 3-hour editing window has expired.');
        }

        return view('farm.entries.edit', compact('entry', 'farm'));
    }

    /**
     * Update the specified entry.
     */
    public function update(Request $request, Entry $entry)
    {
        $farm = Auth::user()->farm;
        
        if (!$farm || $entry->farm_id !== $farm->id) {
            abort(403, 'Unauthorized access.');
        }

        // Check if entry is still editable
        if (!$entry->isEditable()) {
            return redirect()
                ->route('farm.entries.index')
                ->with('error', 'This entry can no longer be edited. The 3-hour editing window has expired.');
        }

        $validated = $request->validate([
            'date' => ['required', 'date', 'before_or_equal:today'],
            'fish_stock' => ['required', 'integer', 'min:0'],
            'feed_quantity' => ['required', 'numeric', 'min:0'],
            'mortality' => ['required', 'integer', 'min:0'],
            'water_temp' => ['nullable', 'numeric', 'min:0', 'max:50'],
            'remarks' => ['nullable', 'string', 'max:1000'],
        ]);

        // Check if another entry exists for the new date (if date changed)
        if ($validated['date'] != $entry->date) {
            $existingEntry = Entry::where('farm_id', $farm->id)
                ->where('date', $validated['date'])
                ->where('id', '!=', $entry->id)
                ->first();

            if ($existingEntry) {
                return back()
                    ->withInput()
                    ->withErrors(['date' => 'An entry already exists for this date.']);
            }
        }

        $entry->update($validated);

        return redirect()
            ->route('farm.entries.index')
            ->with('success', 'Entry updated successfully!');
    }

    /**
     * Remove the specified entry.
     */
    public function destroy(Entry $entry)
    {
        $farm = Auth::user()->farm;
        
        if (!$farm || $entry->farm_id !== $farm->id) {
            abort(403, 'Unauthorized access.');
        }

        // Check if entry is still editable (only last entry within 3 hours can be deleted)
        $lastEntry = Entry::where('farm_id', $farm->id)
            ->orderBy('created_at', 'desc')
            ->first();

        if ($entry->id !== $lastEntry->id) {
            return redirect()
                ->route('farm.entries.index')
                ->with('error', 'You can only delete the most recent entry.');
        }

        if (!$entry->isEditable()) {
            return redirect()
                ->route('farm.entries.index')
                ->with('error', 'This entry can no longer be deleted. The 3-hour editing window has expired.');
        }

        $entry->delete();

        return redirect()
            ->route('farm.entries.index')
            ->with('success', 'Entry deleted successfully!');
    }
}
