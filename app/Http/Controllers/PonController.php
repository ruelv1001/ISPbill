<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\AreaLocation;
use App\Models\OltDevice;
use App\Models\Pon;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
class PonController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $tabActive = $request->input('tab-active', 'pon');
        $searchTerm = $request->input('search');
        $area = $request->input('pon');

        // Base query with necessary joins
        $usersListQuery = Pon::select(
            'pon.*'
        );


        if ($tabActive === 'pon') {
            if ($request->filled('pon')) {
                $usersListQuery->where('pon.pon', $request->input('pon'));
            }


        }

        $areaFilter = [
            'pon' => Pon::distinct()->pluck('pon', 'pon')->toArray(),
        ];

        // Paginate the results
        $data = $usersListQuery->paginate(10)->withQueryString();

        // Return the view with data
        return view('pon.index', compact('data', 'areaFilter'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (!auth()->user()->isAdmin()) {
            return redirect('/');
        }


        $area = Pon::orderBy('pon')->get();

        return view('pon.create', compact('area'));
    }

    /**
     * Store a newly created resource in storage.
     */


    /**
     * Display the specified resource.
     */
    public function store(Request $request)
    {

        $area = new Pon();
        $area->pon = $request->pon;
        $area->description = $request->description;

        $area->save();


        Alert::success('Success!', 'PON Save Successful.');
        return redirect('pon');



    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pon $pon)
    {
        if (!auth()->user()->isAdmin()) {
            return redirect('/');
        }


        return view('pon.edit', compact('pon'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $validatedData = $request->validate([
            'pon' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
        ]);
        $area = Pon::findOrFail($id);
        $area->update([
            'pon' => $validatedData['pon'],
            'description' => $validatedData['description'] ?? $area->description,
        ]);
        return redirect("/pon/{$area->id}/edit")
            ->with("success", __("Pon updated successfully"));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

        $areaLocation = Pon::find($id);


        if (!$areaLocation) {

            return response()->json(['message' => 'Pon not found'], 404);
        }


        $areaLocation->delete();


        return response()->json(['message' => 'Pon deleted successfully'], 200);
    }
}
