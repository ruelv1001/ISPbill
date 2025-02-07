<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\AreaLocation;
use App\Models\User;
use App\Models\UserType;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
class UserTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $tabActive = $request->input('tab-active', 'user-type');
        $searchTerm = $request->input('search');
        $area = $request->input('area');

        // Base query with necessary joins
        $usersListQuery = UserType::select(
            'user_type.*'
        );


        if ($tabActive === 'user-type') {
            if ($request->filled('role')) {
                $usersListQuery->where('users.role', $request->input('role'));
            }


        }


        // Prepare filter options for the dropdown
        $areaFilter = [
            'role' => User::distinct()->pluck('role', 'role')->toArray(),
        ];

        // Paginate the results
        $data = $usersListQuery->paginate(10)->withQueryString();

        // Return the view with data
        return view('user-type.index', compact('data', 'areaFilter'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (!auth()->user()->isAdmin()) {
            return redirect('/');
        }


        $data = UserType::orderBy('role')->get();

        return view('user-type.create', compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     */


    /**
     * Display the specified resource.
     */
    public function store(Request $request)
    {
        $permissions = [
            'dashboard_create',
            'dashboard_edit',
            'dashboard_delete',
            'dashboard_view',
            'packages_create',
            'packages_edit',
            'packages_delete',
            'packages_view',
            'customer_create',
            'customer_edit',
            'customer_delete',
            'customer_view',
            'service_detail_create',
            'service_detail_edit',
            'service_detail_delete',
            'service_detail_view',
            'transaction_create',
            'transaction_edit',
            'transaction_delete',
            'transaction_view',
            'router_create',
            'router_edit',
            'router_delete',
            'router_view',
            'user_management_create',
            'user_management_edit',
            'user_management_delete',
            'user_management_view',
            'tickets_create',
            'tickets_edit',
            'tickets_delete',
            'tickets_view',
            'dashboard_table',
            'package_table',
            'customer_table',
            'service_detail_table',
            'transaction_table',
            'router_table',
            'user_management_table',
            'ticket_table',
        ];

        $query = new UserType();
        $query->role = $request->role;
        $query->description = $request->description;

        $query->save();

        $userLimitData = ['user_type' => $request->role];
        foreach ($permissions as $permission) {
            $userLimitData[$permission] = $request->input($permission, 0); // Default to 0 if permission not selected
        }

        // Insert into user_limit table
        \DB::table('user_limit')->insert($userLimitData);

        Alert::success('Success!', 'Role Save Successful.');
        return redirect('user-type');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(UserType $user_type)
    {
        if (!auth()->user()->isAdmin()) {
            return redirect('/');
        }

        return view('user-type.edit', compact('user_type'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $validatedData = $request->validate([
            'role' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
        ]);
        $query = UserType::findOrFail($id);
        $query->update([
            'role' => $validatedData['role'],
            'description' => $validatedData['description'] ?? $query->description,
        ]);
        return redirect("/user-type/{$query->id}/edit")
            ->with("success", __("User Type updated successfully"));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

        $query = UserType::find($id);


        if (!$query) {

            return response()->json(['message' => 'UserType not found'], 404);
        }


        $query->delete();


        return response()->json(['message' => 'User Type deleted successfully'], 200);
    }
}
