<?php

namespace App\Http\Controllers\API\Setting;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Vehicle;
use App\VehicleService;
use App\Service;

class ServiceController extends Controller
{

    public $successStatus = 200;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $success['VehicleServices'] = VehicleService::where([['clientid',auth()->user()->id]])->orWhereNull('clientid')->get();
        return response()->json(['msg'=>'Service List','data' => $success], $this->successStatus);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


    public function vehicleServiceData($VehicleServiceId,$VehicleId){
        try {
            $success['VehicleServices'] = Service::where([['vehicle_service_id',$VehicleServiceId],['vehicleId',$VehicleId]])->latest()->get();
            return response()->json(['msg'=>'Service List','data' => $success], $this->successStatus);
        }catch (\Exception $e){
            return response()->json(['msg'=>'Something Went Wrong'],401);
        }

    }  
}
