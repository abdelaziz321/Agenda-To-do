<?php

namespace App\Helpers;

use Carbon\Carbon;

class DeadlineHelper
{
    public function getDeadlineSection($deadline)
    {
        if ($deadline->isToday()) {
            return 'today';
        } else if ($deadline->isTomorrow()) {
            return 'tomorrow';
        } else if ($deadline->isFuture()) {
            return 'comming';
        } else if ($deadline->isPast()) {
            return 'overdue';
        }
    }

    /**
     * Get the deadline section for the given deadline
     *
     * @param  String  $deadline
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function makeDeadline($section) {
        switch ($section) {
            case 'today':
                return Carbon::today();
                break;
            case 'tomorrow':
                return Carbon::tomorrow();
                break;
            case 'comming':
                return Carbon::now()->addDays(2);
                break;
            case 'overdue':
                return Carbon::yesterday();
                break;
        }
    }

}
