<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Webpatser\Uuid\Uuid;

class RTOMaster extends Model
{
    public $incrementing = false;
    protected static function boot(){
        parent::boot();
        static::creating(function ($model) {
            $model->{$model->getKeyName()} = Uuid::generate()->string;
        });
    }

}
