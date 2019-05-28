<?php

namespace App\Helpers;

use Carbon\Carbon;

class Helper{
    public static function get_expire_date($current_year){
        $next_year = $current_year+1;
        return $next_year."-01-31";
    }

    public static function DateDifference($Date){
        if(!empty($Date)){
            return Carbon::now()->diffInDays($Date, false);
        }else{
            return '-';
        }
    }
}