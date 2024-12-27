<?php

namespace App\Http\Controllers;

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

        return view('transaction.create', compact('user'));
    }

    public function edit(User $user)
    {
        if (!auth()->user()->isAdmin()) {
            return redirect('/');
        }


        return view('transaction.edit', compact('user'));
    }
}
