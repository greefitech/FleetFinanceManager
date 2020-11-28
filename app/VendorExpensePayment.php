<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Webpatser\Uuid\Uuid;

class VendorExpensePayment extends Model
{
    public $incrementing = false;
    protected static function boot(){
        parent::boot();
        static::creating(function ($model) {
            $model->{$model->getKeyName()} = Uuid::generate()->string;
        });
    }
    protected $guarded = ['id', 'created_at', 'updated_at'];



    public function expense(){
    	return $this->belongsTo(Expense::class, 'expense_id');
  	}

  	public function vendor(){
    	return $this->belongsTo(Vendor::class,);
  	}
}
