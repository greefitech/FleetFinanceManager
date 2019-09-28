<?php

namespace App\Http\Controllers\ClientController;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Servicetype;
class ServiceController extends Controller
{
    public function viewvehicle()
    {
    	return view('client.setting.service.viewvehicle');
    }

    public function ViewVehicleServiceList($id)
    {
        $Data['VehicleId']  = $id;
    	$Data['ServiceTypes'] = Servicetype::where([['clientid',auth()->user()->id]])->get();
    	return view('client.setting.service.viewservice',$Data);
    }


    public function UpdateServiceDetail($VehicleId,$ServiceId)
    {
    	$Data['servicetypes'] = Servicetype::findorfail($ServiceId);
    	return view('client.setting.service.updateService',$Data);
    }

}
