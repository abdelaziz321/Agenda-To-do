<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Note
 * @package App
 */
class Note extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'title', 'body',
    ];

    /**
     * belongs to user
     */
    public function users()
    {
        $this->belongsTo('App\User');
    }
}
