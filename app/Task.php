<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Task
 * @package App
 */
class Task extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    /**
     * @var array
     */
    protected $fillable = [
        'deadline','body','priority',
    ];

    /**
     * belongs to User
     */
    public function users()
    {
        $this->belongsTo('App\User');
    }

    /**
     * @param $query
     * @param $filter
     */
    public function scopefilterSection($query, $filter)
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
