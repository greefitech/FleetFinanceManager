<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Webpatser\Uuid\Uuid;

class Halt extends Model
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

    public function vehicle(){
        return $this->hasOne(Vehicle::class, 'id', 'vehicleId');
    }

    public function manager(){
        return $this->hasOne(Manager::class, 'id', 'managerid');
    }

}
