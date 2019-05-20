<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Webpatser\Uuid\Uuid;


class Customer extends Model
{

    public $incrementing = false;
    protected static function boot(){
        parent::boot();
        static::creating(function ($model) {
            $model->{$model->getKeyName()} = Uuid::generate()->string;
        });
    }


    use SoftDeletes;
    
    protected $fillable = ['name', 'mobile', 'address', 'type', 'clientid', 'managerid'];
    protected $guarded = ['id','created_at', 'updated_at'];
    
    protected $dates = ['deleted_at'];

    public function customerEntryData(){
        return $this->hasMany(Entry::class, 'customerId', 'id');
    }

    public function customerIncomeData(){
        return $this->hasMany(Income::class, 'customerId', 'id');
    }

    public function manager(){
        return $this->hasOne(Manager::class, 'id', 'managerid');
    }
}
