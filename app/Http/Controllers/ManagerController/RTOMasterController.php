<?php

namespace App\Http\Controllers\ManagerController;


use App\RTOMaster;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RTOMasterController extends Controller
{

    public function __construct(){
        $this->middleware('manager');
    }
    public function view(){
        $Data['RTOMasters'] = RTOMaster::where([['clientid',auth()->user()->Owner->id]])->get();
        return view('manager.master.rto.view',$Data);
    }

    public function add(){
        return view('manager.master.rto.add');
    }

    public function save(){
        $this->validate(request(),[
            'place'=>'required',
        ]);

        if(!empty(request('RTOData'))){
            $RTOMasterValidator=[];
            foreach(request('RTOData')['location'] as $RTOKey=>$RTO){
                $RTOMasterValidator['RTOData.location.'.$RTOKey] = 'required';
                $RTOMasterValidator['RTOData.amount.'.$RTOKey] = 'nullable|min:0|numeric';
            }
            $this->validate(request(), $RTOMasterValidator);
        }
        try {
            $RTOMaster = new RTOMaster;
            $RTOMaster->place = request('place');
            $RTOMaster->description = serialize(request('RTOData'));
            $RTOMaster->clientid=auth()->user()->Owner->id;
            $RTOMaster->managerid=auth()->user()->id;
            $RTOMaster->save();
            return redirect(route('manager.ViewRTOMasters'))->with('success',['RTO Master','Created Successfully']);
        }catch (Exception $e){
            return back()->with('danger','Something went wrong!');
        }
    }

    public function edit($id){
        try {
            $Data['RTOMasters'] = RTOMaster::findorfail($id);
            return view('manager.master.rto.edit',$Data);
        }catch (Exception $e){
            return back()->with('danger','Something went wrong!');
        }
    }

    public function update($id){
        $this->validate(request(),[
            'place'=>'required',
        ]);

        if(!empty(request('RTOData'))){
            $RTOMasterValidator=[];
            foreach(request('RTOData')['location'] as $RTOKey=>$RTO){
                $RTOMasterValidator['RTOData.location.'.$RTOKey] = 'required';
                $RTOMasterValidator['RTOData.amount.'.$RTOKey] = 'nullable|min:0|numeric';
            }
            $this->validate(request(), $RTOMasterValidator);
        }
        try {
            $RTOMaster = RTOMaster::findorfail($id);
            $RTOMaster->place = request('place');
            $RTOMaster->description = serialize(request('RTOData'));
            $RTOMaster->clientid=auth()->user()->Owner->id;
            $RTOMaster->save();
            return redirect(route('manager.ViewRTOMasters'))->with('success',['RTO Master','Updated Successfully']);
        }catch (Exception $e){
            return back()->with('danger','Something went wrong!');
        }
    }

    public function delete($id){
        try {
            RTOMaster::findorfail($id)->delete();
            return back()->with('success',['RTO Master','Deleted Successfully']);
        }catch (Exception $e){
            return back()->with('danger','Something went wrong!');
        }
    }
}