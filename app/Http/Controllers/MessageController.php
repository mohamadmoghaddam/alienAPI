<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function show(Chat $chat){
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
        return response()->json($msgs);
    }

}
