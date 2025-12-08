<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\District;
use Illuminate\Http\Request;

class DistrictController extends Controller
{
    /**
     * Display a listing of districts.
     */
    public function index()
    {
        $districts = District::withCount(['farms', 'managers'])
            ->latest()
            ->paginate(15);

        return view('admin.districts.index', compact('districts'));
    }

    /**
     * Show the form for creating a new district.
     */
    public function create()
    {
        return view('admin.districts.create');
    }

    /**
     * Store a newly created district.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:districts'],
        ]);

        District::create($validated);

        return redirect()
            ->route('admin.districts.index')
            ->with('success', 'District created successfully!');
    }

    /**
     * Show the form for editing the specified district.
     */
    public function edit(District $district)
    {
        return view('admin.districts.edit', compact('district'));
    }

    /**
     * Update the specified district.
     */
    public function update(Request $request, District $district)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:districts,name,' . $district->id],
        ]);

        $district->update($validated);

        return redirect()
            ->route('admin.districts.index')
            ->with('success', 'District updated successfully!');
    }

    /**
     * Remove the specified district.
     */
    public function destroy(District $district)
    {
        $district->delete();

        return redirect()
            ->route('admin.districts.index')
            ->with('success', 'District deleted successfully!');
    }
}
