<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Webpatser\Uuid\Uuid;

class Trip extends Model
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

    public function vehicle(){
        return $this->hasOne(Vehicle::class, 'id', 'vehicleId');
    }

    public function Manager(){
        return $this->hasOne(Manager::class, 'id', 'managerid');
    }
    public function Client(){
        return $this->hasOne(Client::class, 'id', 'clientid');
    }

    public function Staff1(){
        return $this->hasOne(Staff::class, 'id', 'staff1');
    }
    public function Staff2(){
        return $this->hasOne(Staff::class, 'id', 'staff2');
    }
    public function Staff3(){
        return $this->hasOne(Staff::class, 'id', 'staff3');
    }


}
