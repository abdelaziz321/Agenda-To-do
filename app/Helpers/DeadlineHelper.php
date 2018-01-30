<?php

namespace App\Helpers;

use Carbon\Carbon;

class DeadlineHelper
{
    /**
     * Get the deadline section for the given deadline date
     *
     * @param  Carbon\Carbon  $deadline
     * @return string
     */
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
     * make deadline timestamp for a specific deadline section
     *
     * @param  String  $deadline
     * @return Carbon\Carbon
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
