<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VehicleCreditPayment extends Model
{
    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected $fillable = ['PaidAmount','created_by'];
}
