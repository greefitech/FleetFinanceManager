<?php

namespace App\Helpers;

class Helper{
    public static function get_expire_date($current_year){
        $next_year = $current_year+1;
        return $next_year."-01-31";
    }
}