<?php

namespace App\Http\Controllers\API\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Account;
use Validator;

class AccountController extends Controller
{
    public $successStatus = 200;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        $success['accounts'] = Account::select('id','account','HolderName')->where('clientid',auth()->user()->id)->get();
        return response()->json(['msg'=>'Account List','data' => $success], $this->successStatus);
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
            return response()->json(['msg'=>'Account Saved Successfully'], $this->successStatus);
        }catch (\Exception $e){
            return response()->json(['msg'=>'Something Went Wrong'],401);
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
        try{
            $success['account'] = Account::select('id','account','HolderName')->findOrfail($id);
            return response()->json(['msg'=>'Account','data' => $success], $this-> successStatus);
        }catch (\Exception $e){
            return response()->json(['msg'=>'Something Went Wrong'],401);
        }
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
            return response()->json(['msg'=>'Account Updated Successfully'], $this->successStatus);
        }catch (\Exception $e){
            return response()->json(['msg'=>'Something Went Wrong'],401);
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
