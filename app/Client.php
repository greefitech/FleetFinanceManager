<?php

namespace App;

use App\Notifications\ClientResetPassword;
use Carbon\Carbon;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;
use Laravel\Passport\HasApiTokens;

class Client extends Authenticatable
{
    use HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'mobile', 'transportName', 'address', 'wallet', 'expires_on','referral_number'
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
        $this->notify(new ClientResetPassword($token));
    }
    public function customers(){
        return $this->hasMany(Customer::class, 'clientid', 'id')->orderBy('name');
    }

    public function vehicles(){
        return $this->hasMany(Vehicle::class, 'clientid', 'id');
    }

    public function staffs(){
        return $this->hasMany(Staff::class, 'clientid', 'id')->orderBy('name');
    }

    public function entries(){
        return $this->hasMany(Entry::class, 'clientid', 'id')->orderBy('updated_at','DESC');
    }

    public function expenses(){
        return $this->hasMany(Expense::class, 'clientid', 'id')->orderBy('updated_at','DESC');
    }

    public function incomes(){
        return $this->hasMany(Income::class, 'clientid', 'id')->orderBy('updated_at','DESC');
    }

    public function managers(){
        return $this->hasMany(Manager::class, 'clientid', 'id')->orderBy('updated_at','DESC');
    }

    public function Trips(){
        return $this->hasMany(Trip::class, 'clientid', 'id')->orderBy('dateFrom','DESC');
    }

    public function TripsAmount(){
        return $this->hasMany(TripAmount::class, 'clientid', 'id')->orderBy('date','DESC');
    }

    public function NotCompletedTrips(){
        return $this->hasMany(Trip::class, 'clientid', 'id')->where('status',0);
    }

    public function Accounts(){
        return $this->hasMany(Account::class, 'clientid', 'id');
    }

    public function Halts(){
        return $this->hasMany(Halt::class, 'clientid', 'id');
    }

    public function ClientExpenses(){
        return $this->hasMany(ExpenseType::class, 'clientid', 'id');
    }

    public function TotalIncome(){
        return $this->hasMany(VehicleCredits::class, 'clientid', 'id');
    }

    public function refferedBY(){
        return $this->hasMany(Admin::class, 'mobile', 'referral_number');
    }



    public function get_outstanding_amount(){
        @$total_entry_amount = Entry::where('clientid', Auth::user()->id)->sum('balance');
        @$total_income_amount = Income::where('clientid', Auth::user()->id)->sum('recevingAmount');
        @$total_discounted_amount = Income::where('clientid', Auth::user()->id)->sum('discountAmount');
        return $total_entry_amount-$total_income_amount-$total_discounted_amount;
    }


    public function CalculateProfitAmountTotal($VehicleId=NULL,$month,$year){
        if(!empty($VehicleId)){
            $Trips = Trip::where([['clientid', Auth::user()->id],['vehicleId',  $VehicleId]])->whereYear('dateTo', '=', $year)->whereMonth('dateTo', '=', $month)->get();
            $total_income =0;
            foreach ($Trips as $Trip){
                $total_income += ($this->TripTotalIncome($Trip->id) - $this->TripTotalExpense($Trip->id));
            }
            return $total_income+ExtraIncome::where([['clientid', Auth::user()->id],['vehicleId',  $VehicleId]])->whereYear('date', '=', $year)->whereMonth('date', '=', $month)->sum('amount');
        }else{
            $Trips= Trip::where('clientid', Auth::user()->id)->whereYear('dateTo', '=', $year)->whereMonth('dateTo', '=', $month)->get();
            $total_income =0;
            foreach ($Trips as $Trip){
                $total_income += ($this->TripTotalIncome($Trip->id) - $this->TripTotalExpense($Trip->id));
            }
            return $total_income+ExtraIncome::where('clientid', auth()->user()->id)->whereYear('date', '=', $year)->whereMonth('date', '=', $month)->sum('amount');
        }
    }


    public function CalculateNonTripExpenseAmountTotal($VehicleId=NULL,$month,$year){
        if(!empty($VehicleId)){
            return Expense::where([['clientid', Auth::user()->id],['vehicleId',$VehicleId]])->where('tripId', NULL)->whereYear('date', '=', $year)->whereMonth('date', '=', $month)->sum('amount');

        }else{
            return Expense::where('clientid', Auth::user()->id)->where('tripId', NULL)->whereYear('date', '=', $year)->whereMonth('date', '=', $month)->sum('amount');
        }
    }


    public function CurrentMonthExpensesVehicleExpenseWiseType($vehicleId,$ExpenseTypeId){
        return $total_expense_amount = Expense::where([['clientid', Auth::user()->id],['tripId',NULL],['vehicleId',$vehicleId],['expense_type',$ExpenseTypeId]])->where('date', '>=', Carbon::now()->startOfMonth())->sum('amount');
    }


    public function currentMonthIncomeVehicleWiseAccount($vehicleId,$AccountId){
        @$total_entry_amount = Entry::where([['clientid', Auth::user()->id],['vehicleId',$vehicleId],['account_id',$AccountId]])->where('dateFrom', '>=', Carbon::now()->startOfMonth())->sum('advance');
        @$total_income_amount = Income::where([['clientid', Auth::user()->id],['vehicleId',$vehicleId],['account_id',$AccountId]])->where('date', '>=', Carbon::now()->startOfMonth())->sum('recevingAmount');
        return $total_entry_amount+$total_income_amount;
    }


    public function GetEntryDataTripWise($tripId){
        return Entry::where([['clientid', Auth::user()->id],['tripId',$tripId]])->get();
    }

    public function GetExpenseDataTripWise($tripId){
        return Expense::where([['clientid', Auth::user()->id],['tripId',$tripId]])->get();
    }

    public function TripTotalIncome($tripId){
        @$total_entry_amount = Entry::where([['clientid', Auth::user()->id],['tripId',$tripId]])->sum('billAmount');
//        @$total_income_amount = Income::where([['clientid', Auth::user()->id],['tripId',$tripId]])->sum('recevingAmount');
//        return $total_entry_amount+$total_income_amount;
        return $total_entry_amount;
    }

    public function TripTotalExpense($tripId){
        @$total_comission_amount = Entry::where([['clientid', Auth::user()->id],['tripId',$tripId]])->sum('comission');
        @$total_loadingMamool_amount = Entry::where([['clientid', Auth::user()->id],['tripId',$tripId]])->sum('loadingMamool');
        @$total_unLoadingMamool_amount = Entry::where([['clientid', Auth::user()->id],['tripId',$tripId]])->sum('unLoadingMamool');
        @$total_expense_amount = Expense::where([['clientid', Auth::user()->id],['tripId',$tripId], ['status',1]])->sum('amount');
        $entryDatas = Entry::where([['tripId',$tripId]])->get();
        $Trip= Trip::findorfail($tripId);
        return $total_comission_amount+$total_loadingMamool_amount+$total_unLoadingMamool_amount+$total_expense_amount + @$entryDatas->sum('driverPadiAmount')  + @$entryDatas->sum('cleanerPadiAmount');
    }

    public function TripTotalBalance($tripId){
        @$total_entry_Bill_amount = Entry::where([['clientid', Auth::user()->id],['tripId',$tripId]])->sum('billAmount');
        @$total_entry_Advance_amount = Entry::where([['clientid', Auth::user()->id],['tripId',$tripId]])->sum('advance');
        @$total_income_receving_amount = Income::where([['clientid', Auth::user()->id],['tripId',$tripId]])->sum('recevingAmount');
        @$total_income_discount_amount = Income::where([['clientid', Auth::user()->id],['tripId',$tripId]])->sum('discountAmount');
        return $total_entry_Bill_amount-($total_entry_Advance_amount+$total_income_receving_amount+$total_income_discount_amount);
    }

    public function tripSheetIncomeEntry($entryId){
        @$total_income_receving_amount = Income::where([['entryId',$entryId]])->sum('recevingAmount');
        return $total_income_receving_amount;
    }

    public function Trip_Total_Driver_Advance($tripId){
        @$tripAdvance = Trip::select('advance')->where('id', $tripId)->first();
        @$totalTripAmount = TripAmount::where('tripId', $tripId)->sum('amount');
        return $tripAdvance->advance + $totalTripAmount;
    }


    public function TotalEntryIncome($entryId){
        @$total_entry_amount = Entry::where([['clientid', Auth::user()->id],['id',$entryId]])->sum('advance');
        @$total_income_amount = Income::where([['clientid', Auth::user()->id],['entryId',$entryId]])->sum('recevingAmount');
        return $total_entry_amount+$total_income_amount;
    }


    public function CalculateExpenseTripWiseWithAccount($tripId,$expense_type){
        $data['cash']=Expense::where([['clientid', Auth::user()->id],['tripId',$tripId], ['expense_type',$expense_type],['account_id',1]])->sum('amount');
        $data['account']=Expense::where([['clientid', Auth::user()->id],['tripId',$tripId], ['expense_type',$expense_type],['account_id','!=',1]])->sum('amount');;
        return $data;
    }

    public function CalculateOilServiceBalanceKm($vehicleId){
        $finaldata['OilService'] = OilService::where([['vehicleId',$vehicleId],['clientid', Auth::user()->id]])->orderBy('date', 'DESC')->first();
        $finaldata['Trip'] = Trip::where([['vehicleId',$vehicleId],['clientid', Auth::user()->id]])->orderBy('dateFrom', 'DESC')->first();
        return $finaldata;
    }


    public function getVehicleTotalProfitAmount($VehicleId){
        $Trips= Trip::where([['clientid', Auth::user()->id],['vehicleId',$VehicleId]])->get();
        $total_income =0;
        foreach ($Trips as $Trip){
            $total_income += ($this->TripTotalIncome($Trip->id) - $this->TripTotalExpense($Trip->id));
        }
        return $total_income+ExtraIncome::where([['clientid', auth()->user()->id],['vehicleId',$VehicleId]])->sum('amount')-Expense::where([['clientid', Auth::user()->id],['vehicleId',$VehicleId]])->where('tripId', NULL)->sum('amount')+Vehicle::findorfail($VehicleId)->VehicleProfit;
    }

    public function getVehicleTotalDiesel($VehicleId){
        return $Expense= Expense::where([['clientid', Auth::user()->id],['vehicleId',$VehicleId],['expense_type','=', '2']])->get();
    }
}
