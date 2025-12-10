<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Entry;
use App\Models\District;
use App\Models\Farm;
use Illuminate\Http\Request;

class EntryController extends Controller
{
    /**
     * Display a listing of all entries with filters.
     */
    public function index(Request $request)
    {
        $query = Entry::with(['farm.district', 'farm.manager']);

        // Filter by district
        if ($request->filled('district_id')) {
            $query->whereHas('farm', function ($q) use ($request) {
                $q->where('district_id', $request->district_id);
            });
        }

        // Filter by farm
        if ($request->filled('farm_id')) {
            $query->where('farm_id', $request->farm_id);
        }

        // Filter by date range
        if ($request->filled('date_from')) {
            $query->where('date', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->where('date', '<=', $request->date_to);
        }

        // Order by date and time (most recent first)
        $entries = $query->orderBy('date', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(20)
            ->withQueryString();

        // Get districts and farms for filters
        $districts = District::allowed()->orderBy('name')->get();
        $farms = Farm::with('district')->orderBy('name')->get();

        // Get selected farm for district filter
        $selectedFarm = null;
        if ($request->filled('farm_id')) {
            $selectedFarm = Farm::find($request->farm_id);
        }

        return view('admin.entries.index', compact('entries', 'districts', 'farms', 'selectedFarm'));
    }

    /**
     * Display the specified entry.
     */
    public function show(Entry $entry)
    {
        $entry->load(['farm.district', 'farm.manager', 'staffAttendance.staff']);
        return view('admin.entries.show', compact('entry'));
    }

    /**
     * Show the form for creating a new entry.
     */
    public function create()
    {
        $districts = District::allowed()->orderBy('name')->get();
        $farms = Farm::with('district')->orderBy('name')->get();
        return view('admin.entries.create', compact('districts', 'farms'));
    }

    /**
     * Store a newly created entry.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'farm_id' => ['required', 'exists:farms,id'],
            'date' => ['required', 'date', 'before_or_equal:today'],
            'fish_stock' => ['required', 'integer', 'min:0'],
            'mortality' => ['required', 'integer', 'min:0'],
            'shifting_in' => ['required', 'integer', 'min:0'],
            'shifting_out' => ['required', 'integer', 'min:0'],
            'sale' => ['required', 'integer', 'min:0'],
            'feed_in_stock' => ['required', 'numeric', 'min:0'],
            'feed_consumption' => ['required', 'numeric', 'min:0'],
            'medication' => ['nullable', 'string', 'max:1000'],
            'water_temp' => ['nullable', 'numeric', 'min:0', 'max:50'],
            'water_ph' => ['nullable', 'numeric', 'min:0', 'max:14'],
            'water_do' => ['nullable', 'numeric', 'min:0'],
            'offence_cases' => ['required', 'integer', 'min:0'],
            'additional_notes' => ['nullable', 'string', 'max:2000'],
        ]);

        // Check if entry already exists for this date and farm
        $existingEntry = Entry::where('farm_id', $validated['farm_id'])
            ->where('date', $validated['date'])
            ->first();

        if ($existingEntry) {
            return back()
                ->withInput()
                ->withErrors(['date' => 'An entry already exists for this date and farm. Please edit the existing entry instead.']);
        }

        $entry = Entry::create([
            'farm_id' => $validated['farm_id'],
            'date' => $validated['date'],
            'fish_stock' => $validated['fish_stock'],
            'mortality' => $validated['mortality'],
            'shifting_in' => $validated['shifting_in'],
            'shifting_out' => $validated['shifting_out'],
            'sale' => $validated['sale'],
            'feed_quantity' => 0, // Keep for backward compatibility
            'feed_in_stock' => $validated['feed_in_stock'],
            'feed_consumption' => $validated['feed_consumption'],
            'medication' => $validated['medication'] ?? null,
            'water_temp' => $validated['water_temp'] ?? null,
            'water_ph' => $validated['water_ph'] ?? null,
            'water_do' => $validated['water_do'] ?? null,
            'offence_cases' => $validated['offence_cases'],
            'additional_notes' => $validated['additional_notes'] ?? null,
        ]);

        return redirect()
            ->route('admin.entries.index')
            ->with('success', 'Entry created successfully!');
    }

    /**
     * Show the form for editing the specified entry.
     */
    public function edit(Entry $entry)
    {
        $entry->load(['farm.district', 'farm.manager']);
        $districts = District::allowed()->orderBy('name')->get();
        $farms = Farm::with('district')->orderBy('name')->get();
        return view('admin.entries.edit', compact('entry', 'districts', 'farms'));
    }

    /**
     * Update the specified entry.
     */
    public function update(Request $request, Entry $entry)
    {
        $validated = $request->validate([
            'farm_id' => ['required', 'exists:farms,id'],
            'date' => ['required', 'date', 'before_or_equal:today'],
            'fish_stock' => ['required', 'integer', 'min:0'],
            'mortality' => ['required', 'integer', 'min:0'],
            'shifting_in' => ['required', 'integer', 'min:0'],
            'shifting_out' => ['required', 'integer', 'min:0'],
            'sale' => ['required', 'integer', 'min:0'],
            'feed_in_stock' => ['required', 'numeric', 'min:0'],
            'feed_consumption' => ['required', 'numeric', 'min:0'],
            'medication' => ['nullable', 'string', 'max:1000'],
            'water_temp' => ['nullable', 'numeric', 'min:0', 'max:50'],
            'water_ph' => ['nullable', 'numeric', 'min:0', 'max:14'],
            'water_do' => ['nullable', 'numeric', 'min:0'],
            'offence_cases' => ['required', 'integer', 'min:0'],
            'additional_notes' => ['nullable', 'string', 'max:2000'],
        ]);

        // Check if another entry exists for the new date and farm (if date or farm changed)
        if ($validated['date'] != $entry->date || $validated['farm_id'] != $entry->farm_id) {
            $existingEntry = Entry::where('farm_id', $validated['farm_id'])
                ->where('date', $validated['date'])
                ->where('id', '!=', $entry->id)
                ->first();

            if ($existingEntry) {
                return back()
                    ->withInput()
                    ->withErrors(['date' => 'An entry already exists for this date and farm.']);
            }
        }

        $entry->update($validated);

        return redirect()
            ->route('admin.entries.index')
            ->with('success', 'Entry updated successfully!');
    }

    /**
     * Remove the specified entry.
     */
    public function destroy(Entry $entry)
    {
        $entry->delete();

        return redirect()
            ->route('admin.entries.index')
            ->with('success', 'Entry deleted successfully!');
    }
}
