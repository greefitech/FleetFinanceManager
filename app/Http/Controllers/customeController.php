<?php

namespace App\Http\Controllers;

use App\Trip;
use App\Vehicle;
use Illuminate\Http\Request;

class customeController extends Controller
{
    public function getTripDatas(){
        return $trip = Trip::findOrfail(request('tripId'));
    }

    public function getVehicleData(){
        return Vehicle::findorfail(request('vehicleId'));
    }
}
