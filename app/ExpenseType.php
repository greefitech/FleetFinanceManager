<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;



class ExpenseType extends Model
{

	use SoftDeletes;
    protected $dates = ['deleted_at'];
    
    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function manager(){
        return $this->hasOne(Manager::class, 'id', 'managerid');
    }

    public function client(){
        return $this->hasOne(Client::class, 'id', 'clientid');
    }
}
