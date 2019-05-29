<?php

use Carbon\Carbon;

if (! function_exists('DateDifference')) {
    function DateDifference($Date){
        if (!empty($Date)) {
            return Carbon::now()->diffInDays($Date, false);
        } else {
            return '-';
        }
    }
}