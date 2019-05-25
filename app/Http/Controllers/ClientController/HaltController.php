<?php

namespace App\Http\Controllers\ClientController;

use App\Halt;
use App\Trip;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HaltController extends Controller
{
    public function __construct(){
        $this->middleware('client');
        $this->Trip = new Trip;
        $this->Halt = new Halt;
    }

    public function add(){
        return view('client.trip.halt.add');
    }

    public function save(){
        $this->validate(request(),[
            'date'=>'required',
            'vehicleId'=>'required|exists:vehicles,id',
            'location'=>'required',
        ]);

        if (!empty(request('tripId'))) {
            $Trip =  $this->Trip::findOrfail(request('tripId'));
            if ($Trip->vehicleId != request('vehicleId')) {
                return back()->with('sorry', 'Vehicle Trip and Vehicle Not Matched !!')->withInput();
            }
        }

        try {
            $Halt = $this->Halt;
            $Halt->tripId=request('tripId');
            $Halt->date=request('date');
            $Halt->vehicleId=request('vehicleId');
            $Halt->location=request('location');
            $Halt->reason=request('reason');
            $Halt->description=request('description');
            $Halt->clientid=auth()->user()->id;
            $Halt->save();
            return redirect(route('client.AddHalt'))->with('success',['Halt','Added Successfully!']);
        }catch (Exception $e){
            return back()->with('danger','Something went wrong!');
        }
    }

    public function edit($id){
        try {
            $Data['Halt']=$this->Halt::findOrfail($id);
            return view('client.trip.halt.edit',$Data);
        }catch (Exception $e){
            return back()->with('danger','Something went wrong!');
        }
    }

    public function update($id){
        $this->validate(request(),[
            'date'=>'required',
            'vehicleId'=>'required|exists:vehicles,id',
            'location'=>'required',
        ]);

        if (!empty(request('tripId'))) {
            $Trip =  $this->Trip::findOrfail(request('tripId'));
            if ($Trip->vehicleId != request('vehicleId')) {
                return back()->with('sorry', 'Vehicle Trip and Vehicle Not Matched !!')->withInput();
            }
        }

        try {
            $Halt = $this->Halt::findOrfail($id);
            $Halt->tripId=request('tripId');
            $Halt->date=request('date');
            $Halt->vehicleId=request('vehicleId');
            $Halt->location=request('location');
            $Halt->reason=request('reason');
            $Halt->description=request('description');
            $Halt->clientid=auth()->user()->id;
            $Halt->save();
            return redirect(route('client.ViewTripHaltList',request('tripId')))->with('success',['Halt','Updated Successfully!']);
        }catch (Exception $e){
            return back()->with('danger','Something went wrong!');
        }
    }


    public function Delete($id){
        try {
            $this->Halt::findOrfail($id)->delete();
            return back()->with('success',['Halt','Deleted Successfully!']);
        }catch (Exception $e){
            return back()->with('danger','Something went wrong!');
        }
    }
}
