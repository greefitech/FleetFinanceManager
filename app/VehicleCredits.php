<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VehicleCredits extends Model
{
    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function Admin(){
        return $this->hasOne(Admin::class, 'id', 'created_by');
    }
}
