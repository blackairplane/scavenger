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
        $this->data['challenges'] = \App\Challenge::all();
        return View::make('team.dashboard', $this->data);
    }

//    public function showLogin(Request $request) {
//        $this->data['roles'] = \App\Role::get();
//        return View::make('auth.login', $this->data);
//    }

    public function login(Request $request) {
        if ($request->user()):
            return redirect('dashboard');
        else:
            return redirect('/auth/login');
        endif;
    }
}
