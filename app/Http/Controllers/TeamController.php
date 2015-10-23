<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;
use Crypt;
use App\User;
use App\Team;

class TeamController extends Controller
{
    public $data = [ 'activeTab' => null ];

    public function dashboard(Request $request) {
        $this->data['user'] = $request->user();
        $this->data['teams'] = Team::with('points')->get();
        $this->data['players'] = User::with(['points','team'])->get();
        $this->data['challenges'] = \App\Challenge::where('active_time', '<', date('Y-m-d H:i:s'))->get();
        return View::make('team.dashboard', $this->data);
    }

    public function quest(Request $request) {
        if ($request->user()->role->name !== 'Technologist'):
            return redirect('dashboard');
        endif;
        $this->data['players'] = User::with(['points','team'])->get();
        $this->data['user'] = $request->user();
        $this->data['challenges'] = \App\Challenge::where('active_time', '<', date('Y-m-d H:i:s'))->get();
        return View::make('team.quest', $this->data);
    }

    public function login(Request $request) {
        if ($request->user()):
            return redirect('dashboard');
        else:
            return redirect('/auth/login');
        endif;
    }
}
