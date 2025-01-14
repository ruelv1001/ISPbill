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
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Log;
use phpseclib3\Net\SSH2;
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
            "password" => "min:6|confirmed",
            "name" => "required|string|max:255",
            "address" => "required|string",
            "area" => "nullable|in:1,2,3,4,5,6,7,8,9,10",
            "phone" => "required|string",
            "router_id" => "nullable",
            "dob" => "nullable|date",
            "my_profile" => "nullable|in:Profile 1,Profile 2,Profile 3",
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
            $id = str_pad(User::max('id') + 1, 8, '0', STR_PAD_LEFT);
            $user = User::create([
                'id' => $id,
                'name' => str_replace(' ', '_', $validatedData['name']) . '_' . date('Y-m-d'),
                'email' => $validatedData['email'],
                'billing_address' => $validatedData['address'],
                'role' => 'user',
                //  'password' => Hash::make($validatedData['password']),
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
                'router_password' => $validatedData['router_password'],
                'package_name' => $package->name,
                'router_name' => $router->name,
                'package_price' => $package->price,
                'due' => $package->price,
                'status' => 'active',
                'is_lock' => 'unlock',
                'account_number' => $accountNumber,
                'name' => str_replace(' ', '_', $validatedData['name']) . '_' . date('Y-m-d'),
                'area' => $validatedData['area'] ?? null,
                "my_profile" => "nullable|string|in:Profile 1,Profile 2,Profile 3",
                'coordinates' => $validatedData['coordinates'],
                'router_id' => $router->id,
                'package_start' => Carbon::now(),
            ]);
            $currentDateAndTime = Carbon::now();
            $oneMonthdateAndTime = Carbon::now()->addMonth();
            $oneMonthPlusTenDays = Carbon::now()->addMonth()->addDays(10)->toDateString();
            $serviceDetails = ServiceDetails::create([
                'user_id' => $user->id,
                'subscription_date' => $currentDateAndTime,
                'active_due_date' => $oneMonthdateAndTime,
                'billing_date' => $oneMonthdateAndTime,
                'status' => "Active",
            ]);

            // Create billing record
            // $billing = Billing::create([
            //     'user_id' => $user->id,
            //     'invoice' => $this->generateUniqueInvoiceNumber(),
            //     'package_name' => $details->package_name,
            //     'package_price' => $details->package_price,
            //     'package_start' => $details->package_start,

            // ]);

            // Now, run the Mikrotik query with user_id only
            try {
                $client = new Client([
                    "host" => $settings->router_ip,
                    "user" => $settings->router_username,
                    "pass" => $settings->router_password,
                ]);

                $query = new Query("/ppp/secret/add");
              $query->equal("name", str_replace(' ', '_', $user->name) . '_' . date('Y-m-d')); // Use only user_id
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

    // public function edit(User $user)
    // {
    //     if (!auth()->user()->isAdmin()) {
    //         return redirect('/');
    //     }

    //     return view('users.edit', compact('user'));
    // }

    public function edit(User $user)
    {
        if (!auth()->user()->isAdmin()) {
            return redirect('/');
        }

        $myrouter = $user->detail->router_id;

        // Fetch router details
        $router = Router::where("id", $myrouter)->firstOrFail();

        try {
            $ssh = new SSH2($router->ip);

            if (!$ssh->login($router->username, $router->password)) {
                throw new \Exception("SSH login failed");
            }

            // Get system resource info (includes uptime)
            $systemResources = $ssh->exec('/system resource print');

            // Get profile information
            $profiles = $ssh->exec('/ip hotspot user profile print');

            // Get last logged-out timestamp (check logs for 'logout' events)
            $logData = $ssh->exec('/log print where message~"logout"');

            // Parse uptime
            $uptime = '';
            if (preg_match('/uptime: (.+?)(?=\n|$)/', $systemResources, $matches)) {
                $uptime = trim($matches[1]);
            }

            // Parse profiles into structured data
            $profileData = [];
            $profileLines = explode("\n", trim($profiles));
            foreach ($profileLines as $line) {
                if (preg_match('/^\s*\d+\s+(\S+)\s+(.+)$/', $line, $matches)) {
                    $profileData[] = [
                        'name' => trim($matches[1]),
                        'settings' => trim($matches[2])
                    ];
                }
            }

            // Parse the last logged-out entry
            $lastLoggedOut = '';
            if (preg_match('/(\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2})\s+.*logout/', $logData, $matches)) {
                $lastLoggedOut = trim($matches[1]);
            }

            // Structure the data
            $data = [
                'uptime' => $uptime,
                'profiles' => $profileData,
                'router' => [
                    'ip' => $router->ip,
                    'name' => $router->name ?? 'Unknown'
                ],
                'lastLoggedOut' => $lastLoggedOut
            ];


        } catch (\Exception $e) {
            return back()->with("error", __("Mikrotik connection failed: " . $e->getMessage()));
        }
        $routers = Router::all();
        $packages = Package::all();
        // Pass data to the view
        return view('users.edit', compact('user', 'data', 'routers', 'packages'));


    }


    public function update(Request $request, User $user)
    {
        $validatedData = $this->validate($request, [
            "password" => "nullable|min:6|confirmed",
            "address" => "nullable|string|max:255",
            "phone" => "nullable|string|max:15",
            "dob" => "nullable|date",
            "email" => "nullable|email|unique:users,email," . $user->id,
            "name" => "nullable|string|max:255",
            "area" => "nullable|in:1,2,3,4,5,6,7,8,9,10",
            "my_profile" => "nullable|in:Profile 1,Profile 2,Profile 3",
            "coordinates" => "nullable|string",
            "is_lock" => "nullable|string",
            "package_name" => "nullable|exists:packages,name",
            "router_name" => "nullable|exists:routers,name",
            "router_password" => "nullable|string",
            "subscription_date" => "nullable|date",
            "active_due_date" => "nullable|date",
            "billing_date" => "nullable|date",
        ]);

        if (filled($validatedData['password'])) {
            $user->password = Hash::make($validatedData['password']);
        }
        $user->name = $validatedData['name'] ?? $user->name;
        $user->email = $validatedData['email'] ?? $user->email;
        $user->save();

        $details = Detail::firstWhere('user_id', $user->id);

        if ($details) {
            $details->update([
                'name' => $validatedData['name'] ?? $details->name,
                'phone' => $validatedData['phone'] ?? $details->phone,
                'address' => $validatedData['address'] ?? $details->address,
                'dob' => $validatedData['dob'] ?? $details->dob,
                'router_password' => $validatedData['router_password'] ?? $details->router_password,
                'package_name' => $validatedData['package_name'] ?? $details->package_name,
                'router_name' => $validatedData['router_name'] ?? $details->router_name,
                'area' => $validatedData['area'] ?? $details->area,
                'my_profile' => $validatedData['my_profile'] ?? $details->my_profile,
                'coordinates' => $validatedData['coordinates'] ?? $details->coordinates,
                'is_lock' => $validatedData['is_lock'] ?? $details->is_lock,
            ]);
        }

        ServiceDetails::updateOrCreate(
            ['user_id' => $user->id],
            [
                'subscription_date' => $validatedData['subscription_date'] ?? null,
                'active_due_date' => $validatedData['active_due_date'] ?? null,
                'billing_date' => $validatedData['billing_date'] ?? null,
            ]
        );
        return redirect("/users/{$user->id}/edit")
            ->with("success", __("User updated successfully"));

    }



    public function destroy(User $user)
    {
        try {


            $hasTransaction = \DB::table('transaction')->where('user_id', $user->id)->exists();

            if ($hasTransaction) {

                Alert::warning('Warning!', 'Consumer has transaction data');
                return redirect()->route('users.index');
            }


            \DB::table('details')->where('user_id', $user->id)->delete();
            \DB::table('service_details')->where('user_id', $user->id)->delete();


            $user->delete();

            return redirect()->route('users.index')->with('success', 'User deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->route('users.index')->with('error', 'Error deleting user: ' . $e->getMessage());
        }
    }


    public function archieve_data(User $user)
    {
        try {
            // Check if the user has associated transactions
            $hasTransaction = \DB::table('transaction')->where('user_id', $user->id)->exists();

            if ($hasTransaction) {
                Alert::warning('Warning!', 'Consumer has transaction data');
                return redirect()->route('users.index');
            }

            // Archive and delete details
            $details = \DB::table('details')->where('user_id', $user->id)->get();
            if ($details->isNotEmpty()) {
                $archiveDetails = $details->map(function ($detail) {
                    return (array) $detail;
                })->toArray();

                \DB::table('archieve_details')->insert($archiveDetails);
                \DB::table('details')->where('user_id', $user->id)->delete();
            }

            // Archive and delete service details


            // Delete the user
            //$user->delete();

            return redirect()->route('users.index')->with('success', 'User  data archived successfully.');
        } catch (\Exception $e) {
            return redirect()->route('users.index')->with('error', 'Error deleting user: ' . $e->getMessage());
        }
    }


    public function destroyother(User $user)
    {
        try {


            $hasTransaction = \DB::table('transaction')->where('user_id', $user->id)->exists();

            if ($hasTransaction) {

                Alert::warning('Warning!', 'Consumer has transaction data');
                return redirect()->route('users.index');
            }


            \DB::table('details')->where('user_id', $user->id)->delete();
            \DB::table('service_details')->where('user_id', $user->id)->delete();


            $user->delete();

            return redirect()->route('user-management.index')->with('success', 'User deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->route('user-management.index')->with('error', 'Error deleting user: ' . $e->getMessage());
        }
    }

}
