<?php

namespace App\Http\Controllers\ClientController;

use App\Expense;
use App\ExpenseType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;


class ExpenseTypeController extends Controller
{

    public function __construct(){
        $this->middleware('client');
        $this->ExpenseType = new ExpenseType;
        $this->Expense = new Expense;
    }

    public function view(){
        if (request()->ajax()) {
            $ExpenseTypes = $this->ExpenseType::where('clientid',auth()->user()->id);
            return DataTables::of($ExpenseTypes)
            ->addColumn('action',
                '<a href="{{ action(\'ClientController\CustomerController@edit\',[$id]) }}" class="btn btn-md" data-toggle="tooltip" data-placement="right"><i class="fa fa-edit"></i></a>'
            )
            ->addColumn('created_by',function($ExpenseType){
                    return $ExpenseType->client->name;
            })
            ->rawColumns(['action'])->make(true);
        }
        return view('client.master.expenseType.view');
    }

    public function add(){
        return view('client.master.expenseType.add');
    }

    public function save()
    {
        $this->validate(request(), [
            'expenseType' => 'required',
        ]);
        $ExpenseData = $this->ExpenseType::where([['clientid', Auth::user()->id], ['expenseType', request('expenseType')]])->first();
        if (!empty($ExpenseData->expenseType)) {
            return back()->with('sorry', 'Expense Type Already Added!!')->withInput();
        }
        try {
            $this->ExpenseType::create([
                'expenseType' => request('expenseType'),
                'clientid' => auth()->user()->id,
            ]);
            return redirect(route('client.ViewExpenseTypes'))->with('success', ['Expense Type', 'Added Successfully!']);
        } catch (\Illuminate\Database\QueryException $e) {
            return back()->with('danger', 'Something went wrong!');
        }
    }


    public function edit($id){
        try {
            $Data['ExpenseType'] = $this->ExpenseType::findOrfail($id);
            return view('client.master.expenseType.edit',$Data);
        } catch (\Illuminate\Database\QueryException $e) {
            return back()->with('danger', 'Something went wrong!');
        }
    }

    public function update($id){
        $this->validate(request(),[
            'expenseType'=>'required',
        ]);
        $ExpenseData=$this->ExpenseType::where([['clientid',Auth::user()->id],['id','!=',$id],['expenseType',request('expenseType')]])->get();
        if($ExpenseData->count() > 0){
            return back()->with('sorry','Expense Type Already Added!!')->withInput();
        }

        try {
            $ExpenseType = $this->ExpenseType::findOrfail($id);
            $ExpenseType->expenseType=request()->expenseType;
            $ExpenseType->save();
            return redirect(route('client.ViewExpenseTypes'))->with('success', ['Expense Type', 'Updated Successfully!']);
        }catch (Exception $e){
            return back()->with('danger','Something went wrong!');
        }
    }


    public function delete($id){
        $ExpenseCount = $this->Expense::where([['expense_type',$id]])->count();
        if($ExpenseCount>0){
            return back()->with('sorry','Something went wrong! Delete Expense Type Cause Some Data Loss! Contact Admin!');
        }
        try {
            $this->ExpenseType::findOrfail($id)->delete();
            return redirect(route('client.ViewExpenseTypes'))->with('success',['Expense Type','Deleted Successfully!']);
        }catch (Exception $e){
            return back()->with('danger','Something went wrong!');
        }
    }
}
