<?php

namespace App\Http\Controllers\ClientController;

use App\Expense;
use App\ExpenseType;
use App\Trip;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ExpenseController extends Controller
{
    public function __construct(){
        $this->middleware('client');
        $this->ExpenseType = new ExpenseType;
        $this->Expense = new Expense;
        $this->Trip = new Trip;
    }

    public function add(){
        $Data['ExpenseTypes'] =  $this->ExpenseType::where('clientid',auth()->user()->id)->orWhereNull('clientid')->get();
        return view('client.expense.add',$Data);
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
                'clientid' => auth()->user()->id,
            ]);
            return back()->with('success',['Expense','Added Successfully!'])->withInput();
        } catch (\Illuminate\Database\QueryException $e) {
            return back()->with('danger', 'Something went wrong!');
        }
    }

    public function edit($id){
        try {
            $Data['ExpenseTypes'] =  $this->ExpenseType::where('clientid',auth()->user()->id)->orWhereNull('clientid')->get();
            $Data['Expense'] = $this->Expense::findorfail($id);
            return view('client.expense.edit',$Data);
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

    public function delete($id){
        try {
            $this->Expense::findOrfail($id)->delete();
            return back()->with('success',['Expense','Deleted Successfully!']);
        } catch (\Illuminate\Database\QueryException $e) {
            return back()->with('danger','Something went wrong! Delete Not Allowed!');
        }
    }

    /*
     * NON Trip Expense List
     */

    public function ExpenseVehcleListNonTrip(){
        return view('client.expense.LorryList');
    }

    public function NonTripVehicleExpenseList($VehicleId){
        try {
            $Data['Expenses'] = $this->Expense::where([['clientid', auth()->user()->id], ['vehicleId', $VehicleId]])->where('tripId', NULL)->orderBy('date', 'DESC')->get();
            return view('client.expense.view-non-trip-expense',$Data);
        } catch (\Illuminate\Database\QueryException $e) {
            return back()->with('danger', 'Something went wrong!');
        }
    }
}