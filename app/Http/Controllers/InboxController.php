<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use Illuminate\Http\Request;

class InboxController extends Controller
{
    public function index()
    {
        $chats = Chat::all();
        return view('inbox.index', compact('chats'));
    }

    public function show(Chat $chat)
    {
        return view('inbox.show', compact('chat'));
    }
}
