<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\AreaLocation;
use App\Models\Nap;
use App\Models\OltDevice;
use App\Models\Pon;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
class NapController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $tabActive = $request->input('tab-active', 'nap');
        $searchTerm = $request->input('search');
        $area = $request->input('nap');

        // Base query with necessary joins
        $usersListQuery = Nap::select(
            'nap.*'
        );


        if ($tabActive === 'nap') {
            if ($request->filled('nap')) {
                $usersListQuery->where('nap.nap', $request->input('nap'));
            }


        }

        $areaFilter = [
            'nap' => Nap::distinct()->pluck('nap', 'nap')->toArray(),
        ];

        // Paginate the results
        $data = $usersListQuery->paginate(10)->withQueryString();

        // Return the view with data
        return view('nap.index', compact('data', 'areaFilter'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (!auth()->user()->isAdmin()) {
            return redirect('/');
        }


        $area = Nap::orderBy('nap')->get();

        return view('nap.create', compact('area'));
    }

    /**
     * Store a newly created resource in storage.
     */


    /**
     * Display the specified resource.
     */
    public function store(Request $request)
    {

        $area = new Nap();
        $area->nap = $request->nap;
        $area->description = $request->description;

        $area->save();


        Alert::success('Success!', 'NAP Save Successful.');
        return redirect('pon');



    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Nap $nap)
    {
        if (!auth()->user()->isAdmin()) {
            return redirect('/');
        }


        return view('nap.edit', compact('nap'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $validatedData = $request->validate([
            'nap' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
        ]);
        $area = Nap::findOrFail($id);
        $area->update([
            'nap' => $validatedData['nap'],
            'description' => $validatedData['description'] ?? $area->description,
        ]);
        return redirect("/nap/{$area->id}/edit")
            ->with("success", __("Nap updated successfully"));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

        $areaLocation = Nap::find($id);


        if (!$areaLocation) {

            return response()->json(['message' => 'NAP not found'], 404);
        }


        $areaLocation->delete();


        return response()->json(['message' => 'Nap deleted successfully'], 200);
    }
}
