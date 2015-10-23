<?php

namespace App\Http\Controllers\Api\v1;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Challenge;
use Swagger\Annotations as SWG;

class ChallengeController extends ApiController
{
    public function create(Request $request)
    {
        $this->validate($request, [
           'prompt' => 'required',
           'answer' => 'required',
           'value' => 'required|numeric',
        ]);

        $challenge = new Challenge;
        $challenge->prompt = $request->input('prompt');
        $challenge->answer = strtolower($request->input('answer'));
        $challenge->value = $request->input('value');
        if ( $request->input('active_time') ):
            $challenge->active_time = $request->input('active_time');
        else:
            $challenge->active_time = date('Y-m-d H:i:s');
        endif;
        $challenge->save();

        return $this->response();
    }

    public function createAdmin(Request $request)
    {
        $this->validate($request, [
           'recipient' => 'required',
           'content' => 'required',
        ]);

        $message = new Message;
        $message->sender_id = 1;
        $message->recipient_id = $request->input('recipient');
        $message->content = $request->input('content');
        $message->read = 0;
        $message->save();

        return $this->response();
    }

    public function guess(Request $request, $id)
    {
        $challenge = Challenge::find($id);
        if (strtolower($request->input('guess')) == $challenge->answer):
            $this->output['data']['correct'] = 1;
        else:
            $this->output['data']['correct'] = 0;
        endif;

        return $this->response();
    }
}