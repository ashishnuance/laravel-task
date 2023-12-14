<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Events\NewNotification;
use App\Events\NewMessage;
use App\Models\Notifications;
use App\Models\Messages;

class ChattingController extends Controller
{
    /**
     * Display the view for fetching and viewing messages
     * Render chat view, allowing user to view and interect with list and send message.
     */
    function index(){
        return view('message.chat');
    }

    public function send(Request $request)
    {   
        $requestData['sender_id'] = $request->user()->id;
        $requestData['receiver_id'] = 12;
        $requestData['message_text'] = $request->message;
        Messages::create($requestData);
        $message = $request->input('message');

        event(new NewMessage($message));

        return response()->json(['status' => 'Message Sent!']);
    }
}
