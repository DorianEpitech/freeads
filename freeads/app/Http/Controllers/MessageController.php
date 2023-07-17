<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\User;
use App\Models\Add;
use App\Providers\RouteServiceProvider;


class MessageController extends Controller
{   

    public function index()
    {
        $user = auth()->user();

        $user->unread_messages = 0;
        $user->save();

        $userId = auth()->user()->id;

        $conversations = Message::select('sender_id', 'receiver_id', 'created_at', 'message')
                        ->where('sender_id', $userId)
                        ->orWhere('receiver_id', $userId)
                        ->latest()
                        ->get()
                        ->unique(function ($conversation) {
                            return $conversation->sender_id < $conversation->receiver_id ? $conversation->sender_id.'-'.$conversation->receiver_id : $conversation->receiver_id.'-'.$conversation->sender_id;
                        })
                        ->map(function ($conversation) use ($userId) {
                            $lastMessage = $conversation->message;
                            $contactId = $conversation->sender_id == $userId ? $conversation->receiver_id : $conversation->sender_id;
                            $contactName = User::find($contactId)->name;
                            $lastMessageTime = $conversation->created_at;
                            return [
                                'contact_id' => $contactId,
                                'contact_name' => $contactName,
                                'last_message' => $lastMessage,
                                'last_message_time' => $lastMessageTime,
                            ];
                        });




        return view('messages.messages', compact('conversations'));
    }


    public function create($add_id)
    {
        $add = Add::find($add_id);
        Add::where('id', $add->id)->increment('views');

        $receiver = User::find($add->user_id);
        return view('messages.newmessage', compact('receiver'));
    }


    public function store(Request $request)
    {
        $message = new Message();
        $message->message = $request->input('message');
        $message->receiver_id = $request->input('receiver_id');
        $message->sender_id = $request->input('sender_id');
        $message->save();

        User::where('id', $request->input('receiver_id'))->increment('unread_messages');

        return redirect()->route('conversation', ['receiver_id' => $request->input('receiver_id')]);

    }
    public function conversation($sender_id)
    {
        $user = auth()->user();

        $messages = Message::where(function($query) use ($user, $sender_id) {
            $query->where('receiver_id', $user->id)
                ->where('sender_id', $sender_id);
        })
        ->orWhere(function($query) use ($user, $sender_id) {
            $query->where('receiver_id', $sender_id)
                ->where('sender_id', $user->id);
        })
        ->orderBy('created_at', 'asc')
        ->get();

        return view('messages.conversation', ['messages' => $messages]);
    }


}
