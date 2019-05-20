<?php

namespace App\Http\Controllers\API;

use App\Account;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;

class AccountController extends Controller
{
    public $successStatus = 200;


    /**
     * @SWG\Post(
     *     path="/api/account/create",
     *     description="Create New Account",
     *     tags={"Account"},
     *     @swg\Parameter(
     *       in="header",
     *       name="Authorization",
     *       description="",
     *       required=true,
     *       type="string",
     *     ),
     *     @SWG\Parameter(
     *         name="account",
     *         in="query",
     *         type="string",
     *         description="Enter Account / Bank Name",
     *         required=true,
     *     ),
     *     @SWG\Parameter(
     *         name="HolderName",
     *         in="query",
     *         type="string",
     *         description="Enter Account holder name",
     *         required=false,
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


    public function CreateAccount(){
        $validator = Validator::make(request()->all(), [
            'account'=>'required',
        ]);
        if ($validator->fails()) {
            $errData['msg'] = 'Please check the data';
            return response()->json($errData, 401);
        }

        $CustomerData=Account::where([['clientid',auth()->user()->id],['account',request('account')],['HolderName',request('HolderName')]])->first();
        if(!empty($CustomerData)){
            $errData['msg'] = 'Account Already Added';
            return response()->json($errData, 401);
        }

        try {
            $Account = new Account;
            $Account->account=request('account');
            $Account->HolderName=request('HolderName');
            $Account->clientid=auth()->user()->id;
            $Account->save();
            $finalData['msg']='Account Created Successfully';
            return response()->json(['status'=>'success','data' => $finalData], $this-> successStatus);
        }catch (Exception $e){
            $errormsg['msg'] = 'Error On Insert';
            return response()->json(['status'=>'error','data'=>$errormsg], 401);
        }
    }


    /**
     * @SWG\Get(
     *     path="/api/accounts",
     *     description="Return all Accounts",
     *     tags={"Account"},
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


    public function GetAccounts(){
        $finalData['accounts'] = Account::select('id','account','HolderName')->where('clientid',auth()->user()->id)->get()->all();
        return response()->json(['status'=>'success','data' => $finalData], $this-> successStatus);
    }


    /**
     * @SWG\Get(
     *     path="/api/account/{id}/edit",
     *     description="Return particular EAccount",
     *     tags={"Account"},
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


    public function EditAccount($id){
        try{
            $finalData['account'] = Account::select('id','account','HolderName')->findOrfail($id);
            return response()->json(['status'=>'success','data' => $finalData], $this-> successStatus);
        }catch (Exception $e){
            $errormsg['msg'] = 'Something Went Wrong';
            return response()->json(['status'=>'error','data'=>$errormsg], 401);
        }
    }

    /**
     * @SWG\Post(
     *     path="/api/account/{id}/update",
     *     description="Update Account",
     *     tags={"Account"},
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
     *         name="account",
     *         in="query",
     *         type="string",
     *         description="Enter Account / Bank Name",
     *         required=true,
     *     ),
     *     @SWG\Parameter(
     *         name="HolderName",
     *         in="query",
     *         type="string",
     *         description="Enter Account holder name",
     *         required=false,
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


    public function UpdateAccount($id){
        $validator = Validator::make(request()->all(), [
            'account'=>'required',
        ]);
        if ($validator->fails()) {
            $errData['msg'] = 'Please check the data';
            return response()->json($errData, 401);
        }

        $CustomerData=Account::where([['clientid',auth()->user()->id],['account',request('account')],['HolderName',request('HolderName')]])->first();
        if(!empty($CustomerData)){
            $errData['msg'] = 'Account Already Added';
            return response()->json($errData, 401);
        }

        try {
            $Account = Account::findorfail($id);
            $Account->account=request('account');
            $Account->HolderName=request('HolderName');
            $Account->clientid=auth()->user()->id;
            $Account->save();
            $finalData['msg']='Account Updated Successfully';
            return response()->json(['status'=>'success','data' => $finalData], $this-> successStatus);
        }catch (Exception $e){
            $errormsg['msg'] = 'Error On Update';
            return response()->json(['status'=>'error','data'=>$errormsg], 401);
        }
    }
}
