<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;
    protected $table = 'clients';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'mobile', 'transportName', 'address', 'wallet'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ClientResetPassword($token));
    }
    public function customers(){
        return $this->hasMany(Customer::class, 'clientid', 'id');
    }

    public function vehicles(){
        return $this->hasMany(Vehicle::class, 'clientid', 'id');
    }

    public function staffs(){
        return $this->hasMany(Staff::class, 'clientid', 'id');
    }

    public function entries(){
        return $this->hasMany(Entry::class, 'clientid', 'id');
    }
}
