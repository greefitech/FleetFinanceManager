<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VerifyClient extends Model
{
	
	protected $guarded = [];


    public function Client() {
        return $this->belongsTo('App\Client', 'client_id');
    }


}
