<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MessageController extends Controller
{
    public function show(Chat $chat)
    {
        $messages = $chat->messages()->with(['sender'])->get();

        $msgs = [];
        foreach($messages as $message){
            $add = [
                'id' => $message->id,
                'content' => $message->content,
                'sender' => $message->sender->username
            ];
            array_push($msgs, $add);
        }
        return response()->json($msgs)
        ->header('Content-Type', 'application/json');
    }

    public function store(Request $request, Chat $chat)
    {
        $user = auth('sanctum')->user();
        $data = [
            'content' => $request->content,
                'sender_id' => $user->id,
                'chat_id' => $chat->id
        ];
        Message::create($data);

        return response()->json($data)
        ->header('Content-Type', 'application/json');
    }

    public function destroy(Chat $chat, Message $message)
    {
        $sender = $message->sender()->get()->username;
        $content = $message->content;
        $message->delete();

        return response()->json([
            'message' => $content,
            'from' => $sender,
            'in' => $chat->id
        ])
        ->header('Content-Type', 'application/json');
    }
}
