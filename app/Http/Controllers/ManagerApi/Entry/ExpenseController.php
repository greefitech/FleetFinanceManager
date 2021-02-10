<?php

namespace App\Http\Controllers\ManagerApi\Entry;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\TripTemp;
use DB;
use Validator;

class ExpenseController extends Controller{

    private $successStatus = 200,$errorStatus = 200;

    public function __construct(){
        $this->TripTemp = new TripTemp;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        try {
            $TempTrip = $this->TripTemp::findorfail(request('trip_id'));
            $extraExpense = unserialize($TempTrip->extraExpense);
            $FinalArray = array();
            if (!empty($extraExpense)) {
                foreach ($extraExpense['expense_type'] as $key => $value) {
                    $Array=array(
                        'expense_type'=>$extraExpense['expense_type'][$key],
                        'quantity'=>$extraExpense['quantity'][$key],
                        'location'=>$extraExpense['location'][$key],
                        'amount'=>$extraExpense['amount'][$key],
                        'discription'=>$extraExpense['discription'][$key],
                        'account_id'=>$extraExpense['account_id'][$key],
                        'status'=>$extraExpense['status'][$key],
                    );
                    $FinalArray[]=$Array;
                }
            }
             $success['expense'] = $FinalArray;
            return response()->json(['msg'=>'Expense List','data'=>$success], $this->successStatus);
        }catch (\Exception $e){
            return response()->json(['msg'=>'Something Went Wrong'],422);
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
    public function store(Request $request){
        $validator = Validator::make(request()->all(), [
            'trip_id'=>'required',
            'amount'=>'required',
            'account_id'=>'required',
            'expense_type'=>'required',
        ]);
        if ($validator->fails()) {
            foreach ($validator->errors()->toArray() as $value) {
                return response()->json(['msg'=>$value[0]], 422);
            }
        }
        try {
            $TempTrip = $this->TripTemp::findorfail(request('trip_id'));
            $extraExpense = unserialize($TempTrip->extraExpense);
            $extraExpense['expense_type'][]=request('expense_type');
            $extraExpense['quantity'][]=request('quantity');
            $extraExpense['location'][]=request('location');
            $extraExpense['amount'][]=request('amount');
            $extraExpense['discription'][]=request('discription');
            $extraExpense['account_id'][]=request('account_id');
            $extraExpense['status'][]=request('status');

            $TempTrip->extraExpense = serialize($extraExpense);
            $TempTrip->save();
            return response()->json(['msg'=>'Expense Created Successfully'], $this->successStatus);
        }catch (\Exception $e){
            return response()->json(['msg'=>'Something Went Wrong'],422);
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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id){
        $validator = Validator::make(request()->all(), [
            'trip_id'=>'required',
            'amount'=>'required',
            'account_id'=>'required',
            'expense_type'=>'required',
        ]);
        if ($validator->fails()) {
            foreach ($validator->errors()->toArray() as $value) {
                return response()->json(['msg'=>$value[0]], 422);
            }
        }
         try {
            $TempTrip = $this->TripTemp::findorfail($id);
            $extraExpense = unserialize($TempTrip->extraExpense);
            array_splice($extraExpense['expense_type'],request('index'),1);
            array_splice($extraExpense['quantity'],request('index'),1);
            array_splice($extraExpense['location'],request('index'),1);
            array_splice($extraExpense['amount'],request('index'),1);
            array_splice($extraExpense['discription'],request('index'),1);
            array_splice($extraExpense['account_id'],request('index'),1);
            array_splice($extraExpense['status'],request('index'),1);

            $extraExpense['expense_type'][]=request('expense_type');
            $extraExpense['quantity'][]=request('quantity');
            $extraExpense['location'][]=request('location');
            $extraExpense['amount'][]=request('amount');
            $extraExpense['discription'][]=request('discription');
            $extraExpense['account_id'][]=request('account_id');
            $extraExpense['status'][]=request('status');
            $TempTrip->extraExpense = serialize($extraExpense);
            $TempTrip->save();
            return response()->json(['msg'=>'Toll Updated Successfully'], $this->successStatus);
        }catch (\Exception $e){
            return response()->json(['msg'=>'Something Went Wrong'],422);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        try {
            $TempTrip = $this->TripTemp::findorfail($id);
            $extraExpense = unserialize($TempTrip->extraExpense);
            array_splice($extraExpense['expense_type'],request('index'),1);
            array_splice($extraExpense['quantity'],request('index'),1);
            array_splice($extraExpense['location'],request('index'),1);
            array_splice($extraExpense['amount'],request('index'),1);
            array_splice($extraExpense['discription'],request('index'),1);
            array_splice($extraExpense['account_id'],request('index'),1);
            array_splice($extraExpense['status'],request('index'),1);
            $TempTrip->extraExpense = serialize($extraExpense);
            $TempTrip->save();
            return response()->json(['msg'=>'Expense Removed Successfully'], $this->successStatus);
        }catch (\Exception $e){
            return response()->json(['msg'=>'Something Went Wrong'],422);
        }
    }
}
