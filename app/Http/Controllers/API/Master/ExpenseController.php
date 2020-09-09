<?php

namespace App\Http\Controllers\API\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Expense;
use App\ExpenseType;
use App\Vehicle;
use Validator;
use Illuminate\Support\Facades\Auth;

class ExpenseController extends Controller
{
    public $successStatus = 200;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        try{
            $success['Expenses'] =  Expense::where([['clientid',auth()->user()->id]])->WhereNull('tripId')->latest('date')->paginate(10);
           return response()->json(['msg'=>'Vehicle Non Trip Expense List','data' =>$success], $this->successStatus);
        }catch (Exception $e){
            return response()->json(['msg'=>'Something Went Wrong'],401);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try{
            $success['Expenses'] =  Expense::with('ExpenseTypes')->where([['clientid',auth()->user()->id],['vehicleId',$id]])->WhereNull('tripId')->latest('date')->get();
           return response()->json(['msg'=>'Vehicle Non Trip Expense List','data' =>$success], $this->successStatus);
        }catch (Exception $e){
            return response()->json(['msg'=>'Something Went Wrong'],401);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
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

    public function GetExpenseType(){
        $success['expenseTypes'] = ExpenseType::select('id','expenseType')->where('clientid',auth()->user()->id)->orderBy('expenseType')->get();
        return response()->json(['msg'=>'Expense Type List','data' => $success], $this->successStatus);
    }
}
