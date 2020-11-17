<?php

namespace App\Http\Controllers\ClientController\Auditor;

use App\AuditorExpenseCategory;
use App\AuditorExpenseType;
use App\ExpenseType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ExpenseCategoryGroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $Data['AuditorExpenseCategories']= AuditorExpenseCategory::where([['clientid',auth()->user()->id]])->get();
        return view('client.auditor.category.index',$Data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $Data['ExpenseTypes'] =ExpenseType::where('clientid', auth()->user()->id)->orWhereNull('clientid')->orderBy('id')->get();
        return view('client.auditor.category.create',$Data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate(request(),[
            'category'=>'required',
            'expense_type_id'=>'required',
            'type'=>'required'
        ]);
        try {
            if(AuditorExpenseCategory::where([['category',request('category')],['type',request('type')],['clientid',auth()->user()->id]])->first()){
                return back()->with('sorry','Account Already Added!!')->withInput();
            }
            if(!empty(request('expense_type_id'))){
                $AuditorExpenseCategory = new AuditorExpenseCategory;
                $AuditorExpenseCategory->category = request('category');
                $AuditorExpenseCategory->type = request('type');
                $AuditorExpenseCategory->clientid = auth()->user()->id;
                $AuditorExpenseCategory->save();
                foreach(request('expense_type_id') as $ExpenseId){
                    $AuditorExpenseType = new AuditorExpenseType;
                    $AuditorExpenseType->expense_type_id =$ExpenseId;
                    $AuditorExpenseType->auditor_expense_category_id = $AuditorExpenseCategory->id;
                    $AuditorExpenseType->save();
                }
            }
            return redirect(action('ClientController\Auditor\ExpenseCategoryGroupController@index'))->with('success',['Expense Type','Added Successfully!']);
        }catch (Exception $e){
            return back()->with('danger','Something went wrong!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $Data['AuditorExpenseCategory'] =  AuditorExpenseCategory::findorfail($id);
        $Data['ExpenseTypes'] =ExpenseType::where('clientid', auth()->user()->id)->orWhereNull('clientid')->orderBy('id')->get();
        $Data['AuditorExpenseTypes'] = AuditorExpenseType::where([['auditor_expense_category_id',$id]])->get();
        return view('client.auditor.category.create',$Data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate(request(),[
            'category'=>'required',
            'expense_type_id'=>'required',
            'type'=>'required'
        ]);
        try {
            $AuditorExpenseCategory =  AuditorExpenseCategory::findorfail($id);
            $AuditorExpenseCategory->category = request('category');
            $AuditorExpenseCategory->type = request('type');
            $AuditorExpenseCategory->save();
            $AuditorExpenseTypes = AuditorExpenseType::where([['auditor_expense_category_id',$id]])->pluck('expense_type_id')->toArray();
            $AuditorExpenseTypesList = AuditorExpenseType::where([['auditor_expense_category_id',$id]])->get();
            if(!empty(request('expense_type_id'))){

                foreach(request('expense_type_id') as $ExpenseId){
                    if (!in_array($ExpenseId, $AuditorExpenseTypes)) {
                        $AuditorExpenseType = new AuditorExpenseType;
                        $AuditorExpenseType->expense_type_id =$ExpenseId;
                        $AuditorExpenseType->auditor_expense_category_id = $AuditorExpenseCategory->id;
                        $AuditorExpenseType->save();
                    }
                }



                foreach($AuditorExpenseTypesList as $ExpenseId){
                    if (!in_array($ExpenseId->expense_type_id, request('expense_type_id'))) {
                        $ExpenseId->delete();
                    }
                }


                
            }
            return redirect(action('ClientController\Auditor\ExpenseCategoryGroupController@index'))->with('success',['Expense Type','Updated Successfully!']);
        }catch (Exception $e){
            return back()->with('danger','Something went wrong!');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
