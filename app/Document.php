<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Webpatser\Uuid\Uuid;

class Document extends Model
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
    
     protected $fillable = ['documentType', 'duedate', 'notifyBefore', 'interval', 'issuingCompany', 'amount', 'notes', 'vehicleId'];
    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function DocumentType(){
        return $this->belongsTo(DocumentType::class, 'documentType', 'id');
    }

}
