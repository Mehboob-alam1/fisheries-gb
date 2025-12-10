<?php

namespace App\Http\Controllers\Farm;

use App\Http\Controllers\Controller;
use App\Models\Entry;
use App\Models\StaffAttendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
        DB::beginTransaction();
        try {
            $entry = Entry::create([
                'farm_id' => $farm->id,
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
                'editable_until' => Carbon::now()->addHours(3),
            ]);

            // Handle staff attendance
            if ($request->has('staff_attendance') && is_array($request->staff_attendance)) {
                foreach ($request->staff_attendance as $staffId => $attendanceData) {
                    if (isset($attendanceData['present']) && $attendanceData['present'] == 1) {
                        StaffAttendance::create([
                            'staff_id' => $staffId,
                            'entry_id' => $entry->id,
                            'date' => $validated['date'],
                            'status' => 'present',
                            'check_in' => $attendanceData['check_in'] ?? null,
                            'check_out' => $attendanceData['check_out'] ?? null,
                            'remarks' => null,
                        ]);
                    }
                }
            }

            DB::commit();

            return redirect()
                ->route('farm.entries.index')
                ->with('success', 'Daily entry added successfully! You can edit or delete it within 3 hours.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()
                ->withInput()
                ->with('error', 'An error occurred while saving the entry. Please try again.');
        }
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
            'mortality' => ['required', 'integer', 'min:0'],
            'shifting_in' => ['required', 'integer', 'min:0'],
            'shifting_out' => ['required', 'integer', 'min:0'],
            'sale' => ['required', 'integer', 'min:0'],
            'feed_in_stock' => ['required', 'numeric', 'min:0'],
            'feed_consumption' => ['required', 'numeric', 'min:0'],
            'medication' => ['nullable', 'string', 'max:2000'],
            'water_temp' => ['nullable', 'numeric', 'min:0', 'max:50'],
            'water_ph' => ['nullable', 'numeric', 'min:0', 'max:14'],
            'water_do' => ['nullable', 'numeric', 'min:0'],
            'offence_cases' => ['required', 'integer', 'min:0'],
            'additional_notes' => ['nullable', 'string', 'max:2000'],
            'staff_attendance' => ['nullable', 'array'],
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

        DB::beginTransaction();
        try {
            $entry->update([
                'date' => $validated['date'],
                'fish_stock' => $validated['fish_stock'],
                'mortality' => $validated['mortality'],
                'shifting_in' => $validated['shifting_in'],
                'shifting_out' => $validated['shifting_out'],
                'sale' => $validated['sale'],
                'feed_in_stock' => $validated['feed_in_stock'],
                'feed_consumption' => $validated['feed_consumption'],
                'medication' => $validated['medication'] ?? null,
                'water_temp' => $validated['water_temp'] ?? null,
                'water_ph' => $validated['water_ph'] ?? null,
                'water_do' => $validated['water_do'] ?? null,
                'offence_cases' => $validated['offence_cases'],
                'additional_notes' => $validated['additional_notes'] ?? null,
            ]);

            // Update staff attendance - delete old and create new
            $entry->staffAttendance()->delete();
            if ($request->has('staff_attendance') && is_array($request->staff_attendance)) {
                foreach ($request->staff_attendance as $staffId => $attendanceData) {
                    if (isset($attendanceData['present']) && $attendanceData['present'] == 1) {
                        StaffAttendance::create([
                            'staff_id' => $staffId,
                            'entry_id' => $entry->id,
                            'date' => $validated['date'],
                            'status' => 'present',
                            'check_in' => $attendanceData['check_in'] ?? null,
                            'check_out' => $attendanceData['check_out'] ?? null,
                            'remarks' => null,
                        ]);
                    }
                }
            }

            DB::commit();

            return redirect()
                ->route('farm.entries.index')
                ->with('success', 'Entry updated successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()
                ->withInput()
                ->with('error', 'An error occurred while updating the entry. Please try again.');
        }
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
