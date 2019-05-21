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
            $datework = Carbon::parse($Date);
            $now = Carbon::now();
            return $datework->diffInDays($now)+1;
        }else{
            return '-';
        }
    }
}