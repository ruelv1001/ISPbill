<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;

class AssignViewTicket extends Controller
{
    public function assignTicket(Ticket $ticket)
    {
        // You can pass the ticket to the view
        return view('tickets.assign', compact('ticket'));
    }
}
