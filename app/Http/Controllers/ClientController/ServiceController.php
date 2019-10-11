<?php

namespace App\Http\Controllers\ClientController;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Servicetype;
use App\Service;

class ServiceController extends Controller
{
    public function viewvehicle()
    {
    	return view('client.setting.service.viewvehicle');
    }

    public function ViewVehicleServiceList($id)
    {
        try{
            $Data['VehicleId']  = $id;
        	$Data['ServiceTypes'] = Servicetype::where([['clientid',auth()->user()->id]])->get();
            $Data['Services'] = Service::all();
        	return view('client.setting.service.viewservice',$Data);
        }catch (\Exception $e){
            return redirect(url('/client/home'))->with('danger','Something went wrong!');
        }
    }


    public function UpdateServiceDetail($VehicleId,$ServiceId)
    {
        try{
    	$Data['servicetypes'] = Servicetype::findorfail($ServiceId);
        $Data['VehicleId']  = $VehicleId;
        $Data['ServiceTypes'] = Servicetype::where([['clientid',auth()->user()->id]])->get();
    	return view('client.setting.service.updateService',$Data);
        }catch (\Exception $e){
            return redirect(url('/client/home'))->with('danger','Something went wrong!');
        }
    }

    public function SaveServiceStatus(Request $request, $VehicleId,$ServiceId)
    {
        try{
        $Service = new Service();
        $Service->date = $request->date;
        $Service->next_service_km = $request->next_service_km;
        $Service->next_service_date = $request->next_service_date;
        $Service->vehicle_id = $VehicleId;
        $Service->service_type_id = $ServiceId;
        $Service->save();
        return back();
        }catch (\Exception $e){
            return redirect(url('/client/home'))->with('danger','Something went wrong!');
        }
    }

}
