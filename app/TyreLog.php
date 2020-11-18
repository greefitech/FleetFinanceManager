<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Webpatser\Uuid\Uuid;

class TyreLog extends Model
{
    public $incrementing = false;
    protected static function boot(){
        parent::boot();
        static::creating(function ($model) {
            $model->{$model->getKeyName()} = Uuid::generate()->string;
        });
    }
    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function vehicle(){
        return $this->hasOne(Vehicle::class, 'id', 'vehicleId');
    }

    public function tyre(){
        return $this->hasOne(Tyre::class, 'id', 'tyre_id');
    }

    public function manager(){
        return $this->hasOne(Manager::class, 'id', 'managerid');
    }

    public function Staff(){
        return $this->hasOne(Staff::class, 'id', 'staffId');
    }
}
