<?php

namespace App;

use App\Notifications\ManagerResetPassword;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;

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

    public function Staffs(){
        return $this->hasMany(Staff::class, 'clientid', 'clientid')->orderBy('name');
    }

    public function Vehicles(){
        $ManagerLorry = ManagerLorry::where('manager_login_id', auth()->user()->id)->pluck('vehicleId')->toArray();
        return $this->hasMany(Vehicle::class, 'clientid', 'clientid')->whereIn('id',$ManagerLorry)->get();
    }

    public function Accounts(){
        return $this->hasMany(Account::class, 'clientid', 'clientid');
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
        $ManagerLorry = ManagerLorry::where('manager_login_id', auth()->user()->id)->pluck('vehicleId')->toArray();
        return Trip::whereIn('status',[0,1])->whereIn('vehicleId',$ManagerLorry)->get();
    }



    public function ClientExpenses(){
        return $this->hasMany(ExpenseType::class, 'managerid', 'id');
    }

    public function TripsAmount(){
        return $this->hasMany(TripAmount::class, 'managerid', 'id')->orderBy('date','DESC');
    }


    public function ManagerLorries(){
        return $this->hasMany(ManagerLorry::class, 'manager_login_id', 'id')->select('vehicleId')->pluck('vehicleId')->toArray();
    }

    public function TripTotalIncome($tripId){
        @$total_entry_amount = Entry::where([['clientid', auth()->user()->owner->id],['tripId',$tripId]])->sum('billAmount');
//        @$total_income_amount = Income::where([['clientid', Auth::user()->id],['tripId',$tripId]])->sum('recevingAmount');
//        return $total_entry_amount+$total_income_amount;
        return $total_entry_amount;
    }

    public function TripTotalExpense($tripId){
        @$total_comission_amount = Entry::where([['clientid', auth()->user()->owner->id],['tripId',$tripId]])->sum('comission');
        @$total_loadingMamool_amount = Entry::where([['clientid', auth()->user()->owner->id],['tripId',$tripId]])->sum('loadingMamool');
        @$total_unLoadingMamool_amount = Entry::where([['clientid', auth()->user()->owner->id],['tripId',$tripId]])->sum('unLoadingMamool');
        @$total_expense_amount = Expense::where([['clientid', auth()->user()->owner->id],['tripId',$tripId], ['status',1]])->sum('amount');
        $entryDatas = Entry::where([['tripId',$tripId]])->get();
        $Trip= Trip::findorfail($tripId);
        return $total_comission_amount+$total_loadingMamool_amount+$total_unLoadingMamool_amount+$total_expense_amount + @$entryDatas->sum('driverPadiAmount')  + @$entryDatas->sum('cleanerPadiAmount');
    }

    public function TripTotalBalance($tripId){
        @$total_entry_Bill_amount = Entry::where([['clientid', auth()->user()->owner->id],['tripId',$tripId]])->sum('billAmount');
        @$total_entry_Advance_amount = Entry::where([['clientid', auth()->user()->owner->id],['tripId',$tripId]])->sum('advance');
        @$total_income_receving_amount = Income::where([['clientid', auth()->user()->owner->id],['tripId',$tripId]])->sum('recevingAmount');
        @$total_income_discount_amount = Income::where([['clientid', auth()->user()->owner->id],['tripId',$tripId]])->sum('discountAmount');
        return $total_entry_Bill_amount-($total_entry_Advance_amount+$total_income_receving_amount+$total_income_discount_amount);
    }

    public function getVehicleTotalProfitAmount($VehicleId){
        $Trips= Trip::where([['clientid', auth()->user()->owner->id],['vehicleId',$VehicleId]])->get();
        $total_income =0;
        foreach ($Trips as $Trip){
            $total_income += ($this->TripTotalIncome($Trip->id) - $this->TripTotalExpense($Trip->id));
        }
        return $total_income+ExtraIncome::where([['clientid', auth()->user()->id],['vehicleId',$VehicleId]])->sum('amount')-Expense::where([['clientid', Auth::user()->id],['vehicleId',$VehicleId]])->where('tripId', NULL)->sum('amount')+Vehicle::findorfail($VehicleId)->VehicleProfit;
    }
}
