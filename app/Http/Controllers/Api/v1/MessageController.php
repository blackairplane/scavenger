<?php

namespace App\Http\Controllers\Api\v1;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Message;
use Swagger\Annotations as SWG;

class MessageController extends ApiController
{
    public function markAsRead($id)
    {
        $message = Message::find($id);
        $message->read = 1;
        $message->save();
        return $this->response();
    }

    public function create(Request $request)
    {
        $this->validate($request, [
           'recipient' => 'required',
           'content' => 'required',
        ]);

        $message = new Message;
        $message->sender_id = $request->user()->id;
        $message->recipient_id = $request->input('recipient');
        $message->content = $request->input('content');
        $message->read = 0;
        $message->save();

        return $this->response();
    }
}