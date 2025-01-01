<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\User;
class TransactionController extends Controller
{

    public function index()
    {
        if (auth()->user()->isUser()) {
            return redirect('/');
        }

        $users = User::with('transaction')->where('role', 'user')->get();
        return view('transaction.index', compact('users'));
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
        $transaction = Transaction::firstOrNew();
        $transaction->fill($request->validated());
        $transaction->save();

        return back()->with('success', __('Update successful'));
    }

    public function destroy($id)
    {
        $transaction = Transaction::findOrFail($id);
        $transaction->delete();
        return redirect()->route('transaction.index')->with('success', 'Transaction deleted successfully');
    }
}
