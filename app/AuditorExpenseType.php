<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Webpatser\Uuid\Uuid;

class AuditorExpenseType extends Model
{
    public $incrementing = false;
    protected static function boot(){
        parent::boot();
        static::creating(function ($model) {
            $model->{$model->getKeyName()} = Uuid::generate()->string;
        });
    }

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function ExpenseTypes(){
        return $this->belongsTo(ExpenseType::class, 'expense_type_id');
    }
}
