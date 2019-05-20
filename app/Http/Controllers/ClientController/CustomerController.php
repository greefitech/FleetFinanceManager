<?php

namespace App\Http\Controllers\ClientController;

use App\Customer;
use App\Entry;
use App\Income;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;


class CustomerController extends Controller
{
    public function __construct(){
        $this->middleware('client');
        $this->Customer = new Customer;
    }

    public function view(){
        return view('client.master.customer.view');
    }

    public function add(){
        return view('client.master.customer.add');
    }

    public function show($id){
        try {
            $customer = $this->Customer::findOrfail($id);
            return view('client.masters.customer.view', compact('customer'));
        }catch (Exception $e){
            return back()->with('danger','Something went wrong!');
        }
    }

    public function Save(){
        $this->validate(request(),[
            'name'=>'required',
            'mobile'=>'required|regex:/[0-9]{10}/',
            'address'=>'required',
            'type'=>'required|in:broker,direct',
        ]);

        $CustomerData=$this->Customer::where([['clientid',Auth::user()->id],['mobile',request('mobile')]])->first();
        if(!empty($CustomerData->mobile)){
            return back()->with('sorry','Customer Already Exist!!')->withInput();
        }
        if($this->Customer->CreateUpdateCustomer('') == 'success'){
            return redirect('client/customers')->with('success',['Customer','Created Successfully']);
        }else{
            return back()->with('danger','Something went wrong!');
        }
    }

    public function edit($id){
        try{
            $Data['Customer'] = $this->Customer::findOrfail($id);
            return view('client.master.customer.edit',$Data);
        }catch (Exception $e){
            return back()->with('danger','Something went wrong!');
        }
    }

    public function update($id){
        $this->validate(request(),[
            'name'=>'required',
            'mobile'=>'required|regex:/[0-9]{10}/',
            'address'=>'required',
            'type'=>'required|in:broker,direct',
        ]);

        $CustomerData=$this->Customer::where([['clientid',Auth::user()->id],['id','!=',$id],['mobile',request('mobile')]])->get();
        if($CustomerData->count() >0){
            return back()->with('danger','Customer Already Added!!')->withInput();
        }
        if($this->Customer->CreateUpdateCustomer($id) == 'success'){
            return redirect('client/customers')->with('success',['Customer','Update Successfully']);
        }else{
            return back()->with('danger','Something went wrong!');
        }
    }

    public function delete($id){
        return $this->Customer->DeleteCustomer($id);
    }
}
