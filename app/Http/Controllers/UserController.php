<?php

namespace App\Http\Controllers;
use App\Models\ServiceDetails;
use App\Models\Setting;
use Illuminate\Support\Facades\DB;
use App\Models\Billing;
use App\Models\Detail;
use App\Models\Package;
use App\Models\Router;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use RouterOS\Client;
use RouterOS\Query;
use App\Models\User;

use Illuminate\Support\Facades\Log;
class UserController extends Controller
{
    public function __construct()
    {
        //
    }

    public function index()
    {
        if (auth()->user()->isUser()) {
            return redirect('/');
        }

        $users = User::with('detail')->where('role', 'user')->get();
        return view('users.index', compact('users'));
    }

    public function create()
    {
        if (!auth()->user()->isAdmin()) {
            return redirect('/');
        }

        $packages = Package::orderBy('name')->get();
        return view('users.create', compact('packages'));
    }


    private function generateUniqueInvoiceNumber()
    {
        $prefix = 'INV';
        $year = date('Y');
        $month = date('m');

        // Get the latest invoice number from the database
        $latestInvoice = Billing::latest()->first();

        if ($latestInvoice) {
            // Extract the numeric part of the last invoice number
            $lastNumber = (int) substr($latestInvoice->invoice, -4);
            $nextNumber = $lastNumber + 1;
        } else {
            $nextNumber = 1;
        }

        // Format the number to be 4 digits with leading zeros
        $formattedNumber = str_pad($nextNumber, 4, '0', STR_PAD_LEFT);

        // Generate the invoice number in format: INV-YYYYMM-0001
        $invoiceNumber = "{$prefix}-{$year}{$month}-{$formattedNumber}";

        // Make sure this invoice number is unique
        while (Billing::where('invoice', $invoiceNumber)->exists()) {
            $nextNumber++;
            $formattedNumber = str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
            $invoiceNumber = "{$prefix}-{$year}{$month}-{formattedNumber}";
        }

        return $invoiceNumber;
    }
    public function store(Request $request)
    {
        // Validate the request with more flexible rules
        $validatedData = $request->validate([
            "email" => "required|email|unique:users,email",
            "password" => "required|min:6|confirmed",
            "first_name" => "required|string|max:255",
            "last_name" => "required|string|max:255",
            "address" => "required|string",
            "area" => "nullable|in:1,2,3,4,5,6,7,8,9,10",
            "phone" => "required|string",
            "dob" => "nullable|date",
            "pin" => "required|string",
            "my_profile" => "required|in:Profile 1,Profile 2,Profile 3",
            "coordinates" => "required|string",
            "package_name" => "required|exists:packages,id",
            "router_name" => "required|exists:routers,id",
            "router_password" => "required|string",
        ]);

        // Start a database transaction for better error handling
        DB::beginTransaction();

        $settings = Setting::firstOrFail();
        $package = Package::where("id", $request->package_name)->firstOrFail();

        try {
            // Create user
            $user = User::create([
                'email' => $validatedData['email'],
                'billing_address' => $validatedData['address'],
                'role' => 'user',
                'password' => Hash::make($validatedData['password']),
            ]);

            // Retrieve package and router
            $package = Package::findOrFail($validatedData['package_name']);
            $router = Router::findOrFail($validatedData['router_name']);

            // Create user details
            $accountNumber = $user->id . '-' . now()->format('YmdHis');
            $details = Detail::create([
                'user_id' => $user->id,
                'phone' => $validatedData['phone'],
                'address' => $validatedData['address'],
                'dob' => $validatedData['dob'],
                'pin' => $validatedData['pin'],
                'router_password' => $validatedData['router_password'],
                'package_name' => $package->name,
                'router_name' => $router->name,
                'package_price' => $package->price,
                'due' => $package->price,
                'status' => 'active',
                'account_number' => $accountNumber,
                'first_name' => $validatedData['first_name'],
                'last_name' => $validatedData['last_name'],
                'area' => $validatedData['area'] ?? null,
                'my_profile' => $validatedData['my_profile'],
                'coordinates' => $validatedData['coordinates'],
                'package_start' => Carbon::now(),
            ]);
            $currentDateAndTime = Carbon::now();
            $oneMonthdateAndTime = Carbon::now()->addMonth();
            $oneMonthPlusTenDays = Carbon::now()->addMonth()->addDays(10)->toDateString();
            $serviceDetails = ServiceDetails::create([
                'user_id' => $user->id,
                'subscription_date' => $currentDateAndTime,
                'active_due_date' => $oneMonthdateAndTime,
                'billing_date' => $oneMonthPlusTenDays,
                'status' => "Active",
            ]);

            // Create billing record
            $billing = Billing::create([
                'user_id' => $user->id,
                'invoice' => $this->generateUniqueInvoiceNumber(),
                'package_name' => $details->package_name,
                'package_price' => $details->package_price,
                'package_start' => $details->package_start,

            ]);

            // Now, run the Mikrotik query with user_id only
            try {
                $client = new Client([
                    "host" => $settings->router_ip,
                    "user" => $settings->router_username,
                    "pass" => $settings->router_password,
                ]);

                $query = new Query("/ppp/secret/add");
                $query->equal("name", $user->id);  // Use only user_id
                $query->equal("password", $validatedData['router_password']);
                $query->equal("service", 'any');
                $query->equal("profile", $package->name);

                $client->query($query)->read();
            } catch (\Exception $e) {
                // Log the error for debugging
                Log::error('Failed to create Mikrotik user.', [
                    'error_message' => $e->getMessage(),
                    'stack_trace' => $e->getTraceAsString(),
                    'request_data' => $request->all(),
                ]);

                // Rollback the transaction
                DB::rollBack();

                return back()->with("error", __("Mikrotik connection fails"));
            }

            // Commit the transaction
            DB::commit();

            // Redirect with success message
            return redirect()->route('users.index')
                ->with('success', __('User added successfully'));

        } catch (\Exception $e) {
            // Rollback the transaction
            DB::rollBack();

            // Log the error
            Log::error('User creation failed: ' . $e->getMessage(), [
                'request_data' => $request->except('password', 'password_confirmation')
            ]);

            // Redirect back with error message
            return back()->withInput($request->except(['password', 'password_confirmation']))
                ->with('error', __('User creation failed: ') . $e->getMessage());
        }
    }
    public function show(User $user)
    {
        if (!auth()->user()->isAdmin()) {
            return redirect('/');
        }

        return view('users.show', compact('user'));
    }

    public function edit(User $user)
    {
        if (!auth()->user()->isAdmin()) {
            return redirect('/');
        }

        return view('users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $this->validate($request, [
            "password" => "nullable|min:6|confirmed",
            "address" => "required",
            "phone" => "required",
            "dob" => "required",
        ]);

        if (filled($request->password)) {
            $user->password = Hash::make($request->password);
        }
        $user->save();

        $details = Detail::firstWhere('user_id', $user->id);
        $details->phone = $request->phone;
        $details->address = $request->address;
        $details->dob = $request->dob;
        $details->pin = $request->pin;
        $details->save();

        return redirect("users")->with("success", __("User added successfully"));
    }
}
