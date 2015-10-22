<?php

namespace App\Http\Controllers\Api\v1;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\User;
use Swagger\Annotations as SWG;

class UserController extends ApiController
{
    public function create(Request $request) {
        $this->validate($request, [
            'name' => 'required',
            'password' => 'required',
            'team' => 'required',
            'role' => 'required',
            'points' => 'numeric'
        ]);

        $user = new User;
        $user->name = $request->input('name');
        $user->password = bcrypt($request->input('password'));
        $user->team_id = $request->input('team');
        $user->role_id = $request->input('role');
        $user->save();

        if ( $request->input('points') ):
            $points = new \App\Point;
            $points->amount = $request->input('points');
            $points->user_id = $user->id;
            $points->note = 'Initial allotment';
            $points->save();
        endif;

        return $this->response();
    }

    public function show($id) {
        $this->output['data'] = User::find($id);
        return $this->response();
    }

    public function update(Request $request, $id) {
        $this->validate($request, [
            'name' => 'required',
            'team' => 'required',
            'role' => 'required'
        ]);

        $user = User::find($id);
        $user->name = $request->input('name');

        if ( $request->input('password') ):
            $user->password = bcrypt($request->input('password'));
        endif;

        $user->team_id = $request->input('team');
        $user->role_id = $request->input('role');
        $user->save();

        return $this->response();
    }

    public function addPoints(Request $request)
    {
        $this->validate($request, [
            'user_id' => 'required',
            'amount' => 'required|numeric',
        ]);

        $points = new \App\Point;
        $points->user_id = $request->input('user_id');
        $points->amount = $request->input('amount');
        $points->note = $request->input('note');
        $points->save();

        return $this->response();
    }
}