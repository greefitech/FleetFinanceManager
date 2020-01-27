<?php

namespace App;

use App\Notifications\AdminResetPassword;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;

class Admin extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','mobile',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new AdminResetPassword($token));
    }

    public function ClientDetails(){
        return $this->hasMany(Client::class, 'referral_number', 'mobile');
    }

    public function TotalIncome(){
        return $this->hasMany(VehicleCredits::class, 'clientid', 'id');
    }
}
