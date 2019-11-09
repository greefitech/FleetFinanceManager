<?php

namespace App\Http\Controllers\ClientController;

use App\Account;
use App\Vehicle;
use App\Entry;
use App\Expense;
use App\Income;
use App\ExtraIncome;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AccountController extends Controller
{
    public function __construct(){
        $this->middleware('client');
        $this->Vehicle = new Vehicle;
        $this->Account = new Account;
        $this->Expense = new Expense;       
        $this->Incomes = new Income;
        $this->ExtraIncome = new ExtraIncome;
    }

    public function view(){
        return view('client.master.account.view');
    }

    public function add(){
        return view('client.master.account.add');
    }


    public function save(){
        $this->validate(request(),[
            'account'=>'required',
        ]);

        $CustomerData=$this->Account::where([['clientid',auth()->user()->id],['account',request('account')],['HolderName',request('HolderName')]])->first();
        if(!empty($CustomerData)){
            return back()->with('sorry','Account Already Added!!')->withInput();
        }

        try {
            $Account = $this->Account;
            $Account->account=request('account');
            $Account->HolderName=request('HolderName');
            $Account->clientid=auth()->user()->id;
            $Account->save();
            return redirect(route('client.ViewAccounts'))->with('success',['Account','Added Sucessfully!']);
        }catch (\Exception $e){
            return back()->with('danger','Something went wrong!');
        }
    }


    public function edit($id){
        try {
            $Data['Account'] = $this->Account::findorfail($id);
            return view('client.master.account.edit',$Data);
        }catch (\Exception $e){
            return back()->with('danger','Something went wrong!');
        }
    }

    public function update($id){
        $this->validate(request(),[
            'account'=>'required',
        ]);

        try {
            $Account =$this->Account::findOrfail($id);
            $Account->account=request('account');
            $Account->HolderName=request('HolderName');
            $Account->save();
            return redirect(route('client.ViewAccounts'))->with('success',['Account','Updated Sucessfully!']);
        }catch (\Exception $e){
            return back()->with('danger','Something went wrong!');
        }
   }

   public function ViewAccountDetail($id){
        try {
            $Data['Account'] =$this->Account::findOrfail($id);
            $Data['AccountId'] = $id;
            $Data['vehicles'] = $this->Vehicle::where([['clientid',auth()->user()->id]])->get();
            $Data['Entries']  = Entry::where([['account_id',$id],['clientid',auth()->user()->id]])->get()->groupBy('vehicleId');
            $Data['Expenses'] = $this->Expense::where([['account_id',$id],['clientid',auth()->user()->id]])->get()->groupBy('vehicleId');
            $Data['Incomes'] = $this->Incomes::where([['account_id',$id],['clientid',auth()->user()->id]])->get()->groupBy('vehicleId');
            $Data['ExtraIncomes'] = $this->ExtraIncome::where([['account_id',$id],['clientid',auth()->user()->id]])->get()->groupBy('vehicleId');
            return view('client.master.account.account_summery',$Data);
         }catch (\Exception $e){
            return back()->with('danger','Something went wrong!');
        }
    }

    public function AccountDetailVehicleWise($AccountId,$VehicleId){
        try {
            $Data['Account'] =$this->Account::findOrfail($AccountId);
            $Data['Vehicle'] =$this->Vehicle::findOrfail($VehicleId);

            $Data['Entries']  = Entry::where([['account_id',$AccountId],['vehicleId',$VehicleId],['clientid',auth()->user()->id]])->get();
            $Data['Expenses'] = $this->Expense::where([['account_id',$AccountId],['vehicleId',$VehicleId],['clientid',auth()->user()->id]])->get();
            $Data['Incomes'] = $this->Incomes::where([['account_id',$AccountId],['vehicleId',$VehicleId],['clientid',auth()->user()->id]])->get();
            $Data['ExtraIncomes'] = $this->ExtraIncome::where([['account_id',$AccountId],['vehicleId',$VehicleId],['clientid',auth()->user()->id]])->get();
            return view('client.master.account.AccountDetailVehicleWise',$Data);
        }catch (\Exception $e){
            return back()->with('danger','Something went wrong!');
        }
    }

}   

