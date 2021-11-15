<?php

namespace App\Http\Controllers;
use App\Events\PostCreated;
use App\Events\NewChatMessage;
use App\Models\ChatMessage;
use App\Models\ChatRoom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class ChatController extends Controller
{
    //
    function rooms(){
        return ChatRoom::all();
    }
    function messages(Request $request,$room_id){
        return ChatMessage::where("chat_room_id",$room_id)
        ->with('user')
        ->orderBy('created_at',"ASC")->get();
    }
    function newMessage(Request $request,$room_id){
        $newMessage=new ChatMessage();
        $newMessage->user_id= Auth::id();
        $newMessage->chat_room_id=$room_id;
        $newMessage->message= $request->message;
        $newMessage->save();

        broadcast(new PostCreated( $newMessage))-> toOthers();
        return $newMessage;
    }
}
