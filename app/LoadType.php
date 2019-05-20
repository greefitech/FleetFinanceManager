<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;



class LoadType extends Model
{
   
	use SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $fillable = ['loadType'];
    protected $guarded = ['id', 'created_at', 'updated_at'];
}
