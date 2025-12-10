<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Farm;
use App\Models\District;
use App\Models\User;
use Illuminate\Http\Request;

class FarmController extends Controller
{
    /**
     * Display a listing of farms.
     */
    public function index()
    {
        $farms = Farm::with(['district', 'manager'])
            ->latest()
            ->paginate(15);

        return view('admin.farms.index', compact('farms'));
    }

    /**
     * Show the form for creating a new farm.
     */
    public function create()
    {
        $districts = District::allowed()->orderBy('name')->get();
        $managers = User::where('role', 'manager')
            ->whereDoesntHave('farm')
            ->orderBy('name')
            ->get();

        return view('admin.farms.create', compact('districts', 'managers'));
    }

    /**
     * Store a newly created farm.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'district_id' => ['required', 'exists:districts,id'],
            'manager_id' => ['required', 'exists:users,id'],
            'location' => ['nullable', 'string', 'max:255'],
        ]);

        // Check if manager already has a farm
        $manager = User::findOrFail($validated['manager_id']);
        if ($manager->farm) {
            return back()
                ->withInput()
                ->withErrors(['manager_id' => 'This manager already has a farm assigned.']);
        }

        Farm::create($validated);

        return redirect()
            ->route('admin.farms.index')
            ->with('success', 'Farm created successfully!');
    }

    /**
     * Show the form for editing the specified farm.
     */
    public function edit(Farm $farm)
    {
        $districts = District::allowed()->orderBy('name')->get();
        $managers = User::where('role', 'manager')
            ->where(function($query) use ($farm) {
                $query->whereDoesntHave('farm')
                      ->orWhere('id', $farm->manager_id);
            })
            ->orderBy('name')
            ->get();

        return view('admin.farms.edit', compact('farm', 'districts', 'managers'));
    }

    /**
     * Update the specified farm.
     */
    public function update(Request $request, Farm $farm)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'district_id' => ['required', 'exists:districts,id'],
            'manager_id' => ['required', 'exists:users,id'],
            'location' => ['nullable', 'string', 'max:255'],
        ]);

        // Check if new manager already has a farm
        if ($validated['manager_id'] != $farm->manager_id) {
            $manager = User::findOrFail($validated['manager_id']);
            if ($manager->farm && $manager->farm->id != $farm->id) {
                return back()
                    ->withInput()
                    ->withErrors(['manager_id' => 'This manager already has a farm assigned.']);
            }
        }

        $farm->update($validated);

        return redirect()
            ->route('admin.farms.index')
            ->with('success', 'Farm updated successfully!');
    }

    /**
     * Remove the specified farm.
     */
    public function destroy(Farm $farm)
    {
        $farm->delete();

        return redirect()
            ->route('admin.farms.index')
            ->with('success', 'Farm deleted successfully!');
    }

    /**
     * Get farms by district (API endpoint for dropdown)
     */
    public function getFarmsByDistrict(Request $request, District $district)
    {
        $query = Farm::where('district_id', $district->id);
        
        // Include farms without managers, or a specific farm if provided (for editing)
        $query->where(function($q) use ($request) {
            $q->whereNull('manager_id');
            if ($request->has('include_farm_id')) {
                $q->orWhere('id', $request->input('include_farm_id'));
            }
        });
        
        $farms = $query->orderBy('name')->get(['id', 'name']);

        return response()->json($farms);
    }
}
