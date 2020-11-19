<?php

namespace App\Http\Traits;
use Carbon\Carbon;

trait BasicTraits {
    public function get_expire_date($current_year){
        $next_year = $current_year+1;
        return $next_year."-01-31";
    }

    public function DateDifference($Date){
        if(!empty($Date)){
            return Carbon::now()->diffInDays($Date, false);
        }else{
            return '-';
        }
    }
}