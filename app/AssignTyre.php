<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Webpatser\Uuid\Uuid;

class AssignTyre extends Model
{
    public $incrementing = false;
    protected static function boot(){
        parent::boot();
        static::creating(function ($model) {
            $model->{$model->getKeyName()} = Uuid::generate()->string;
        });
    }
    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function Tyre(){
        return $this->hasOne(Tyre::class, 'id', 'tyre_id');
    }
}
