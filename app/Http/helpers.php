<?php

use Carbon\Carbon;

function DateDifference($Date){
    if(!empty($Date)){
        return Carbon::now()->diffInDays($Date, false);
    }else{
        return '-';
    }
}
