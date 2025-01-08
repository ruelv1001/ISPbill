<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class AssignTicket extends Controller
{
    public function __invoke(Request $request)
    {

        $request->validate([
            'ticket_id' => 'required|exists:tickets,id',
            'user_type' => 'required',
        ]);
    

        $ticket = Ticket::findOrFail($request->ticket_id);
        $ticket->assign = $request->user_type; 
        $ticket->save();

        Alert::success('Success', 'Ticket successfully assigned.');
    return back();
    }
}
