<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Webpatser\Uuid\Uuid;

class Income extends Model
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

    public function customer(){
        return $this->hasOne(Customer::class, 'id', 'customerId');
    }

    public function manager(){
        return $this->hasOne(Manager::class, 'id', 'managerid');
    }

    public function Trip(){
        return $this->hasOne(Trip::class, 'id', 'tripId');
    }

    public function Account(){
        return $this->hasOne(Account::class, 'id', 'account_id');
    }
}
