<?php

namespace App\Http\Controllers\ManagerController;

use App\Expense;
use App\ExpenseType;
use App\Trip;
use App\Vehicle;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ExpenseController extends Controller
{
    public function __construct(){
        $this->middleware('manager');
        $this->ExpenseType = new ExpenseType;
        $this->Expense = new Expense;
        $this->Trip = new Trip;
    }

    public function add(){
        $Data['ExpenseTypes'] =  $this->ExpenseType::where('clientid',auth()->user()->owner->id)->orWhereNull('clientid')->get();
        return view('manager.trip.expense.add',$Data);
    }

    public function save(){
        $this->validate(request(),[
            'date'=>'required|date',
            'vehicleId'=>'required|exists:vehicles,id',
            'amount'=>'required',
            'expense_type'=>'required|exists:expense_types,id',
            'staffId'=>'required_if:type,==,1',
            'quantity'=>'required_if:type,==,2',
            'tripId'=>'nullable|exists:trips,id|required_if:type,==,2|required_if:type,==,1',
        ]);
        if (!empty(request('tripId'))) {
            $Trip =  $this->Trip::findOrfail(request('tripId'));
            if ($Trip->vehicleId != request('vehicleId')) {
                return back()->with('sorry', 'Vehicle Trip and Vehicle Not Matched !!')->withInput();
            }
            $this->validate(request(),[
                'date'=>'required|date|after_or_equal:.'.$Trip->dateFrom.'|before_or_equal:.'.$Trip->dateTo,
            ],[
                'date.after_or_equal'=>'Check Date With Trip',
                'date.before_or_equal'=>'Check Date With Trip',
            ]);
        }
        try {
            $this->Expense::create([
                'date' => request('date'),
                'expense_type' => request('expense_type'),
                'vehicleId' => request('vehicleId'),
                'staffId' => request('staffId'),
                'quantity' => request('quantity'),
                'amount' => request('amount'),
                'discription' => request('discription'),
                'location' => request('location'),
                'status'=>request('status'),
                'account_id' => request('account_id'),
                'tripId' => request('tripId'),
                'clientid' => auth()->user()->owner->id,
                'managerid' => auth()->user()->id,
            ]);
            return back()->with('success',['Expense','Added Successfully!'])->withInput();
        } catch (\Illuminate\Database\QueryException $e) {
            return back()->with('danger', 'Something went wrong!');
        }
    }

    public function edit($id){
        try {
            $Data['ExpenseTypes'] =  $this->ExpenseType::where('clientid',auth()->user()->owner->id)->orWhereNull('clientid')->get();
            $Data['Expense'] = $this->Expense::findorfail($id);
            return view('manager.trip.expense.edit',$Data);
        } catch (\Illuminate\Database\QueryException $e) {
            return back()->with('danger', 'Something went wrong!');
        }
    }

    public function update($id){
        $this->validate(request(),[
            'date'=>'required|date',
            'vehicleId'=>'required|exists:vehicles,id',
            'amount'=>'required',
            'expense_type'=>'required|exists:expense_types,id',
            'staffId'=>'required_if:type,==,1',
            'quantity'=>'required_if:type,==,2',
            'tripId'=>'nullable|exists:trips,id|required_if:type,==,2|required_if:type,==,1',
        ]);
        if (!empty(request('tripId'))) {
            $Trip =  $this->Trip::findOrfail(request('tripId'));
            if ($Trip->vehicleId != request('vehicleId')) {
                return back()->with('sorry', 'Vehicle Trip and Vehicle Not Matched !!')->withInput();
            }
            $this->validate(request(),[
                'date'=>'required|date|after_or_equal:.'.$Trip->dateFrom.'|before_or_equal:.'.$Trip->dateTo,
            ],[
                'date.after_or_equal'=>'Check Date With Trip',
                'date.before_or_equal'=>'Check Date With Trip',
            ]);
        }
        try {
            $this->Expense::findorfail($id)->update([
                'date' => request('date'),
                'expense_type' => request('expense_type'),
                'vehicleId' => request('vehicleId'),
                'staffId' => request('staffId'),
                'quantity' => request('quantity'),
                'amount' => request('amount'),
                'discription' => request('discription'),
                'location' => request('location'),
                'status'=>request('status'),
                'account_id' => request('account_id'),
                'tripId' => request('tripId'),
            ]);
            return back()->with('success',['Expense','Updated Successfully!'])->withInput();
        } catch (\Illuminate\Database\QueryException $e) {
            return back()->with('danger', 'Something went wrong!');
        }
    }

    public function delete($id)
    {
        try {
            $this->Expense::findOrfail($id)->delete();
            return back()->with('success', ['Expense', 'Deleted Successfully!']);
        } catch (\Illuminate\Database\QueryException $e) {
            return back()->with('danger', 'Something went wrong! Delete Not Allowed!');
        }
    }




    public function GetLastExpenseTypeDetail(){
        $Expense= Expense::where([['managerid', auth()->user()->owner->id],['managerid',auth()->user()->id],['vehicleId', request('vehicleID')],['expense_type', request('ExpenseType')]])->orderBy('date', 'DESC')->first();
        return '        Date : '.date('d-m-Y', strtotime($Expense->date)).'
        Quantity : '.$Expense->quantity.'
        Amount : '.$Expense->amount.'
        Discription : '.$Expense->discription;
    }

    /*
     * NON Trip Expense List
     */


     public function CreateNonTripExpense(){
        $Data['ExpenseTypes'] =  $this->ExpenseType::where('managerid',auth()->user()->id)->orWhereNull('managerid')->get();
        return view('manager.trip.expense.nontrip.add',$Data);
    }

     public function SaveNonTripExpense(){
        $this->validate(request(),[
            'date'=>'required|date',
            'amount'=>'required',
            'expense_type'=>'required|exists:expense_types,id',
            'staffId'=>'required_if:type,==,1',
            'quantity'=>'required_if:type,==,2',
        ]);
        try {
            $this->Expense::create([
                'date' => request('date'),
                'expense_type' => request('expense_type'),
                'vehicleId' => request('vehicleId'),
                'staffId' => request('staffId'),
                'quantity' => request('quantity'),
                'amount' => request('amount'),
                'discription' => request('discription'),
                'location' => request('location'),
                'status'=>request('status'),
                'account_id' => request('account_id'),
                'clientid' => auth()->user()->owner->id,
                'managerid' => auth()->user()->id,
            ]);
            return back()->with('success',['Expense','Added Successfully!'])->withInput();
         }catch (\Exception $e){
            return back()->with('danger', 'Something went wrong!');
        }
    }

    public function ExpenseVehcleListNonTrip(){
        return view('manager.trip.expense.LorryList');
    }

    public function NonTripVehicleExpenseList($VehicleId){
        try {
            $Data['Vehicle'] = Vehicle::findorfail($VehicleId);
            $Data['Expenses'] = $this->Expense::where([['managerid', auth()->user()->id], ['vehicleId', $VehicleId]])->where('tripId', NULL)->orderBy('date', 'DESC')->get();
            return view('manager.trip.expense.view-non-trip-expense',$Data);
        } catch (\Illuminate\Database\QueryException $e) {
            return back()->with('danger', 'Something went wrong!');
        }
    }


     public function EditNonTripExpense($id){
        try {
            $Data['ExpenseTypes'] =  $this->ExpenseType::where('managerid',auth()->user()->id)->orWhereNull('managerid')->get();
            $Data['Expense'] = $this->Expense::findorfail($id);
            return view('manager.trip.expense.nontrip.edit',$Data);
        } catch (\Illuminate\Database\QueryException $e) {
            return back()->with('danger', 'Something went wrong!');
        }
    }

    public function UpdateNonTripExpense($id){
        $this->validate(request(),[
            'date'=>'required|date',
            'vehicleId'=>'required|exists:vehicles,id',
            'amount'=>'required',
            'expense_type'=>'required|exists:expense_types,id',
            'staffId'=>'required_if:type,==,1',
            'quantity'=>'required_if:type,==,2',
        ]);
        try {
            $this->Expense::findorfail($id)->update([
                'date' => request('date'),
                'expense_type' => request('expense_type'),
                'vehicleId' => request('vehicleId'),
                'staffId' => request('staffId'),
                'quantity' => request('quantity'),
                'amount' => request('amount'),
                'discription' => request('discription'),
                'location' => request('location'),
                'status'=>request('status'),
                'account_id' => request('account_id'),
            ]);
            return back()->with('success',['Expense','Updated Successfully!'])->withInput();
        } catch (\Illuminate\Database\QueryException $e) {
            return back()->with('danger', 'Something went wrong!');
        }
    }
}
