<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    public $totalPoints = 0;

    public function users() {
        return $this->hasMany('\App\User');
    }

    public function points() {
        return $this->hasManyThrough('\App\Point', '\App\User');
    }
}
