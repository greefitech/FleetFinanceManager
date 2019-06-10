<?php

namespace App\Http\Controllers\ClientController;

use App\Tyre;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TyreController extends Controller
{
    public function view(){
        $Data['Tyres'] = Tyre::where([['clientid',auth()->user()->id]])->get();
        return view('client.master.tyre.view',$Data);
    }

    public function add(){
        return view('client.master.tyre.add');
    }

    public function save(){
        $this->validate(request(),[
            'tyre_number'=>'required',
            'manufacture_company'=>'required',
        ]);
        try {
            $Tyre = new Tyre;
            $Tyre->tyre_number = request('tyre_number');
            $Tyre->model = request('model');
            $Tyre->manufacture_company = request('manufacture_company');
            $Tyre->condition = request('condition');
            $Tyre->original_depth = request('original_depth');
            $Tyre->current_depth = request('current_depth');
            $Tyre->purchased_from = request('purchased_from');
            $Tyre->tyre_status = request('tyre_status');
            $Tyre->clientid=auth()->user()->id;
            $Tyre->save();
            return redirect(route('client.ViewTyres'))->with('success',['Tyre','Added Successfully!']);
        }catch (Exception $e){
            return back()->with('danger','Something went wrong!');
        }
    }

    public function edit($id){
        try {
            $Data['Tyre'] = Tyre::findorfail($id);
            return view('client.master.tyre.edit',$Data);
        }catch (Exception $e){
            return back()->with('danger','Something went wrong!');
        }
    }

    public function update($id){
        $this->validate(request(),[
            'tyre_number'=>'required',
            'manufacture_company'=>'required',
        ]);



        try {
            $Tyre = Tyre::findorfail($id);
            $Tyre->tyre_number = request('tyre_number');
            $Tyre->model = request('model');
            $Tyre->manufacture_company = request('manufacture_company');
            $Tyre->condition = request('condition');
            $Tyre->original_depth = request('original_depth');
            $Tyre->current_depth = request('current_depth');
            $Tyre->purchased_from = request('purchased_from');
            $Tyre->tyre_status = request('tyre_status');
            $Tyre->clientid=auth()->user()->id;
//            if($Tyre->isDirty('tyre_number')){
//                return 'tyre number changes! insert data to tyre log';
//            }
            $Tyre->save();


            return redirect(route('client.ViewTyres'))->with('success',['Tyre','Updated Successfully!']);
        }catch (Exception $e){
            return back()->with('danger','Something went wrong!');
        }
    }

    public function ViewTyreStatus($id){
        try {
            $Data['Tyre'] = Tyre::findorfail($id);
            return view('client.master.tyre.TyreStatus',$Data);
        }catch (Exception $e){
            return back()->with('danger','Something went wrong!');
        }
    }
}
