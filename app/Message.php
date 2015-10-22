<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    public function sender()
    {
        return $this->hasOne('\App\User', 'id', 'sender_id');
    }

    public function recipient()
    {
        return $this->hasOne('\App\User', 'id', 'recipient_id');
    }
}
