<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Webpatser\Uuid\Uuid;



class Entry extends Model
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
    protected $fillable = ['dateFrom', 'dateTo','vehicleId','customerId','startKm','endKm','total','locationFrom','locationTo','loadType','ton','billAmount','advance','comission','loadingMamool','unLoadingMamool','balance','clientid', 'managerid'];

    public function vehicles(){
    	return $this->belongsTo(Vehicle::class, 'vehicleId');
  	}

  	public function vehicle(){
        return $this->hasOne(Vehicle::class, 'id', 'vehicleId');
    }

  	public function customers(){
    	return $this->belongsTo(Customer::class, 'customerId');
  	}

    public function customer(){
        return $this->hasOne(Customer::class, 'id', 'customerId');
    }

  	public function getAllStaffs(){
    	return $this->hasMany(StaffsWork::class, 'entryId','id');
  	}

    public function manager(){
        return $this->hasOne(Manager::class, 'id', 'managerid');
    }

    public function LoadType(){
        return $this->hasOne(LoadType::class, 'id', 'loadType');
    }

    public function Account(){
        return $this->hasOne(Account::class, 'id', 'account_id');
    }

    public function Trip(){
        return $this->hasOne(Trip::class, 'id', 'tripId');
    }
}
