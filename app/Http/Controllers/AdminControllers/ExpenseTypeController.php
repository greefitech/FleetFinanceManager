<?php

namespace App\Http\Controllers\AdminControllers;

use App\Expense;
use App\ExpenseType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ExpenseTypeController extends Controller
{
    public function __construct(){
        $this->middleware('admin');
    }

    public function show(){
        $Data['ExpenseTypes']=ExpenseType::get()->all();
        return view('admin.expenseType.view',compact('Data'));
    }

    public function add(){
        return view('admin.expenseType.add');
    }

    public function addExpenseType(){
        try {
            ExpenseType::create([
                'expenseType' => request('expenseType'),
            ]);
            return back()->with('success',['Expense','Type Added Sucessfully!']);
        }catch (Exception $e){
            return back()->with('danger','Something went wrong!');
        }
    }

    public function editExpenseType($id){
        try {
            $Data['ExpenseTypes'] = ExpenseType::findOrfail($id);
            return view('admin.expenseType.edit',compact('Data'));
        }catch (Exception $e){
            return back()->with('danger','Something went wrong!');
        }
    }

    public function updateExpenseType($id){
        try {
            $ExpenseType = ExpenseType::findOrfail($id);
            $ExpenseType->expenseType=request()->expenseType;
            $ExpenseType->save();
            return back()->with('success',['Expense','Type Updated Sucessfully!']);
        }catch (Exception $e){
            return back()->with('danger','Something went wrong!');
        }
    }

    public function deleteExpenseType($id){
        $ExpenseCount=Expense::where([['expense_type',$id]])->count();
        if($ExpenseCount>0){
            return back()->with('danger',['Something went wrong!','Delete Customer Cause Some Data Loss! Contact Admin!']);
        }
        try {
            ExpenseType::findOrfail($id)->delete();
            return back()->with('success',['Vehicle','Type Deleted Sucessfully!']);
        }catch (Exception $e){
            return back()->with('danger','Something went wrong!');
        }
    }
}
