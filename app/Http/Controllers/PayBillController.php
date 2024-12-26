<?php

namespace App\Http\Controllers;

use App\Models\Detail;
use App\Models\ServiceDetails;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;

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



    public function create(User $user)
    {
        if (!auth()->user()->isAdmin()) {
            return redirect('/');
        }


        return view('paybill.create', compact('user'));
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

        $paybill = new Transaction();
<div class=""></div>quest->payment_method;
        $paybill->payment_amount = $request->payment_amount;
        $paybill->ref_code = $request->ref_code;
        $paybill->remarks = $request->remarks;
        $paybill->payment_date = now();
        $paybill->save();


        $serviceDetails = ServiceDetails::where('user_id', $request->user_id)->first();


        if ($serviceDetails) {
            $previousDueDate = $serviceDetails->active_due_date;
            $serviceDetails->update([
                'previous_due_date' => $previousDueDate,
                'active_due_date' => $serviceDetails->active_due_date->addMonth(),
                'billing_date' => $serviceDetails->billing_date->addMonth(),
            ]);
        }

        return redirect('billing');
    }

}
