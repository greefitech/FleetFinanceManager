<?php

namespace App\Http\Controllers\ManagerController;

use App\Client;
use App\Manager;
use App\Vehicle;
use App\VehicleType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class VehicleController extends Controller
{
    public function __construct(){
        $this->middleware('manager');
        $this->Vehicle = new Vehicle;
        $this->Client = new Client;
        $this->Manager = new Manager;
    }

    public function view(){
        $Data['Vehicles']=Vehicle::get()->all();
        return view('manager.master.vehicle.view',$Data);
    }

    public function add(){
        $Data['VehicleTypes']=VehicleType::get()->all();
        return view('manager.master.vehicle.add',$Data);
    }


    public function edit($id){
        try{
            $Data['Vehicle'] = $this->Vehicle::findOrfail($id);
            $Data['VehicleTypes']=VehicleType::get()->all();
            return view('manager.master.vehicle.edit',$Data);
        }catch (Exception $e){
            return back()->with('danger','Something went wrong!');
        }
    }

    public function update($id){
        $this->validate(request(),[
            'ownerName'=>'required',
            'vehicleNumber'=>'required',
            'vehicleName'=>'required',
            'vehicleType'=>'required|exists:vehicle_types,id',
        ]);
        try{
            $vehicle = $this->Vehicle::findOrfail($id);
            $vehicle->ownerName = request('ownerName');
            $vehicle->vehicleNumber = strtoupper(request('vehicleNumber'));
            $vehicle->vehicleName = request('vehicleName');
            $vehicle->vehicleType = request('vehicleType');
            $vehicle->modelNumber = request('modelNumber');
            $vehicle->engine_number = request('engine_number');
            $vehicle->chassis_number = request('chassis_number');
            $vehicle->manufacture_date = request('manufacture_date');
            $vehicle->fuel_tank_capacity = request('fuel_tank_capacity');
            $vehicle->vehicle_purchased_date = request('vehicle_purchased_date');
            $vehicle->VehicleProfit = request('VehicleProfit');
            $vehicle->save();
            return back()->with('success',['Vehicle','Updated Successfully']);
        }catch (Exception $e){
            return back()->with('danger','Something went wrong!');
        }
    }
}
