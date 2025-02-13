<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Ticket;
use Illuminate\Http\Request;

class TicketController extends Controller
{
 

    public function index(Request $request)
    {

        $tabActive = $request->input('tab-active', 'port');
        $searchTerm = $request->input('search');
        $area = $request->input('tickets');

        // Base query with necessary joins
        $usersListQuery = Ticket::select(
            'tickets.*'
        );


        if ($tabActive === 'tickets') {
            if ($request->filled('tickets')) {
                $usersListQuery->where('tickets.number', $request->input('tickets'));
            }


        }

        $areaFilter = [
            'tickets' => Ticket::distinct()->pluck('subject', 'subject')->toArray(),
        ];

        // Paginate the results
        $data = $usersListQuery->paginate(10)->withQueryString();

        // Return the view with data
        return view('tickets.index', compact('data', 'areaFilter'));

    }

    public function create()
    {
        return view('tickets.create');
    }

    public function store(Request $request)
    {
        $ticket = new Ticket();
        $ticket->subject = $request->subject;
        $ticket->message = $request->message;
        $ticket->priority = $request->priority;
        $ticket->status = 'Open';
        $ticket->user_id = auth()->id();
        $ticket->number = $ticket->generateRandomNumber();
        $ticket->save();

        return redirect('ticket');
    }

    public function show(Ticket $ticket)
    {
        $comments = Comment::where('ticket_id', $ticket->id)->with('user')->get();

        return view('tickets.show', compact('ticket', 'comments'));
    }
}
