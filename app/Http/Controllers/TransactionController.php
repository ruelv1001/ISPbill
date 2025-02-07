<?php

namespace App\Http\Controllers;

use App\Models\Detail;
use App\Models\ServiceDetails;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
class TransactionController extends Controller
{

    public function index(Request $request)
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

        $tabActive = $request->input('tab-active', 'transaction');
        $searchTerm = $request->input('search');
        $area = $request->input('transaction');

        // Base query with necessary joins
        $usersListQuery = Transaction::select(
            'transaction.id as myid',
            'transaction.*',
            'details.*',
            'details.name as cname'
        )
            ->join('users', 'users.id', '=', 'transaction.user_id')
            ->join('details', 'details.user_id', '=', 'users.id');

        if ($tabActive === 'transaction') {
            if ($request->filled('payment')) {
                $usersListQuery->where('transaction.payment_method', $request->input('payment'));
            }
            if ($request->filled('name')) {
                $usersListQuery->where('details.name', $request->input('name'));
            }
        }

        $areaFilter = [
            'payment' => Transaction::distinct()->pluck('payment_method', 'payment_method')->toArray(),
            'name' => Detail::distinct()->pluck('name', 'name')->toArray(),
        ];


        // Paginate the results
        $data = $usersListQuery->paginate(10)->withQueryString();

        // Define the $tableCheckedbox variable
        $tableCheckedbox = false; // or true, depending on your logic

        return view('transaction.index', compact('data', 'areaFilter', 'users', 'totalsByMethod', 'totalsPerDay', 'overallTotal', 'tableCheckedbox'));
    }




    public function userTransactions(User $user, Request $request)
    {
        // Fetch transactions for the given user


        $tabActive = $request->input('tab-active', 'transaction');
        $searchTerm = $request->input('search');
        $area = $request->input('transaction');
        $users = User::with('transaction')->where('role', 'user')->get();

        // Base query with necessary joins
        $usersListQuery = Transaction::select(
            'transaction.id as myid',
            'transaction.*',
            'details.*',
            'details.name as cname'
        )
            ->join('users', 'users.id', '=', 'transaction.user_id')
            ->join('details', 'details.user_id', '=', 'users.id')
            ->where('transaction.user_id', $user->id);

        if ($tabActive === 'transaction') {
            if ($request->filled('payment')) {
                $usersListQuery->where('transaction.payment_method', $request->input('payment'));
            }
            if ($request->filled('name')) {
                $usersListQuery->where('details.name', $request->input('name'));
            }
        }

        $areaFilter = [
            'payment' => Transaction::distinct()->pluck('payment_method', 'payment_method')->toArray(),
            'name' => Detail::distinct()->pluck('name', 'name')->toArray(),
        ];


        // Paginate the results
        $data = $usersListQuery->paginate(10)->withQueryString();

        // Define the $tableCheckedbox variable
        $tableCheckedbox = false; // or true, depending on your logic

        return view('transaction.each-user', compact('data', 'areaFilter', 'user', 'users', 'tableCheckedbox'));

        // Pass the transactions and user to the view

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
        $detail = Detail::find($transaction->user_id);

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



    public function destroy(string $id)
    {

        $areaLocation = Transaction::find($id);


        $serviceDetail = ServiceDetails::where("user_id", $areaLocation->user_id)->firstOrFail();

        $prev = Carbon::parse($serviceDetail->previous_due_date);
        $active = Carbon::parse($serviceDetail->active_due_date);

        $daysDifference = $active->diffInDays($prev);

        $newPrevDate = $prev->subDays($daysDifference);
        $newBillingDate = $prev->addDays(10);

        $serviceDetail->update([
            'previous_due_date' => $newPrevDate,
            'active_due_date' => $serviceDetail->previous_due_date,
            'billing_date' => $newBillingDate,
        ]);

        if (!$areaLocation) {

            return response()->json(['message' => 'Transaction not found'], 404);
        }


        $areaLocation->delete();


        return response()->json(['message' => 'Transaction deleted successfully'], 200);
    }
}
