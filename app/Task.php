<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Task extends Model
{
    public function users()
    {
        $this->belongsTo('App\User');
    }

    public function scopefilterTime($query, $filter)
    {
        switch ($filter) {
            case 'overdue':
                $query->whereRaw('CURDATE() > DATE(`deadline`)');
                break;
            case 'today':
                $query->whereRaw('CURDATE() = DATE(`deadline`)');
                break;
            case 'tomorrow':
                $query->whereRaw('CURDATE() = DATE(DATE_ADD(`deadline`, INTERVAL -1 DAY))');
                break;
            case 'comming':
                $query->whereRaw('CURDATE() < DATE(DATE_ADD(`deadline`, INTERVAL -1 DAY))');
                break;
        }
    }
}
