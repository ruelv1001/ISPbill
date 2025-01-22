<?php

namespace App\Http\Controllers;

use App\Models\Detail;
use App\Models\ServiceDetails;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use RouterOS\Client;
use RouterOS\Query;
use App\Models\Router;
use RealRashid\SweetAlert\Facades\Alert;
use Carbon\Carbon;
use phpseclib3\Net\SSH2;
class PayBillController extends Controller
{
    public function index()
    {
        if (auth()->user()->isUser()) {
            return redirect('/');
        }

        $users = User::with('service_details')->where('role', 'user')->get();
        return view('paybill.index', compact('users'));


    }





    public function getUser($id)
    {
        $user = User::with('detail')->findOrFail($id);
        return response()->json([
            'id' => $user->id,
            'name' => $user->detail->name ?? '',
            'package_name' => $user->detail->package_name ?? '',
            'package_price' => $user->detail->package_price ?? ''
        ]);
    }

    public function create(User $user,$id)
    {
        if (!auth()->user()->isAdmin()) {
            return redirect('/');
        }



        return view('paybill.create', compact('user'));
    }

    public function due(User $user)
    {
        if (!auth()->user()->isAdmin()) {
            return redirect('/');
        }


        return view('paybill.update-due', compact('user'));
    }



    public function show(User $user)
    {
        if (!auth()->user()->isAdmin()) {
            return redirect('/');
        }

        return view('paybill.create', compact('user'));
    }

    public function edit(User $user)
    {
        if (!auth()->user()->isAdmin()) {
            return redirect('/');
        }


        return view('paybill.edit', compact('user'));
    }

    public function store(Request $request)
    {
        $details = Detail::where('user_id', $request->user_id)->first();
        $current_payable_amount = $details->package_price;

        $paybill = new Transaction();
        $paybill->user_id = $request->user_id;
        $paybill->payment_method = $request->payment_method;
        $paybill->payment_amount = $request->payment_amount;
        $paybill->ref_code = $request->ref_code;
        $paybill->remarks = $request->remarks;
        $paybill->payment_date = now();
        $paybill->save();

        $serviceDetails = ServiceDetails::where('user_id', $request->user_id)->first();

        if ($serviceDetails) {
            $previousDueDate = $serviceDetails->active_due_date;

            // Check if current_payable_amount is not equal to the payment amount
            if ($current_payable_amount != $request->payment_amount) {
                $perdayAmount = $current_payable_amount / 30;
                $noofdays = $request->payment_amount / $perdayAmount;

                // Update active_due_date and billing_date
                $newActiveDueDate = $previousDueDate->addDays($noofdays);
                $newBillingDate = $newActiveDueDate->copy()->addDays(10);

                $serviceDetails->update([
                    'previous_due_date' => $previousDueDate,
                    'active_due_date' => $newActiveDueDate,
                    'billing_date' => $newBillingDate,
                    'status' => "Active",
                ]);
            } else {
                // Default behavior: Extend by 1 month
                $serviceDetails->update([
                    'previous_due_date' => $previousDueDate,
                    'active_due_date' => $serviceDetails->active_due_date->addMonth(),
                    'billing_date' => $serviceDetails->billing_date->addMonth(),
                    'status' => "Active",
                ]);
            }

            if ($serviceDetails->status = "Inactive") {

                $user = User::find($serviceDetails->user_id);
                $router_name = $user->detail->router_name;
                $router = Router::where("name", $router_name)->firstOrFail();

                try {
                    $ssh = new SSH2($router->ip);

                    if (!$ssh->login($router->username, $router->password)) {
                        throw new \Exception('Login failed');
                    }

                    $command = "/ppp/secret enable numbers={$user->id}";
                    $result = $ssh->exec($command);

                    // Optionally handle the result if needed
                    // For example: return back()->with("success", __("Command executed"));

                } catch (\Exception $e) {
                    return back()->with("error", __("Mikrotik connection fails"));
                }

            }
        }
        Alert::success('Success!', 'Payment Successful.');
        return redirect('users');
    }


}
