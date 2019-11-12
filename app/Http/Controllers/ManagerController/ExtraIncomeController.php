<?php

namespace App\Http\Controllers\ManagerController;

use App\ExpenseType;
use App\ExtraIncome;
use App\Vehicle;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ExtraIncomeController extends Controller
{
    public function __construct(){
        $this->middleware('manager');
        $this->ExpenseType = new ExpenseType;
        $this->ExtraIncome = new ExtraIncome;
        $this->Vehicle = new Vehicle;
    }

    public function add(){
        $Data['ExpenseTypes'] = $this->ExpenseType::where('clientid', auth()->user()->owner->id)->orWhereNull('clientid')->get();
        return view('manager.extra-income.add', $Data);
    }

    public function save(){
        $this->validate(request(),[
            'date'=>'required|date',
            'vehicleId'=>'required|exists:vehicles,id',
            'amount'=>'required',
            'expense_type'=>'required'
        ],[
            'expense_type.required'=>'The income type is required'
        ]);
        try {
            $ExtraIncome = $this->ExtraIncome;
            $ExtraIncome->date = request('date');
            $ExtraIncome->expense_type = request('expense_type');
            $ExtraIncome->vehicleId = request('vehicleId');
            $ExtraIncome->amount = request('amount');
            $ExtraIncome->description = request('description');
            $ExtraIncome->status = request('status');
            $ExtraIncome->account_id = request('account_id');
            $ExtraIncome->clientid = auth()->user()->owner->id;
            $ExtraIncome->managerid = auth()->user()->id;
            $ExtraIncome->save();
            return redirect(route('manager.ViewExtraIncomes'))->with('success', ['Extra Income','Added Successfully!']);
        }catch (\Illuminate\Database\QueryException $e) {
            return back()->with('danger','Something went wrong!');
        }
    }

    public function view(){
        return view('manager.extra-income.LorryList');
    }

    public function ViewExtraIncomeVehicleWiseList($VehicleId){
        try {
            $Data['Vehicle'] = $this->Vehicle::findorfail($VehicleId);
            $Data['ExtraIncomes'] =  $this->ExtraIncome::where([['managerid', auth()->user()->id],['vehicleId', $VehicleId]])->orderBy('date','desc')->get();
            return view('manager.extra-income.view',$Data);
        } catch (\Illuminate\Database\QueryException $e) {
            return back()->with('danger','Something went wrong! Delete Not Allowed!');
        }
    }

    public function edit($id){
        try {
            $Data['ExtraIncome'] = $this->ExtraIncome::findorfail($id);
            $Data['ExpenseTypes'] = $this->ExpenseType::where('clientid', auth()->user()->owner->id)->orWhereNull('clientid')->get();
            return view('manager.extra-income.edit', $Data);
        } catch (\Illuminate\Database\QueryException $e) {
            return back()->with('danger','Something went wrong! Delete Not Allowed!');
        }
    }

    public function update($id){
        $this->validate(request(),[
            'date'=>'required|date',
            'vehicleId'=>'required|exists:vehicles,id',
            'amount'=>'required',
            'expense_type'=>'required'
        ],[
            'expense_type.required'=>'The income type is required'
        ]);
        try {
            $ExtraIncome = $this->ExtraIncome::findorfail($id);
            $ExtraIncome->date = request('date');
            $ExtraIncome->expense_type = request('expense_type');
            $ExtraIncome->vehicleId = request('vehicleId');
            $ExtraIncome->amount = request('amount');
            $ExtraIncome->description = request('description');
            $ExtraIncome->status = request('status');
            $ExtraIncome->account_id = request('account_id');
            $ExtraIncome->save();
            return redirect(route('manager.ViewExtraIncomeVehicleWiseList',request('vehicleId')))->with('success', ['Extra Income','Updated Successfully!']);
        }catch (\Illuminate\Database\QueryException $e) {
            return back()->with('danger','Something went wrong!');
        }
    }

    public function delete($id){
        try {
            $this->ExtraIncome::findorfail($id)->delete();
            return back()->with('success',['Extra Income','Deleted Sucessfully!']);
        } catch (\Illuminate\Database\QueryException $e) {
            return back()->with('danger','Something went wrong! Delete Not Allowed!');
        }
    }
}
