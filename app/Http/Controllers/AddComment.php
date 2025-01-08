<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

class AddComment extends Controller
{
    public function __invoke(Request $request)
    {

        if (auth()->user()->role == 'user') {
            $comment = new Comment();
            $comment->comment = $request->comment;
            $comment->user_id = auth()->id();
            $comment->ticket_id = $request->ticket_id;
            $comment->save();
        } else {
            $comment = new Comment();
            $comment->comment = $request->comment;
            $comment->user_id = auth()->id();
            $comment->assign_id = auth()->id();
            $comment->ticket_id = $request->ticket_id;
            $comment->save();
        }



        return back();
    }
}
