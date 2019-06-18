<?php

namespace App;

use App\Notifications\ManagerResetPassword;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Manager extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
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
        $this->notify(new ManagerResetPassword($token));
    }

    public function Owner(){
        return $this->hasOne(Client::class, 'id', 'clientid');
    }

    public function Customers(){
        return $this->hasMany(Customer::class, 'clientid', 'clientid')->orderBy('updated_at','DESC');
    }

    public function vehicles(){
        return $this->hasMany(Vehicle::class, 'clientid', 'clientid')->whereIn('id',$this->ManagerLorry())->get();
    }


    public function Vehicle(){
        return $this->hasMany(Vehicle::class, 'clientid', 'id')->orderBy('updated_at','DESC');
    }

    public function staffs(){
        return $this->hasMany(Staff::class, 'clientid', 'clientid')->orderBy('updated_at','DESC');
    }

    public function entries(){
        return $this->hasMany(Entry::class, 'managerid', 'id')->orderBy('updated_at','DESC');
    }

    public function expenses(){
        return $this->hasMany(Expense::class, 'managerid', 'id')->orderBy('updated_at','DESC');
    }

    public function incomes(){
        return $this->hasMany(Income::class, 'managerid', 'id')->orderBy('updated_at','DESC');
    }

    public function ManagerTrips(){
        return $this->hasMany(Trip::class, 'managerid', 'id');
    }

    public function Trips(){
        return $this->hasMany(Trip::class, 'clientid', 'id');
    }

    public function NotCompletedTrips(){
        return $this->hasMany(Trip::class, 'clientid', 'id')->where('status',0);
    }

    public function Accounts(){
        return $this->hasMany(Account::class, 'clientid', 'id');
    }

    public function ClientExpenses(){
        return $this->hasMany(ExpenseType::class, 'managerid', 'id');
    }

    public function TripsAmount(){
        return $this->hasMany(TripAmount::class, 'managerid', 'id')->orderBy('date','DESC');
    }

    public function ManagerLorry(){
        return ManagerLorry::where('manager_login_id', auth()->user()->id)->pluck('vehicleId')->toArray();
    }

    public function ManagerLorries(){
        return $this->hasMany(ManagerLorry::class, 'manager_login_id', 'id')->select('vehicleId')->pluck('vehicleId')->toArray();
    }
}
