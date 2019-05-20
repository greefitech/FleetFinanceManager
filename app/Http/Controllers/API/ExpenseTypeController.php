<?php

namespace App\Http\Controllers\API;

use App\Expense;
use App\ExpenseType;
use App\Vehicle;
use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;


class ExpenseTypeController extends Controller
{
    public function __construct(){
        $this->ExpenseType = new ExpenseType;
        $this->Vehicle = new Vehicle;
    }
    public $successStatus = 200;


    /**
     * @SWG\Post(
     *     path="/api/expenseType/create",
     *     description="Create New Expense Type",
     *     tags={"ExpenseType"},
     *     @swg\Parameter(
     *       in="header",
     *       name="Authorization",
     *       description="",
     *       required=true,
     *       type="string",
     *     ),
     *     @SWG\Parameter(
     *         name="expenseType",
     *         in="query",
     *         type="string",
     *         description="Enter Expense Type",
     *         required=true,
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="OK",
     *     ),
     *     @SWG\Response(
     *         response=401,
     *         description="Invalid Data"
     *     ),
     *     security={ {"bearer": {}} },
     * )
     */


    public function CreateExpenseType(Request $request){
        $validator = Validator::make($request->all(), [
            'expenseType'=>'required',
        ]);
        if ($validator->fails()) {
            $errData['msg'] = 'Please check the data';
            return response()->json($errData, 401);
        }
        $ExpenseData=$this->ExpenseType::where([['clientid',Auth::user()->id],['expenseType',request('expenseType')]])->first();
        if(!empty($ExpenseData->expenseType)){
            $errData['msg'] = 'Expense Type Already Added';
            return response()->json($errData, 401);
        }
        try {
            $this->ExpenseType::create([
                'expenseType' => request('expenseType'),
                'clientid' => auth()->user()->id,
            ]);
            $finalData['msg']='Expense Type Created Successfully';
            return response()->json(['status'=>'success','data' => $finalData], $this-> successStatus);
        } catch (\Illuminate\Database\QueryException $e) {
            $errormsg['msg'] = 'Error On Insert';
            return response()->json(['status'=>'error','data'=>$errormsg], 401);
        }
    }


    /**
     * @SWG\Get(
     *     path="/api/expenseTypes",
     *     description="Return all Expense Type",
     *     tags={"ExpenseType"},
     *     @swg\Parameter(
     *       in="header",
     *       name="Authorization",
     *       description="",
     *       required=true,
     *       type="string",
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="OK",
     *     ),
     *     @SWG\Response(
     *         response=401,
     *         description="Invalid Data"
     *     ),
     *     security={ {"bearer": {}} },
     * )
     */


    public function GetExpenseType(){
        $finalData['expenseType'] = $this->ExpenseType::select('id','expenseType')->where('clientid',auth()->user()->id)->get()->all();
        return response()->json(['status'=>'success','data' => $finalData], $this-> successStatus);
    }


    /**
     * @SWG\Get(
     *     path="/api/expenseType/{id}/edit",
     *     description="Return particular Expense Type",
     *     tags={"ExpenseType"},
     *     @swg\Parameter(
     *       in="header",
     *       name="Authorization",
     *       description="",
     *       required=true,
     *       type="string",
     *     ),
     *      @SWG\Parameter(
     *          name="id",
     *          in="path",
     *          required=true,
     *          type="string"
     *      ),
     *     @SWG\Response(
     *         response=200,
     *         description="OK",
     *     ),
     *     @SWG\Response(
     *         response=401,
     *         description="Invalid Data"
     *     ),
     *     security={ {"bearer": {}} },
     * )
     */


    public function EditExpenseType($id){
        try{
            $finalData['expenseType'] = $this->ExpenseType::select('id','expenseType')->findOrfail($id);
            return response()->json(['status'=>'success','data' => $finalData], $this-> successStatus);
        }catch (Exception $e){
            $errormsg['msg'] = 'Something Went Wrong';
            return response()->json(['status'=>'error','data'=>$errormsg], 401);
        }
    }


    /**
     * @SWG\Post(
     *     path="/api/expenseType/{id}/update",
     *     description="Create New Expense Type",
     *     tags={"ExpenseType"},
     *     @swg\Parameter(
     *       in="header",
     *       name="Authorization",
     *       description="",
     *       required=true,
     *       type="string",
     *     ),
     *     @SWG\Parameter(
     *          name="id",
     *          in="path",
     *          required=true,
     *          type="string"
     *      ),
     *     @SWG\Parameter(
     *         name="expenseType",
     *         in="query",
     *         type="string",
     *         description="Enter Expense Type",
     *         required=true,
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="OK",
     *     ),
     *     @SWG\Response(
     *         response=401,
     *         description="Invalid Data"
     *     ),
     *     security={ {"bearer": {}} },
     * )
     */


    public function UpdateExpenseType(Request $request,$id){
        $validator = Validator::make($request->all(), [
            'expenseType'=>'required',
        ]);
        if ($validator->fails()) {
            $errData['msg'] = 'Please check the data';
            return response()->json($errData, 401);
        }
        $ExpenseData=$this->ExpenseType::where([['clientid',Auth::user()->id],['expenseType',request('expenseType')]])->first();
        if(!empty($ExpenseData->expenseType)){
            return back()->with('danger','Expense Already Added!!')->withInput();
        }
        try {
            $ExpenseType = $this->ExpenseType::findOrfail($id);
            $ExpenseType->expenseType=request()->expenseType;
            $ExpenseType->save();
            $finalData['msg']='Expense Type Updated Successfully';
            return response()->json(['status'=>'success','data' => $finalData], $this-> successStatus);
        } catch (\Illuminate\Database\QueryException $e) {
            $errormsg['msg'] = 'Error On Update';
            return response()->json(['status'=>'error','data'=>$errormsg], 401);
        }
    }

    /**
     * @SWG\Delete(
     *     path="/api/expenseType/{id}/delete",
     *     description="Delete Expense Type Data",
     *     tags={"ExpenseType"},
     *     @swg\Parameter(
     *       in="header",
     *       name="Authorization",
     *       description="",
     *       required=true,
     *       type="string",
     *     ),
     *     @SWG\Parameter(
     *          name="id",
     *          in="path",
     *          required=true,
     *          type="string"
     *      ),
     *     @SWG\Response(
     *         response=200,
     *         description="OK",
     *     ),
     *     @SWG\Response(
     *         response=401,
     *         description="Invalid Data"
     *     ),
     *     security={ {"bearer": {}} },
     * )
     */

    public function DeleteExpenseType($id){
        $ExpenseCount=Expense::where([['expense_type',$id]])->count();
        if($ExpenseCount>0){
            $errormsg['msg'] = 'Something Went Wrong!! Cause Some Data Loss ! Contact Admin!';
            return response()->json(['status'=>'error','data'=>$errormsg], 401);
        }
        try {
            $this->ExpenseType::findOrfail($id)->delete();
            $finalData['msg']='Expense Type Deleted Successfully';
            return response()->json(['status'=>'success','data' => $finalData], $this-> successStatus);
        } catch (\Illuminate\Database\QueryException $e) {
            $errormsg['msg'] = 'Something Went Wrong';
            return response()->json(['status'=>'error','data'=>$errormsg], 401);
        }
    }
}
