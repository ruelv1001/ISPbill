<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\AreaLocation;
use App\Models\OltDevice;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
class OltDeviceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $tabActive = $request->input('tab-active', 'olt');
        $searchTerm = $request->input('search');
        $area = $request->input('olt');

        // Base query with necessary joins
        $usersListQuery = OltDevice::select(
            'olt.*'
        );


        if ($tabActive === 'olt_device') {
            if ($request->filled('olt_device')) {
                $usersListQuery->where('olt.olt_device', $request->input('olt'));
            }


        }

        $areaFilter = [
            'olt' => OltDevice::distinct()->pluck('olt_device', 'olt_device')->toArray(),
        ];

        // Paginate the results
        $data = $usersListQuery->paginate(10)->withQueryString();

        // Return the view with data
        return view('olt-device.index', compact('data', 'areaFilter'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (!auth()->user()->isAdmin()) {
            return redirect('/');
        }


        $area = OltDevice::orderBy('olt_device')->get();

        return view('olt-device.create', compact('area'));
    }

    /**
     * Store a newly created resource in storage.
     */


    /**
     * Display the specified resource.
     */
    public function store(Request $request)
    {

        $area = new OltDevice();
        $area->olt_device = $request->olt_device;
        $area->description = $request->description;

        $area->save();


        Alert::success('Success!', 'Area Save Successful.');
        return redirect('olt-device');



    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(OltDevice $oltDevice)
    {
        if (!auth()->user()->isAdmin()) {
            return redirect('/');
        }


        return view('olt-device.edit', compact('oltDevice'));
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
        $area = OltDevice::findOrFail($id);
        $area->update([
            'area' => $validatedData['area'],
            'description' => $validatedData['description'] ?? $area->description,
        ]);
        return redirect("/olt-device/{$area->id}/edit")
            ->with("success", __("Area updated successfully"));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

        $areaLocation = OltDevice::find($id);


        if (!$areaLocation) {

            return response()->json(['message' => 'OLT not found'], 404);
        }


        $areaLocation->delete();


        return response()->json(['message' => 'OLT deleted successfully'], 200);
    }
}
