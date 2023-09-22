<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChatController extends Controller
{
    public function index()
    {
        $user = auth('sanctum')->user();
        $groupChats = User::find($user->id)->chats()->select('id', 'name', 'description', 'chat_type')->where('chat_type', '=', 'group')->get();
        $privateChats = User::find($user->id)->chats()->select('id', 'name', 'chat_type')->where('chat_type', '=', 'private')->with([
            'users' => fn(Builder $query) => $query->where('id', '!=', $user->id)
        ])->get();
        $pvs = [];
        foreach($privateChats as $pv){
            $add = [
                'id' => $pv->id,
                'name' => $pv->users[0]->username,
                'type' => $pv->chat_type
            ];
            array_push($pvs, $add);
        }
        foreach($groupChats as $group){
            $add = [
                'id' => $group->id,
                'name' => $group->name,
                'description' => $group->description,
                'type' => $group->chat_type
            ];
            array_push($pvs, $add);
        }
        // $privateChats->users[0]->username
        return response(json_encode($pvs))
        ->header('Content-Type', 'application/json');
    }
}
