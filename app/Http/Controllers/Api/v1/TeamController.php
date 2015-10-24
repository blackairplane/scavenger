<?php

namespace App\Http\Controllers\Api\v1;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Team;
use Swagger\Annotations as SWG;

class TeamController extends ApiController
{
    public function create(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'color' => 'required'
        ]);

        $team = new Team;
        $team->name = $request->input('name');
        $team->color = strtolower($request->input('color'));
        $team->save();

        return $this->response();
    }

    public function show($id)
    {
        $this->output['data'] = Team::find($id);
        return $this->response();
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'color' => 'required'
        ]);

        $team = Team::find($id);
        $team->name = $request->input('name');
        $team->color = $request->input('color');
        $team->save();

        $this->output['data'] = $team;
        return $this->response();
    }

    public function addPoints(Request $request, $id)
    {
        $this->validate($request, [
            'amount' => 'required|numeric',
        ]);

        $team = Team::find($id);
        foreach ($team->users as $user):
            $points = new \App\Point;
            $points->user_id = $user->id;
            $points->amount = $request->input('amount');
            $points->note = $request->input('note');
            $points->save();
        endforeach;

        return $this->response();
    }
}