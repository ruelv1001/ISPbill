<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\AreaLocation;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
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


    /**
     * Display the specified resource.
     */
    public function store(Request $request)
    {

        $area = new AreaLocation();
        $area->area = $request->area;
        $area->description = $request->description;

        $area->save();


        Alert::success('Success!', 'Area Save Successful.');
        return redirect('area-location');



    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AreaLocation $areaLocation)
    {
        if (!auth()->user()->isAdmin()) {
            return redirect('/');
        }


        return view('area-location.edit', compact('areaLocation'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $validatedData = $request->validate([
            'area' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
        ]);
        $area = AreaLocation::findOrFail($id);
        $area->update([
            'area' => $validatedData['area'],
            'description' => $validatedData['description'] ?? $area->description,
        ]);
        return redirect("/area-location/{$area->id}/edit")
            ->with("success", __("Area updated successfully"));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

        $areaLocation = AreaLocation::find($id);


        if (!$areaLocation) {

            return response()->json(['message' => 'AreaLocation not found'], 404);
        }


        $areaLocation->delete();


        return response()->json(['message' => 'AreaLocation deleted successfully'], 200);
    }
}
