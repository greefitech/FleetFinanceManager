<?php

namespace App\Http\Controllers\AdminControllers;

use App\VehicleType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class vehicleTypeController extends Controller
{
    public function __construct(){
        $this->middleware('admin');
    }

    public function show(){
        $Data['VehicleTypes']=VehicleType::get()->all();
        return view('admin.vehicleType.view',compact('Data'));
    }


    public function add(){
        return view('admin.vehicleType.add');
    }


    public function addVehicleType(){
        try {
            VehicleType::create([
                'vehicleType' => request('vehicleType'),
            ]);
            return back()->with('success',['Vehicle','Added Sucessfully!']);
        }catch (Exception $e){
            return back()->with('danger','Something went wrong!');
        }
    }



    public function editVehicleType($id){
        try {
            $Data['vehicleType'] = VehicleType::findOrfail($id);
            return view('admin.vehicleType.edit',compact('Data'));
        }catch (Exception $e){
            return back()->with('danger','Something went wrong!');
        }
    }

    public function updateVehicleType($id){
        try {
            $VehicleType = VehicleType::findOrfail($id);
            $VehicleType->vehicleType=request()->vehicleType;
            $VehicleType->save();
            return back()->with('success',['Vehicle','Type Updated Sucessfully!']);
        }catch (Exception $e){
            return back()->with('danger','Something went wrong!');
        }
    }

    public function deleteVehicleType($id){
        try {
            VehicleType::findOrfail($id)->delete();
            return redirect('admin/vehicleType')->with('success','Vehicle Type Deleted Sucessfully!');
        }catch (Exception $e){
            return back()->with('danger','Something went wrong!');
        }
    }
}
