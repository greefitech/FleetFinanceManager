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
            $Data['Admins']=Admin::get();
        }else{
            $Data['Clients']=Client::where([['referral_number',auth()->user()->mobile]])->get();
        }
        return view('admin.Dashboard.home',$Data);
    }

    public function TotalAdminWise(){
        if(auth()->user()->id ==1){
            $Data['Admins']=Admin::get();
        }else{
            $Data['Clients']=Client::where([['referral_number',auth()->user()->mobile]])->get();
        }
        return view('admin.Dashboard.AdminWise',$Data);
    }

    public function AdminClientWise($id)
    {
        $Data['Admins'] = Admin::findorfail($id);
        if ($Data['Admins']->mobile == NUll){
            $Data['Clients'] = Client::where('referral_number', '=' , NULL || '')->get();
        }else{
            $Data['Clients'] = Client::where('referral_number', $Data['Admins']->mobile)->get();
        }
        return view('admin.Dashboard.AdminClientWise',$Data);
    }
}
