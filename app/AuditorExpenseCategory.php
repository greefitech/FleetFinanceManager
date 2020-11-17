<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Webpatser\Uuid\Uuid;

class AuditorExpenseCategory extends Model
{
    public $incrementing = false;
    protected static function boot(){
        parent::boot();
        static::creating(function ($model) {
            $model->{$model->getKeyName()} = Uuid::generate()->string;
        });
    }

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function AuditorExpenseTypes(){
        return $this->hasMany(AuditorExpenseType::class, 'auditor_expense_category_id','id');
    }
}
