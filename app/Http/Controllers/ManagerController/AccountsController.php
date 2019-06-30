<?php

namespace App\Http\Controllers\ManagerController;

use App\Account;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AccountsController extends Controller
{
    public function __construct(){
        $this->middleware('manager');
        $this->Account = new Account;
    }

    public function view(){
        return view('manager.master.account.view');
    }

    public function add(){
        return view('manager.master.account.add');
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
            return redirect(route('manager.ViewAccounts'))->with('success',['Account','Added Sucessfully!']);
        }catch (Exception $e){
            return back()->with('danger','Something went wrong!');
        }
    }


    public function edit($id){
        try {
            $Data['Account'] = $this->Account::findorfail($id);
            return view('manager.master.account.edit',$Data);
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
            return redirect(route('manager.ViewAccounts'))->with('success',['Account','Updated Sucessfully!']);
        }catch (Exception $e){
            return back()->with('danger','Something went wrong!');
        }
    }
}
