<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\District;
use App\Models\Farm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class ManagerController extends Controller
{
    /**
     * Display a listing of farm managers.
     */
    public function index()
    {
        $managers = User::where('role', 'manager')
            ->with(['district', 'farm'])
            ->latest()
            ->paginate(15);

        return view('admin.managers.index', compact('managers'));
    }

    /**
     * Show the form for creating a new farm manager.
     */
    public function create()
    {
        $districts = District::allowed()->orderBy('name')->get();
        return view('admin.managers.create', compact('districts'));
    }

    /**
     * Store a newly created farm manager.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'district_id' => ['required', 'exists:districts,id'],
            'farm_id' => ['required', 'exists:farms,id'],
        ]);

        // Verify the farm belongs to the selected district and has no manager
        $farm = Farm::findOrFail($validated['farm_id']);
        if ($farm->district_id != $validated['district_id']) {
            return back()
                ->withInput()
                ->withErrors(['farm_id' => 'The selected farm does not belong to the selected district.']);
        }

        if ($farm->manager_id !== null) {
            return back()
                ->withInput()
                ->withErrors(['farm_id' => 'This farm already has a manager assigned.']);
        }

        // Create the farm manager user
        $manager = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'manager',
            'district_id' => $validated['district_id'],
        ]);

        // Assign the existing farm to the manager
        $farm->update([
            'manager_id' => $manager->id,
        ]);

        return redirect()
            ->route('admin.managers.show', $manager)
            ->with('success', 'Farm manager created successfully!')
            ->with('credentials', [
                'email' => $validated['email'],
                'password' => $validated['password'],
            ]);
    }

    /**
     * Display the specified farm manager with credentials.
     */
    public function show(User $manager)
    {
        if ($manager->role !== 'manager') {
            abort(404);
        }

        $manager->load(['district', 'farm']);
        return view('admin.managers.show', compact('manager'));
    }

    /**
     * Show the form for editing the specified farm manager.
     */
    public function edit(User $manager)
    {
        if ($manager->role !== 'manager') {
            abort(404);
        }

        $districts = District::allowed()->orderBy('name')->get();
        $manager->load('farm');
        
        // Get farms for the manager's current district (for initial load)
        $farms = collect();
        if ($manager->district_id) {
            $farms = Farm::where('district_id', $manager->district_id)
                ->where(function($query) use ($manager) {
                    $query->whereNull('manager_id')
                          ->orWhere('manager_id', $manager->id);
                })
                ->orderBy('name')
                ->get();
        }
        
        return view('admin.managers.edit', compact('manager', 'districts', 'farms'));
    }

    /**
     * Update the specified farm manager.
     */
    public function update(Request $request, User $manager)
    {
        if ($manager->role !== 'manager') {
            abort(404);
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $manager->id],
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
            'district_id' => ['required', 'exists:districts,id'],
            'farm_id' => ['required', 'exists:farms,id'],
        ]);

        // Verify the farm belongs to the selected district
        $farm = Farm::findOrFail($validated['farm_id']);
        if ($farm->district_id != $validated['district_id']) {
            return back()
                ->withInput()
                ->withErrors(['farm_id' => 'The selected farm does not belong to the selected district.']);
        }

        // Check if farm already has a different manager
        if ($farm->manager_id !== null && $farm->manager_id != $manager->id) {
            return back()
                ->withInput()
                ->withErrors(['farm_id' => 'This farm already has a different manager assigned.']);
        }

        $manager->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'district_id' => $validated['district_id'],
        ]);

        // Update password if provided
        if (!empty($validated['password'])) {
            $manager->update([
                'password' => Hash::make($validated['password']),
            ]);
        }

        // Update farm assignment
        $oldFarm = $manager->farm;
        if ($oldFarm && $oldFarm->id != $validated['farm_id']) {
            $oldFarm->update(['manager_id' => null]);
        }

        $farm->update([
            'manager_id' => $manager->id,
        ]);

        return redirect()
            ->route('admin.managers.show', $manager)
            ->with('success', 'Farm manager updated successfully!');
    }

    /**
     * Remove the specified farm manager.
     */
    public function destroy(User $manager)
    {
        if ($manager->role !== 'manager') {
            abort(404);
        }

        $manager->delete();

        return redirect()
            ->route('admin.managers.index')
            ->with('success', 'Farm manager deleted successfully!');
    }

    /**
     * Reset password for a farm manager.
     */
    public function resetPassword(Request $request, User $manager)
    {
        if ($manager->role !== 'manager') {
            abort(404);
        }

        $validated = $request->validate([
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $manager->update([
            'password' => Hash::make($validated['password']),
        ]);

        return redirect()
            ->route('admin.managers.show', $manager)
            ->with('success', 'Password reset successfully!')
            ->with('credentials', [
                'email' => $manager->email,
                'password' => $validated['password'],
            ]);
    }
}
