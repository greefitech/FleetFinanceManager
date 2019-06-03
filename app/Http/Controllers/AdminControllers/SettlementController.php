<?php

namespace App\Http\Controllers\AdminControllers;

use App\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SettlementController extends Controller
{
   public function Settlement(){
       return view('admin.settlement.view');
   }

   public function AddSettlement(){
       if(auth()->user()->id ==1){
           $Data['Clients']=Client::get();
       }else{
           $Data['Clients']=Client::where([['referral_number',auth()->user()->mobile]])->get();
       }
       return view('admin.settlement.add',compact('Data'));
   }

    public function SaveSettlement(){
        return request()->all();
//        return view('admin.settlement.add',compact('Data'));
    }
}
