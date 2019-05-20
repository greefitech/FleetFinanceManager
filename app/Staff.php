<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Webpatser\Uuid\Uuid;


class Staff extends Model
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
    
   protected $fillable = ['name', 'mobile1', 'mobile2', 'address', 'licenceNumber', 'licenceRenewal', 'type', 'clientid'];
    protected $guarded = ['id', 'created_at', 'updated_at'];
}
