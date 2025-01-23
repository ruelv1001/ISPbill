<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\AreaLocation;
use App\Models\OltDevice;
use App\Models\Pon;
use App\Models\Port;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
class PortController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $tabActive = $request->input('tab-active', 'port');
        $searchTerm = $request->input('search');
        $area = $request->input('port');

        // Base query with necessary joins
        $usersListQuery = Port::select(
            'port.*'
        );


        if ($tabActive === 'port') {
            if ($request->filled('port')) {
                $usersListQuery->where('port.port', $request->input('port'));
            }


        }

        $areaFilter = [
            'port' => Port::distinct()->pluck('port', 'port')->toArray(),
        ];

        // Paginate the results
        $data = $usersListQuery->paginate(10)->withQueryString();

        // Return the view with data
        return view('port.index', compact('data', 'areaFilter'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (!auth()->user()->isAdmin()) {
            return redirect('/');
        }


        $area = Port::orderBy('port')->get();

        return view('port.create', compact('area'));
    }

    /**
     * Store a newly created resource in storage.
     */


    /**
     * Display the specified resource.
     */
    public function store(Request $request)
    {

        $area = new Port();
        $area->port = $request->port;
        $area->description = $request->description;

        $area->save();


        Alert::success('Success!', 'Port Save Successful.');
        return redirect('port');



    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Port $port)
    {
        if (!auth()->user()->isAdmin()) {
            return redirect('/');
        }


        return view('port.edit', compact('port'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $validatedData = $request->validate([
            'port' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
        ]);
        $area = Port::findOrFail($id);
        $area->update([
            'port' => $validatedData['port'],
            'description' => $validatedData['description'] ?? $area->description,
        ]);
        return redirect("/port/{$area->id}/edit")
            ->with("success", __("Port updated successfully"));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

        $areaLocation = Port::find($id);


        if (!$areaLocation) {

            return response()->json(['message' => 'Port not found'], 404);
        }


        $areaLocation->delete();


        return response()->json(['message' => 'Port deleted successfully'], 200);
    }
}
