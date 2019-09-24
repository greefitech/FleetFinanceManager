<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Webpatser\Uuid\Uuid;


class Expense extends Model
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

     public function vehicles(){
    	return $this->belongsTo(Vehicle::class, 'vehicleId');
  	}

  	public function staffs(){
    	return $this->belongsTo(Staff::class, 'staffId');
  	}

    public function staff(){
        return $this->hasOne(Staff::class, 'id','staffId');
    }

  	public function ExpenseTypes(){
    	return $this->belongsTo(ExpenseType::class, 'expense_type');
  	}

    public function manager(){
        return $this->hasOne(Manager::class, 'id', 'managerid');
    }

    public function ExpenseType(){
        return $this->hasOne(ExpenseType::class, 'id','expense_type');
    }

    public function Account(){
        return $this->hasOne(Account::class, 'id', 'account_id');
    }

    public function Trip(){
        return $this->hasOne(Trip::class, 'id', 'tripId');
    }
    
}
