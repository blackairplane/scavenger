<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;
use Crypt;
use App\Student;
use App\CheckIn;

class AdminController extends Controller
{
    public $data = [ 'activeTab' => null ];

    public function dashboard(Request $request) {
        $this->data['teams'] = \App\Team::with('points')->get();
        $this->data['roles'] = \App\Role::get();
        $this->data['adminUser'] = \App\User::find(1);
        $this->data['users'] = \App\User::where('id', '>', 1)->with('points')->get()->sortByDesc('amount');
        return View::make('admin.dashboard', $this->data);
    }

    public function showLogin(Request $request) {
        return View::make('team.dashboard', $this->data);
    }
}
