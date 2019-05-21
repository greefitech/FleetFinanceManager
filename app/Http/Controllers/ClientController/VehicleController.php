<?php

namespace App\Http\Controllers\ClientController;

use App\Client;
use App\Vehicle;
use App\VehicleType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class VehicleController extends Controller
{
    public function __construct(){
        $this->middleware('client');
        $this->Vehicle = new Vehicle;
        $this->Client = new Client;
    }

    public function view(){
        return view('client.master.vehicle.view');
    }

    public function add(){
        $Data['VehicleType']=VehicleType::get()->all();
        return view('client.master.vehicle.add',$Data);
    }


    public function save(){
        $this->validate(request(),[
            'ownerName'=>'required',
            'vehicleNumber'=>'required',
            'vehicleName'=>'required',
            'vehicleLastKm'=>'required',
            'vehicleType'=>'required|exists:vehicle_types,id',
        ]);

        $Client = $this->Client::findOrfail(auth()->user()->id);
        $vehicle = $this->Vehicle::where([['clientid',auth()->user()->id]])->count();
        if($Client->vehicleCredit!=''&& $Client->vehicleCredit<=$vehicle){
            return back()->with('sorry','Contact Admin To Add More Vehicle!')->withInput();
        }

        try {
            $this->Vehicle::create([
                'ownerName' => request('ownerName'),
                'vehicleNumber' => strtoupper(request('vehicleNumber')),
                'vehicleName' => request('vehicleName'),
                'vehicleType' => request('vehicleType'),
                'vehicleLastKm' => request('vehicleLastKm'),
                'modelNumber' => request('modelNumber'),
                'VehicleProfit' => request('VehicleProfit'),
                'clientid' => auth()->user()->id,
            ]);
            return back()->with('success','Added Successfully');
        }catch (Exception $e){
            return back()->with('danger','Something went wrong!');
        }
    }

    public function edit($id){
        try{
            $vehicle = $this->Vehicle::findOrfail($id);
            $vehicleTypes=VehicleType::get()->all();
            return view('client.masters.vehicle.edit',compact('vehicle','vehicleTypes'));
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
            $vehicle->VehicleProfit = request('VehicleProfit');
            $vehicle->save();
            return back()->with('success','Vehicle Updated Sucessfully!');
        }catch (Exception $e){
            return back()->with('danger','Something went wrong!');
        }
    }
    public function delete($id){
        return back()->with('sorry','Something went wrong! Contact Admin.');
    }
}
