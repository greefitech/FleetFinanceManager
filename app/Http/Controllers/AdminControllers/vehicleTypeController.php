<?php

namespace App\Http\Controllers\AdminControllers;

use App\Vehicle;
use App\VehicleType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class vehicleTypeController extends Controller
{
    public function __construct(){
        $this->middleware('admin');
    }


    public function view(){
        $Data['VehicleTypes']=VehicleType::get()->all();
        return view('admin.master.vehicleType.view',$Data);
    }


    public function add(){
        return view('admin.master.vehicleType.add');
    }


    public function save(){
        $this->validate(request(),[
            'vehicleType' => 'required|unique:vehicle_types|max:255',
            'wheel' => 'required',
        ]);
        try {
            VehicleType::create([
                'vehicleType' => request('vehicleType'),
                'wheel' => request('wheel'),
            ]);
            return back()->with('success',['Vehicle Type','Added Successfully!']);
        }catch (Exception $e){
            return back()->with('danger','Something went wrong!');
        }
    }

    public function edit($id){
        try {
            $Data['vehicleType'] = VehicleType::findOrfail($id);
            return view('admin.master.vehicleType.edit',$Data);
        }catch (Exception $e){
            return back()->with('danger','Something went wrong!');
        }
    }

    public function update($id){
        $this->validate(request(),[
            'vehicleType' => 'required|max:255|unique:vehicle_types,vehicleType,'.$id,
            'wheel' => 'required',
        ]);
        try {
            $VehicleType = VehicleType::findOrfail($id);
            $VehicleType->vehicleType=request('vehicleType');
            $VehicleType->wheel=request('wheel');
            $VehicleType->save();
            return back()->with('success',['Vehicle Type','Updated Successfully!']);
        }catch (Exception $e){
            return back()->with('danger','Something went wrong!');
        }
    }

    public function delete($id){
        if(Vehicle::where([['vehicleType',$id]])->count() >0){
            return back()->with('sorry','Some Client Has Used this Vehicle Type!!');
        }
        try {
            VehicleType::findOrfail($id)->delete();
            return redirect('admin/vehicleType')->with('success',['Vehicle Type','Deleted Successfully!']);
        }catch (Exception $e){
            return back()->with('danger','Something went wrong!');
        }
    }
}
