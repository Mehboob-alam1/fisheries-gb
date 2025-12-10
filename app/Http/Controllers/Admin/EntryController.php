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
        $districts = District::orderBy('name')->get();
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
        $entry->load(['farm.district', 'farm.manager']);
        return view('admin.entries.show', compact('entry'));
    }
}
