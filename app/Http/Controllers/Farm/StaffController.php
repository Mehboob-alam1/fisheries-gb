<?php

namespace App\Http\Controllers\Farm;

use App\Http\Controllers\Controller;
use App\Models\Staff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StaffController extends Controller
{
    /**
     * Display a listing of staff for the farm.
     */
    public function index()
    {
        $farm = Auth::user()->farm;
        
        if (!$farm) {
            return redirect()->route('farm.dashboard')
                ->with('error', 'No farm assigned to your account.');
        }

        $staff = Staff::where('farm_id', $farm->id)
            ->orderBy('is_active', 'desc')
            ->orderBy('name')
            ->get();

        return view('farm.staff.index', compact('staff', 'farm'));
    }

    /**
     * Show the form for creating a new staff member.
     */
    public function create()
    {
        $farm = Auth::user()->farm;
        
        if (!$farm) {
            return redirect()->route('farm.dashboard')
                ->with('error', 'No farm assigned to your account.');
        }

        return view('farm.staff.create', compact('farm'));
    }

    /**
     * Store a newly created staff member.
     */
    public function store(Request $request)
    {
        $farm = Auth::user()->farm;
        
        if (!$farm) {
            return redirect()->route('farm.dashboard')
                ->with('error', 'No farm assigned to your account.');
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'position' => ['nullable', 'string', 'max:255'],
            'contact_number' => ['nullable', 'string', 'max:20'],
            'cnic' => ['nullable', 'string', 'max:20'],
            'joining_date' => ['nullable', 'date'],
        ]);

        Staff::create([
            'farm_id' => $farm->id,
            'name' => $validated['name'],
            'position' => $validated['position'] ?? null,
            'contact_number' => $validated['contact_number'] ?? null,
            'cnic' => $validated['cnic'] ?? null,
            'joining_date' => $validated['joining_date'] ?? null,
            'is_active' => true,
        ]);

        return redirect()
            ->route('farm.staff.index')
            ->with('success', 'Staff member added successfully!');
    }

    /**
     * Show the form for editing the specified staff member.
     */
    public function edit(Staff $staff)
    {
        $farm = Auth::user()->farm;
        
        if (!$farm || $staff->farm_id !== $farm->id) {
            abort(403, 'Unauthorized access.');
        }

        return view('farm.staff.edit', compact('staff', 'farm'));
    }

    /**
     * Update the specified staff member.
     */
    public function update(Request $request, Staff $staff)
    {
        $farm = Auth::user()->farm;
        
        if (!$farm || $staff->farm_id !== $farm->id) {
            abort(403, 'Unauthorized access.');
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'position' => ['nullable', 'string', 'max:255'],
            'contact_number' => ['nullable', 'string', 'max:20'],
            'cnic' => ['nullable', 'string', 'max:20'],
            'joining_date' => ['nullable', 'date'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        // Handle is_active checkbox (if not checked, it won't be in request)
        $validated['is_active'] = $request->has('is_active') ? (bool)$request->input('is_active') : false;

        $staff->update($validated);

        return redirect()
            ->route('farm.staff.index')
            ->with('success', 'Staff member updated successfully!');
    }

    /**
     * Remove the specified staff member.
     */
    public function destroy(Staff $staff)
    {
        $farm = Auth::user()->farm;
        
        if (!$farm || $staff->farm_id !== $farm->id) {
            abort(403, 'Unauthorized access.');
        }

        $staff->delete();

        return redirect()
            ->route('farm.staff.index')
            ->with('success', 'Staff member deleted successfully!');
    }
}
