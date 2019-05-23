<?php

namespace App\Http\Controllers\ClientController;

use App\Account;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AccountController extends Controller
{
    public function __construct(){
        $this->middleware('client');
        $this->Account = new Account;
    }

    public function view(){
        return view('client.master.account.view');
    }

    public function add(){
        return view('client.master.account.add');
    }


    public function save(){
        $this->validate(request(),[
            'account'=>'required',
        ]);

        $CustomerData=$this->Account::where([['clientid',auth()->user()->id],['account',request('account')],['HolderName',request('HolderName')]])->first();
        if(!empty($CustomerData)){
            return back()->with('sorry','Account Already Added!!')->withInput();
        }

        try {
            $Account = $this->Account;
            $Account->account=request('account');
            $Account->HolderName=request('HolderName');
            $Account->clientid=auth()->user()->id;
            $Account->save();
            return redirect(route('client.ViewAccounts'))->with('success',['Account','Added Sucessfully!']);
        }catch (Exception $e){
            return back()->with('danger','Something went wrong!');
        }
    }


    public function edit($id){
        try {
            $Data['Account'] = $this->Account::findorfail($id);
            return view('client.master.account.edit',$Data);
        }catch (Exception $e){
            return back()->with('danger','Something went wrong!');
        }
    }

    public function update($id){
        $this->validate(request(),[
            'account'=>'required',
        ]);

        try {
            $Account =$this->Account::findOrfail($id);
            $Account->account=request('account');
            $Account->HolderName=request('HolderName');
            $Account->save();
            return redirect(route('client.ViewAccounts'))->with('success',['Account','Updated Sucessfully!']);
        }catch (Exception $e){
            return back()->with('danger','Something went wrong!');
        }
    }
}
