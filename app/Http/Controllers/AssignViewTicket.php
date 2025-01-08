<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\UserLimit;
use Illuminate\Http\Request;

class AssignViewTicket extends Controller
{
    public function assignTicket(Ticket $ticket)
    {
    
        $userLimits = UserLimit::all();
    
        return view('tickets.assign', compact('ticket', 'userLimits'));
    }
}
