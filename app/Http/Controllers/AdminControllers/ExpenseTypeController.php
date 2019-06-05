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

    public function view(){
        $Data['ExpenseTypes']=ExpenseType::get()->all();
        return view('admin.master.expenseType.view',$Data);
    }

    public function add(){
        return view('admin.master.expenseType.add');
    }

    public function save(){
        $this->validate(request(),[
            'expenseType' => 'required|max:255',
        ]);
        try {
            ExpenseType::create([
                'expenseType' => request('expenseType'),
            ]);
            return back()->with('success',['Expense Type','Added Successfully!']);
        }catch (Exception $e){
            return back()->with('danger','Something went wrong!');
        }
    }

    public function edit($id){
        try {
            $Data['ExpenseTypes'] = ExpenseType::findOrfail($id);
            return view('admin.master.expenseType.edit',$Data);
        }catch (Exception $e){
            return back()->with('danger','Something went wrong!');
        }
    }

    public function update($id){
        $this->validate(request(),[
            'expenseType' => 'required|max:255',
        ]);
        try {
            $ExpenseType = ExpenseType::findOrfail($id);
            $ExpenseType->expenseType=request('expenseType');
            $ExpenseType->save();
            return back()->with('success',['Expense Type','Updated Successfully!']);
        }catch (Exception $e){
            return back()->with('danger','Something went wrong!');
        }
    }

    public function delete($id){
        if(Expense::where([['expense_type',$id]])->count() >0 && $id>=17){
            return back()->with('dorry','Expense Type already added by some client');
        }
        try {
            ExpenseType::findOrfail($id)->delete();
            return back()->with('success',['Expense Type','Deleted Successfully!']);
        }catch (Exception $e){
            return back()->with('danger','Something went wrong!');
        }
    }
}
