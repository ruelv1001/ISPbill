<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
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
    public function index()
    {
        if (auth()->user()->isUser()) {
            return redirect('/');
        }

        $users = User::with('detail')->where('role', 'user')->get();
        return view('user-management.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (!auth()->user()->isAdmin()) {
            return redirect('/');
        }

        $packages = Package::orderBy('name')->get();
        return view('user-management.create', compact('packages'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            "email" => "required|email|unique:users,email",
            "password" => "required|min:6|confirmed",
            "first_name" => "required|string|max:255",
            "last_name" => "required|string|max:255",
            "address" => "required|string",
            "role" => "required|string",
 
        ]);

        $user = User::create([
            'email' => $validatedData['email'],
            'name' => $validatedData['first_name'] . ' ' . $validatedData['last_name'],
            'billing_address' => $validatedData['address'],
            'role' =>  $validatedData['role'],
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
    public function edit(User $user)
    {
        if (!auth()->user()->isAdmin()) {
            return redirect('/');
        }

        return view('user-management.edit', compact('user'));
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
    public function destroy(User $user)
    {
        try {


            $user->delete();

            return redirect()->route('user-management.index')->with('success', 'User deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->route('user-management.index')->with('error', 'Error deleting user: ' . $e->getMessage());
        }
    }
}
