<?php

namespace App\Http\Controllers;

use App\Models\AreaLocation;
use App\Models\ServiceDetails;
use App\Models\Setting;
use App\Models\UserType;
use Illuminate\Support\Facades\DB;
use App\Models\Billing;
use App\Models\Detail;
use App\Models\MikrotikParamter;
use App\Models\Nap;
use App\Models\OltDevice;
use App\Models\Package;
use App\Models\Pon;
use App\Models\Port;
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
use App\Services\BreadcrumbService;
class UserController extends Controller
{
    public function __construct(BreadcrumbService $breadcrumbs)
    {
        $this->breadcrumbs = $breadcrumbs;
    }
    private function generateFilterData($data, $item = 'id')
    {
        $filter = array();
        foreach ($data as $value) {
            if ($item == 'id') {
                $filter[$value->id] = $value->name;
            } elseif ($item == 'value') {
                $filter[$value] = $value;
            }
        }
        return $filter;
    }


    public function index(Request $request)
    {
        $tabActive = $request->input('tab-active', 'users');
        $searchTerm = $request->input('search');
        $isLock = $request->input('is_lock');
        $arearequest = $request->input('area');

        // Base query with necessary joins
        $usersListQuery = User::join('service_details', 'users.id', '=', 'service_details.user_id')
            ->join('details', 'users.id', '=', 'details.user_id')
            ->leftJoin('miktrotik_parameters', 'users.id', '=', 'miktrotik_parameters.user_id')
            ->select(
                'users.*',
                'service_details.*',
                'details.user_id as id',
                'details.is_lock as is_lock',
                'details.package_name as package_name',
                'details.remarks as remarks',
                'details.area as area',
                'miktrotik_parameters.uptime',
                'miktrotik_parameters.down_time',
                DB::raw("CONCAT(miktrotik_parameters.uptime, ' / ', miktrotik_parameters.down_time) AS uptime_info"),
                DB::raw("CONCAT(miktrotik_parameters.last_login, ' / ', miktrotik_parameters.last_logout) AS log_info")
            );


        if ($tabActive === 'user') {
            if ($request->filled('Lock')) {
                $usersListQuery->where('details.is_lock', $request->input('Lock'));
            }

            if ($request->filled('status')) {
                $usersListQuery->where('service_details.status', $request->input('status'));
            }

            if ($request->filled('Area')) {
                $usersListQuery->where('details.area', $request->input('Area'));
            }
            if ($request->filled('olt')) {
                $usersListQuery->where('details.olt', $request->input('olt'));
            }
            if ($request->filled('pon')) {
                $usersListQuery->where('details.pon', $request->input('pon'));
            }
            if ($request->filled('nap')) {
                $usersListQuery->where('details.nap', $request->input('nap'));
            }
            if ($request->filled('port')) {
                $usersListQuery->where('details.port', $request->input('port'));
            }

        }

        // Other filters (e.g., status) if applicable
        if ($request->filled('status')) {
            $usersListQuery->where('service_details.status', $request->input('status'));
        }

        // Prepare filter options for the dropdown
        $userFilter = [
            'status' => ServiceDetails::distinct()->pluck('status', 'status')->toArray(),
            'Area' => Detail::distinct()->pluck('area', 'area')->toArray(),
            'Lock' => Detail::distinct()->pluck('is_lock', 'is_lock')->toArray(), // Fetch `is_lock` options
            'olt' => OltDevice::distinct()->pluck('olt_device', 'olt_device')->toArray(),
            'pon' => Pon::distinct()->pluck('pon', 'pon')->toArray(),
            'nap' => Nap::distinct()->pluck('nap', 'nap')->toArray(),
            'port' => Port::distinct()->pluck('port', 'port')->toArray(),
        ];

        // Paginate the results
        $users = $usersListQuery->paginate(10)->withQueryString();

        // Return the view with data
        return view('users.index', compact('users', 'userFilter'));
    }




    public function create()
    {
        if (!auth()->user()->isAdmin()) {
            return redirect('/');
        }

        $areas = AreaLocation::all();
        $olt = OltDevice::all();
        $pon = Pon::all();
        $port = Port::all();
        $nap = Nap::all();
        $packages = Package::orderBy('name')->get();
        $role = UserType::all();
        return view('users.create', compact('packages', 'areas', 'olt', 'pon', 'port', 'nap', 'role'));// Ensure 'areas' is passed
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
            "area" => "nullable",
            "phone" => "required|string",
            "router_id" => "nullable",
            "dob" => "nullable|date",
            "my_profile" => "nullable|in:Profile 1,Profile 2,Profile 3",
            "coordinates" => "required|string",
            "package_name" => "required|exists:packages,id",
            "router_name" => "required|exists:routers,id",
            "router_password" => "required|string",
            "olt" => "nullable",
            "pon" => "nullable",
            "port" => "nullable",
            "nap" => "nullable",
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
                'olt' => $validatedData['olt'],
                'pon' => $validatedData['pon'],
                'port' => $validatedData['port'],
                'nap' => $validatedData['nap'],
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


                $query = new Query("/ppp/profile/print");

                // Send the query and fetch the results
                $profiles = $client->query($query)->read();

                // Now filter the profiles based on the $package->name
                foreach ($profiles as $profile) {
                    $onUp = $profile['on-up'] ?? 'No script set';  // Check if 'on-up' is empty
                    $onDown = $profile['on-down'] ?? 'No script set';  // Check if 'on-down' is empty

                    // Print the values
                    echo "On-Up: " . $onUp . "\n";
                    echo "On-Down: " . $onDown . "\n";



                }

                // Display the filtered profiles (this would print out the profile data)


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

            $mtDetails = MikrotikParamter::create([
                'user_id' => $user->id,
                'uptime' => $onUp,
                'down_time' => $onDown,
                'router_name' => $router->name,
                'router_ip' => $router->ip,
            ]);

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

            $areas = AreaLocation::all();
            $olt = OltDevice::all();
            $pon = Pon::all();
            $port = Port::all();
            $nap = Nap::all();
            $area = AreaLocation::all();

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
        return view('users.edit', compact('user', 'data', 'routers', 'packages', 'areas', 'olt', 'nap', 'port', 'pon', 'area'));


    }


    public function update(Request $request, User $user)
    {
        $validatedData = $this->validate($request, [
            "address" => "nullable|string|max:255",
            "phone" => "nullable|string|max:15",
            "email" => "nullable|email|unique:users,email," . $user->id,
            "name" => "nullable|string|max:255",
            "area" => "nullable|in:1,2,3,4,5,6,7,8,9,10",
            "my_profile" => "nullable|in:Profile 1,Profile 2,Profile 3",
            "coordinates" => "nullable|string",
            // "package_name" => "nullable|exists:packages,name",
            // "router_name" => "nullable|exists:routers,name",
            // "router_password" => "nullable|string",
            "subscription_date" => "nullable|date",
            "active_due_date" => "nullable|date",
            "billing_date" => "nullable|date",
            "olt" => "nullable|string",
            "pon" => "nullable|string",
            "port" => "nullable|string",
            "nap" => "nullable|string",
        ]);



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
                // 'router_password' => $validatedData['router_password'] ?? $details->router_password,
                // 'package_name' => $validatedData['package_name'] ?? $details->package_name,
                // 'router_name' => $validatedData['router_name'] ?? $details->router_name,
                'area' => $validatedData['area'] ?? $details->area,
                'my_profile' => $validatedData['my_profile'] ?? $details->my_profile,
                'coordinates' => $validatedData['coordinates'] ?? $details->coordinates,
                'is_lock' => $validatedData['is_lock'] ?? $details->is_lock,
                'olt' => $validatedData['olt'] ?? $details->olt,
                'pon' => $validatedData['pon'] ?? $details->pon,
                'port' => $validatedData['port'] ?? $details->port,
                'nap' => $validatedData['nap'] ?? $details->nap,
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



    public function destroynew(User $user)
    {
        try {
            $hasTransaction = \DB::table('transaction')->where('user_id', $user->id)->exists();

            if ($hasTransaction) {
                Alert::warning('Warning!', 'Consumer has transaction data');
                return redirect()->route('users.index');
            }

            // Check if there are any details with is_lock set to 'lock'
            $lockedDetails = \DB::table('details')->where('user_id', $user->id)->where('is_lock', 'lock')->exists();

            if ($lockedDetails) {
                Alert::warning('Warning!', 'Cannot delete user because some details are locked.');
                return redirect()->route('users.index');
            }

            // Proceed with deletion if no locked details
            \DB::table('details')->where('user_id', $user->id)->where('is_lock', '!=', 'lock')->delete();
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


    public function destroy(User $user)
    {
        \Log::info('Deleting user:', ['user_id' => $user->id]); // Log the user ID

        try {
            // Check if the user has transaction data
            $hasTransaction = \DB::table('transaction')->where('user_id', $user->id)->exists();

            if ($hasTransaction) {
                \Log::warning('User has transaction data:', ['user_id' => $user->id]); // Log warning
                return response()->json(['message' => 'Consumer has transaction data'], 400);
            }

            // Check if any detail record is locked
            $isLocked = \DB::table('details')
                ->where('user_id', $user->id)
                ->where('is_lock', 'lock')
                ->exists();

            if ($isLocked) {
                \Log::warning('User details are locked:', ['user_id' => $user->id]); // Log warning
                return response()->json(['message' => 'User details are locked and cannot be deleted'], 400);
            }

            // Proceed with deletion if no locks are found
            \DB::table('details')->where('user_id', $user->id)->delete();
            \DB::table('service_details')->where('user_id', $user->id)->delete();

            $user->delete();
            \Log::info('User deleted successfully:', ['user_id' => $user->id]); // Log success
            return response()->json(['message' => 'User deleted successfully'], 200);

        } catch (\Exception $e) {
            \Log::error('Error deleting user:', ['user_id' => $user->id, 'error' => $e->getMessage()]); // Log error
            return response()->json(['message' => 'User deletion failed'], 500);
        }
    }


    public function bulkLock(Request $request)
    {
        try {
            if (!$request->has('ids') || empty($request->ids)) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'No users selected for locking'
                ], 400);
            }

            $ids = explode(',', $request->ids);

            // Validate that we have valid IDs
            if (empty($ids)) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Invalid selection of users'
                ], 400);
            }

            Log::info('Locking users with IDs:', ['ids' => $ids]);

            $updated = Detail::whereIn('user_id', $ids)->update([
                'is_lock' => "lock"
            ]);

            if ($updated) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Selected users have been locked successfully'
                ]);
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'No users were updated'
                ]);
            }
        } catch (\Exception $e) {
            Log::error('Error in bulkLock:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred while locking users'
            ], 500);
        }
    }

}
