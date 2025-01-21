<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\AreaLocation;
use Illuminate\Http\Request;

class AreaLocationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
       
            $tabActive = $request->input('tab-active', 'users');
            $searchTerm = $request->input('search');
            $area = $request->input('area');
    
            // Base query with necessary joins
            $usersListQuery = AreaLocation::select(
                    'area_location.*'
                );
    
            
            if ($tabActive === 'area') {
                if ($request->filled('Lock')) {
                    $usersListQuery->where('details.is_lock', $request->input('Lock'));
                }
    
                if ($request->filled('status')) {
                    $usersListQuery->where('service_details.status', $request->input('status'));
                }
            }
    
            // Other filters (e.g., status) if applicable
            if ($request->filled('status')) {
                $usersListQuery->where('service_details.status', $request->input('status'));
            }
    
            // Prepare filter options for the dropdown
            $areaFilter = [
                'area' => AreaLocation::distinct()->pluck('area', 'area')->toArray(),
            ];
    
            // Paginate the results
            $data = $usersListQuery->paginate(10)->withQueryString();
    
            // Return the view with data
            return view('area-location.index', compact('data', 'areaFilter'));
        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (!auth()->user()->isAdmin()) {
            return redirect('/');
        }

        $area = AreaLocation::orderBy('area')->get();

        return view('area-location.create', compact('area'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
