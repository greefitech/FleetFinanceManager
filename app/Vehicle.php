<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Webpatser\Uuid\Uuid;


class Vehicle extends Model
{

	public $incrementing = false;
    protected static function boot(){
        parent::boot();
        static::creating(function ($model) {
            $model->{$model->getKeyName()} = Uuid::generate()->string;
        });
    }

	use SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function documents(){
        return $this->hasMany(Document::class, 'vehicleId', 'id');
    }

    public function GetVehicleType(){
        return $this->belongsTo(VehicleType::class, 'vehicleType', 'id');
    }
}