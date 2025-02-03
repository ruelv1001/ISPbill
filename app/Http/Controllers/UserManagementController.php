<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\UserLimit;
use App\Models\UserType;
use Illuminate\Http\Request;
use App\Models\ServiceDetails;
use App\Models\Setting;
use Illuminate\Support\Facades\DB;
use App\Models\Billing;
use App\Models\Detail;
use App\Models\Package;
use App\Models\Router;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use RouterOS\Client;
use RouterOS\Query;
use App\Models\User;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Log;
class UserManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // public function index()
    // {
    //     if (auth()->user()->isUser()) {
    //         return redirect('/');
    //     }

    //     $users = User::with('detail')->where('role', 'user')->get();
    //     return view('user-management.index', compact('users'));
    // }

    public function index(Request $request)
    {
        $tabActive = $request->input('tab-active', 'user_management');
        $searchTerm = $request->input('search');
        $area = $request->input('area');

        // Base query with necessary joins
        $usersListQuery = User::select('users.*');

        // Apply filters based on tab active
        if ($tabActive === 'user_management') {
            if ($request->filled('role')) {
                $usersListQuery->where('users.role', $request->input('role'));
            } else {
                // Exclude the 'admin' role if no specific role is selected
                $usersListQuery->where('users.role', '!=', 'admin');
            }
        }

        // Prepare filter options for the dropdown
        $areaFilter = [
            'role' => User::distinct()->pluck('role', 'role')->map(function ($role) {
                return strtolower($role);
            })->toArray(),
        ];

        // Paginate the results
        $data = $usersListQuery->paginate(10)->withQueryString();

        // Return the view with data
        return view('user-management.index', compact('data', 'areaFilter'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (!auth()->user()->isAdmin()) {
            return redirect('/');
        }
        $userType = UserType::all();
        $packages = Package::orderBy('name')->get();

        return view('user-management.create', compact('packages', 'userType'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $validatedData = $request->validate([
            "email" => "required|email|unique:users,email",
            "password" => "nullable|min:6|confirmed",
            "name" => "required|string|max:255",
            'role' => ['required', 'string', 'not_in:user'],
        ]);

        // Create the user
        $user = User::create([
            'email' => $validatedData['email'],
            'name' => $validatedData['name'],
            'role' => $validatedData['role'],
            'password' => Hash::make($validatedData['password']),
        ]);






        return redirect()->route('user-management.index')
            ->with('success', __('User added successfully'));
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
    public function edit($id)
    {
        if (!auth()->user()->isAdmin()) {
            return redirect('/');
        }

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



        // Ensure the user exists before proceeding
        $user = User::find($id);
        $user = User::findOrFail($id);
        $userLimit = DB::table('user_limit')->where('user_id', $user->id)->first();


        if (!$user) {
            return redirect()->route('user-management.index')->with('error', 'User not found.');
        }

        return view('user-management.edit', compact('user', 'userLimit', 'permissions'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
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



        $validatedData = $request->validate([
            "email" => "nullable|email|unique:users,email,$id",
            "password" => "nullable|min:6|confirmed",
            "name" => "required|string|max:255",
            'role' => ['required', 'string', 'not_in:user'],
        ] + array_fill_keys($permissions, 'nullable|boolean'));

        // Find user by ID
        $user = User::findOrFail($id);


        // Update user data
        $user->update([
            'email' => $validatedData['email'],
            'name' => $validatedData['name'],
            'role' => $validatedData['role'],
            'password' => $validatedData['password'] ? Hash::make($validatedData['password']) : $user->password,
        ]);

        // Update user limitations
        $userLimitData = ['user_type' => $validatedData['role']];
        foreach ($permissions as $permission) {
            $userLimitData[$permission] = $validatedData[$permission] ?? 0;
        }

        // Update or insert into user_limit table
        DB::table('user_limit')->updateOrInsert(
            ['user_id' => $user->id],
            $userLimitData
        );

        return redirect()->route('user-management.index')->with('success', __('User updated successfully'));
    }




    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        try {
            // Delete the related user_limit record using the user_id
            $userLimit = \App\Models\UserLimit::where('user_id', $user->id)->first();

            if ($userLimit) {
                $userLimit->delete(); // Delete the related user_limit record
            }

            // Then delete the user record
            $user->delete();

            return redirect()->route('user-management.index')->with('success', 'User deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->route('user-management.index')->with('error', 'Error deleting user: ' . $e->getMessage());
        }
    }
}
