<?php

namespace App\Http\Controllers\AdminControllers;

use App\Admin;
use App\Client;
use App\Vehicle;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashBoardControllers extends Controller
{

    public function __construct(){
        $this->middleware('admin');
    }

    public function home(){
        if(auth()->user()->id ==1){
            $Data['Clients']=Client::get();
            $Data['Admin']=Admin::get();
        }else{
            $Data['Clients']=Client::where([['referral_number',auth()->user()->mobile]])->get();
        }
        return view('admin.Dashboard.home',compact('Data'));
    }

    public function TotalAdminWise(){
        if(auth()->user()->id ==1){
            $Data['Admin']=Admin::get();
        }else{
            $Data['Clients']=Client::where([['referral_number',auth()->user()->mobile]])->get();
        }
        return view('admin.Dashboard.refferalWise',compact('Data'));
    }

    public function AdminClientWise($id){
        $Data['Admin']=Admin::findorfail($id);
        $Data['Clients']=Client::where('referral_number',$Data['Admin']->mobile)->get();
        return view('admin.Dashboard.AdminClientWise',compact('Data'));
    }
}
