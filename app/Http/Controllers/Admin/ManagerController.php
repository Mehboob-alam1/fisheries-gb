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
        $districts = District::orderBy('name')->get();
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
            'farm_name' => ['required', 'string', 'max:255'],
            'location' => ['nullable', 'string', 'max:255'],
        ]);

        // Create the farm manager user
        $manager = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'manager',
            'district_id' => $validated['district_id'],
        ]);

        // Create the farm and assign to manager
        Farm::create([
            'district_id' => $validated['district_id'],
            'name' => $validated['farm_name'],
            'manager_id' => $manager->id,
            'location' => $validated['location'] ?? null,
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

        $districts = District::orderBy('name')->get();
        $manager->load('farm');
        return view('admin.managers.edit', compact('manager', 'districts'));
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
            'farm_name' => ['required', 'string', 'max:255'],
            'location' => ['nullable', 'string', 'max:255'],
        ]);

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

        // Update farm
        $farm = $manager->farm;
        if ($farm) {
            $farm->update([
                'district_id' => $validated['district_id'],
                'name' => $validated['farm_name'],
                'location' => $validated['location'] ?? null,
            ]);
        }

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
