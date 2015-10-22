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
            'team' => 'required'
        ]);

        $user = new User;
        $user->name = $request->input('name');
        $user->password = bcrypt($request->input('password'));
        $user->team_id = $request->input('team');
        $user->save();

        return $this->response();
    }

    public function show($id) {
        $this->output['data'] = User::find($id);
        return $this->response();
    }

    public function update(Request $request, $id) {
        $this->validate($request, [
            'name' => 'required',
            'team' => 'required'
        ]);

        $user = User::find($id);
        $user->name = $request->input('name');

        if ( $request->input('password') ):
            $user->password = bcrypt($request->input('password'));
        endif;

        $user->team_id = $request->input('team');
        $user->save();

        return $this->response();
    }
}