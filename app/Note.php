<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    public function users()
    {
        $this->belongsTo('App\User');
    }
}
