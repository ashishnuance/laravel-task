<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Events\NewNotification;
use App\Events\NewMessage;
use App\Models\Notifications;
use App\Models\Message;
use App\Models\User;

class ChattingController extends Controller
{
    /**
     * Display the view messages
     * Render chat view, allowing user to view and interect with list and send message.
     */
    function index(){
        
        return view('message.chat');
    }

    
    /**
     * Fetch users
     * @return response
     */
    public function fetchUsers()
    {
        return User::select('id','name')->get()->chunk(30);
    }
    
    /**
     * Fetch messages
     * @return response
     */
    public function fetchMessages()
    {
        return Message::with('user')->latest()->get();
    }

    /**
     * Insert new message
     * @return response status
     */
    public function sendMessage(Request $request)
    {   
        $requestData['sender_id'] = $request->user()->id;
        $requestData['receiver_id'] = 12;
        $requestData['message_text'] = $request->message;
        Message::create($requestData);
        $message = $request->input('message');

        $usermessage = User::get()->chunk(30)->map(function($u) use($request){
            return [
                'sender_id' => $request->user()->id,
                'receiver_id' => $u->id,
                'message_text' => $request->message
            ];
        });
        dd($usermessage);
        // foreach (Users::get()->chunk(30) as $chunk)
        // {
        //     $requestData['sender_id'] = $request->user()->id;
        //     $requestData['receiver_id'] = 12;
        //     $requestData['message_text'] = $request->message;
        //     Message::insert($chunk->toArray());
        // }

        broadcast(new NewMessage($message));

        return response()->json(['status' => 'Message Sent!']);
    }
}
