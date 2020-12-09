<?php

namespace App\Http\Controllers\API\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Validator;
use Illuminate\Support\Facades\Auth;
use App\Expense;
use App\ExpenseType;
use App\Vehicle;
use App\Vendor;

class ExpenseController extends Controller
{
    public $successStatus = 200;

    public function __construct(){
        $this->Vendor = new Vendor;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        try{
            $success['Expenses'] =  Expense::with('ExpenseTypes','Account')->where([['clientid',auth()->user()->id]])->WhereNull('tripId')->latest('date')->paginate(10);
           return response()->json(['msg'=>'Vehicle Non Trip Expense List','data' =>$success], $this->successStatus);
        }catch (\Exception $e){
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
    public function store(Request $request){
        $validator = Validator::make(request()->all(), [
           'date'=>'required|date',
            'vehicleId'=>'required|exists:vehicles,id',
            'amount'=>'required',
            'account_id'=>'required',
            'expense_type'=>'required|exists:expense_types,id',
            'quantity'=>'required_if:type,==,2',
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->toArray() as $value) {
               $errData[]=$value[0];
            }
            return response()->json(['msg'=>'Please check the data','error'=>$errData], 401);
        }
        try {
            Expense::create([
                'date' => request('date'),
                'expense_type' => request('expense_type'),
                'vehicleId' => request('vehicleId'),
                'quantity' => request('quantity'),
                'amount' => request('amount'),
                'discription' => request('discription'),
                'location' => request('location'),
                'status'=>request('status'),
                'account_id' => request('account_id'),
                'clientid' => auth()->user()->id,
            ]);
            return response()->json(['msg'=>'Non Trip Expense Created Successfully'], $this->successStatus);
        }catch (\Exception $e){
            return response()->json(['msg'=>'Error On Insert'], 401);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id){
        try{
            $success['Expenses'] =  Expense::with('ExpenseTypes','Account')->where([['clientid',auth()->user()->id],['vehicleId',$id]])->WhereNull('tripId')->latest('date')->paginate(10);
           return response()->json(['msg'=>'Vehicle Non Trip Expense List','data' =>$success], $this->successStatus);
        }catch (\Exception $e){
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
        $validator = Validator::make(request()->all(), [
            'status'=>'required',
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->toArray() as $value) {
               $errData[]=$value[0];
            }
            return response()->json(['msg'=>'Please check the data','error'=>$errData], 422);
        }
        try {
            Expense::findorfail($id)->update([
                'status'=>request('status'),
            ]);
            return response()->json(['msg'=>'Non Trip Expense Updated Successfully'], $this->successStatus);
        }catch (\Exception $e){
            return response()->json(['msg'=>'Error On Insert'], 422);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id){
        try {
            Expense::findOrfail($id)->delete();
            return response()->json(['msg'=>'Expense Deleted Successfully!'], $this->successStatus);
        }catch (\Exception $e){
            return response()->json(['msg'=>'Error On Delete!'], 422);
        }  
    }

    public function GetExpenseType(){
        $success['expenseTypes'] = ExpenseType::select('id','expenseType')->where('clientid',auth()->user()->id)->orderBy('expenseType')->get();
        return response()->json(['msg'=>'Expense Type List','data' => $success], $this->successStatus);
    }

    /*Vendor list*/
    public function vendor(){
         try {
            $success['vendors'] = $this->Vendor::where('clientid',auth()->user()->id)->get();
            return response()->json(['msg'=>'Vendor List','data' => $success], $this->successStatus);
        }catch (\Exception $e){
            return response()->json(['msg'=>'Error On Delete!'], 422);
        } 
    }
}
