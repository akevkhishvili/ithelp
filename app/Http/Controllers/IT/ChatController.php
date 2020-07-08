<?php

namespace App\Http\Controllers\IT;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Chat;
use App\Models\Message;
use App\Models\Staff;
use Auth;

class ChatController extends Controller
{
    public function postMessage(request $request){

        $member1 = $request->input('member1');
        $member2 = $request->input('member2');

        $message = $request->input('message');

        $chatID =  Chat::where('member1', '=', $member1)
            ->where('member2', '=',$member2)
            ->select('id')->pluck('id')->first();
        $chatID2 = Chat::where('member1', '=', $member2)
            ->where('member2', '=',$member1)
            ->select('id')->pluck('id')->first();
        if(!empty($chatID)){
            $chatID= $chatID;
        }
        if(!empty($chatID2)){
            $chatID= $chatID2;
        }

        if(!empty($chatID)){
            $updateChat = Chat::find($chatID);
            $updateChat->hasNewMessageIt = "1";
            $updateChat->save();

            $newMessage = new Message();
            $newMessage -> chat_id = $chatID;
            $newMessage -> sender = $member2;
            $newMessage -> text = $message;
            $newMessage->save();
        } else {

            $newMessage = new Chat();
            $newMessage -> member1 = $member1;
            $newMessage -> member2 = $member2;
            $newMessage -> hasNewMessageIt = "1";
            $newMessage->save();

            $newChatId = $newMessage->id;

            $newMessageN = new Message();
            $newMessageN -> chat_id = $newChatId;
            $newMessageN -> sender = $member2;
            $newMessageN -> text = $message;
            $newMessageN->save();
        }
        return Response()->json(['success'=>true]);
    }

    public function postMessageIt(request $request){

        $member1 = $request->input('member1');
        $member2 = $request->input('member2');

        $message = $request->input('message');

        $chatID =  Chat::where('member1', '=', $member1)
            ->where('member2', '=',$member2)
            ->select('id')->pluck('id')->first();
        $chatID2 = Chat::where('member1', '=', $member2)
            ->where('member2', '=',$member1)
            ->select('id')->pluck('id')->first();
        if(!empty($chatID)){
            $chatID= $chatID;
        }
        if(!empty($chatID2)){
            $chatID= $chatID2;
        }

        if(!empty($chatID)){
            $updateChat = Chat::find($chatID);
            $updateChat->hasNewMessage = "1";
            $updateChat->save();

            $newMessage = new Message();
            $newMessage -> chat_id = $chatID;
            $newMessage -> sender = $member2;
            $newMessage -> text = $message;
            $newMessage->save();
        } else {

            $newMessage = new Chat();
            $newMessage -> member1 = $member1;
            $newMessage -> member2 = $member2;
            $newMessage -> hasNewMessage = "1";
            $newMessage->save();

            $newChatId = $newMessage->id;

            $newMessageN = new Message();
            $newMessageN -> chat_id = $newChatId;
            $newMessageN -> sender = $member2;
            $newMessageN -> text = $message;
            $newMessageN->save();
        }
        return Response()->json(['success'=>true]);
    }


    public function getChatMessages (request $request){
        $member1 = $request->input('userId');
        $member2 = $request->input('myID');
        $from = $request->input('from');


        $chatID =  Chat::where('member1', '=', $member1)
            ->where('member2', '=',$member2)
            ->select('id')->pluck('id')->first();
        $chatID2 = Chat::where('member1', '=', $member2)
            ->where('member2', '=',$member1)
            ->select('id')->pluck('id')->first();
        if(!empty($chatID)){
            $chatID = $chatID;
        }
        if(!empty($chatID2)){
            $chatID= $chatID2;
        }


        $messages = Message::where('chat_id', '=', $chatID)->get();

        $chat = Chat::where('id', '=', $chatID)->get();

        if(!empty($chatID) && $from == "IT"){
            $updateChat = Chat::find($chatID);
            $updateChat->hasNewMessageIt = "0";
            $updateChat->save();
        } elseif (!empty($chatID) && $from == "STAFF"){
            $updateChat = Chat::find($chatID);
            $updateChat->hasNewMessage = "0";
            $updateChat->save();
        }
        return Response()->json(['success'=>true, $messages, $chat]);
    }

    function getStaffMembersForChat(request $request){
        //dd($request);
        $member1 = Auth::user()->id;
        $chat = Chat::where('member1', '=', $member1)->orWhere('member2', '=', $member1)->get();
        $staffMembers = Staff::orderBy('lastName')->orderBy('firstName')->get();
       // dd($chat);

        return Response()->json(['success'=>true,$staffMembers, $chat]);
    }

    public function getMessagesCount (request $request){
        $id = Auth::user()->id;

        $chatID =  Chat::where('member1', '=', $id)->where('hasNewMessageIt', '!=', 0)
           ->count();
        $chatID2 = Chat::where('member2', '=', $id)->where('hasNewMessageIt', '!=', 0)
            ->count();
        $chatCount = $chatID+$chatID2;


        //$chatCount = Chat::where('member1', '=', $id)
        //    ->orWhere('member2', '=', $id)->where('hasNewMessageIt', '!=', 0)
        //    ->count();
        return Response()->json(['success'=>true,$chatCount]);
    }

    public function getMessagesCountUser (request $request){
        $id = $request->input('staffMemberId');

        $chatID =  Chat::where('member1', '=', $id)->where('hasNewMessage', '!=', 0)
            ->count();
        $chatID2 = Chat::where('member2', '=', $id)->where('hasNewMessage', '!=', 0)
            ->count();
        $chatCount = $chatID+$chatID2;

        $msgFromIt = Chat::where('member1', '=', $id)->orWhere('member2', '=', $id)->get();
        //$chatCount = Chat::where('member1', '=', $id)
        //    ->orWhere('member2', '=', $id)->where('hasNewMessageIt', '!=', 0)
        //    ->count();
        return Response()->json(['success'=>true,$chatCount, $msgFromIt]);
    }

}
