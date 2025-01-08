<?php

namespace App\Http\Controllers;

use App\Models\Detail;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\User;
use Carbon\Carbon;
class TransactionController extends Controller
{

    public function index()
    {
        if (auth()->user()->isUser()) {
            return redirect('/');
        }
    
        // Fetch users with their transactions
        $users = User::with('transaction')->where('role', 'user')->get();
    
        // Calculate totals based on payment method
        $totalsByMethod = [
            'Cash' => 0,
            'Gcash' => 0,
            'Maya' => 0,
            'Bank Transfer' => 0,
        ];
    
        // Total amounts per day
        $totalsPerDay = [];
    
        // Overall total
        $overallTotal = 0;
    
        foreach ($users as $user) {
            foreach ($user->transaction as $transaction) {
                $paymentMethod = $transaction->payment_method;
                $paymentAmount = $transaction->payment_amount;
                
                // Use payment_date if available, fallback to created_at
                $transactionDate = $transaction->payment_date 
                    ? Carbon::parse($transaction->payment_date)->format('Y-m-d') 
                    : ($transaction->created_at ? $transaction->created_at->format('Y-m-d') : null);
        
                if (!$transactionDate) {
                    continue; // Skip transactions without a valid date
                }
        
                // Update totals by payment method
                if (isset($totalsByMethod[$paymentMethod])) {
                    $totalsByMethod[$paymentMethod] += $paymentAmount;
                }
        
                // Update totals per day
                if (!isset($totalsPerDay[$transactionDate])) {
                    $totalsPerDay[$transactionDate] = 0;
                }
                $totalsPerDay[$transactionDate] += $paymentAmount;
        
                // Update overall total
                $overallTotal += $paymentAmount;
            }
        }
    
        return view('transaction.index', compact('users', 'totalsByMethod', 'totalsPerDay', 'overallTotal'));
    }




    public function userTransactions(User $user)
    {
        // Fetch transactions for the given user
        $transactions = Transaction::where('user_id', $user->id)->get();
    
        // Pass the transactions and user to the view
        return view('transaction.each-user', compact('transactions', 'user'));
    }
    

    

    

    public function create(User $user)
    {
        if (!auth()->user()->isAdmin()) {
            return redirect('/');
        }


        return view('transaction.create', compact('user'));
    }



    public function show(User $user)
    {
        if (!auth()->user()->isAdmin()) {
            return redirect('/');
        }


        $transaction = Transaction::firstOrNew();
        return view('transaction.create', compact('user'));
    }
    public function edit(Transaction $transaction)
    {

        if (!auth()->user()->isAdmin()) {
            return redirect('/');
        }


        $user = User::find($transaction->user_id);

        return view('transaction.edit', compact('user', 'transaction'));
    }


    public function update(Request $request, Transaction $transaction)
    {

        $validatedData = $this->validate($request, [
            "transaction_id" => "nullable|string|max:255",
            "payment_amount" => "nullable|string|max:255",
            "remarks" => "nullable|string|max:15",
        ]);



        $transaction = Transaction::firstWhere('id', $request->transaction_id);


        if ($transaction) {
            $transaction->update([
                'payment_amount' => $validatedData['payment_amount'] ?? $transaction->payment_amount,
                'remarks' => $validatedData['remarks'] ?? $transaction->remarks,
            ]);
        }

        $details = Detail::where('user_id', $request->user_id)->first();
        $current_payable_amount = $details->package_price;


        $serviceDetails = ServiceDetails::where('user_id', $request->user_id)->first();
    
        if ($serviceDetails) {
            $previousDueDate = $serviceDetails->active_due_date;
    
            // Check if current_payable_amount is not equal to the payment amount
            if ($current_payable_amount != $request->payment_amount) {
                $perdayAmount = $current_payable_amount / 30;
                $noofdays = $request->payment_amount / $perdayAmount;
    
                // Update active_due_date and billing_date
                $newActiveDueDate = now()->addDays($noofdays);
                $newBillingDate = $newActiveDueDate->copy()->addDays(10);
    
                $serviceDetails->update([
                    'active_due_date' => $newActiveDueDate,
                    'billing_date' => $newBillingDate,
              
                ]);
            }
        }


        return back()->with('success', __('Update successful'));
    }

    public function destroy($id)
    {
        $transaction = Transaction::findOrFail($id);
        $transaction->delete();
        return redirect()->route('transaction.index')->with('success', 'Transaction deleted successfully');
    }
}
