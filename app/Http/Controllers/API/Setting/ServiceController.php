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
       
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate(request(),[
            'date' => 'required',
            'service_station_name'=>'required',
            'next_service_date'=>'required',
        ]);
        try {
            $Service = new Service;
            $Service->vehicleId = request('vehicleId');
            $Service->vehicle_service_id = request('vehicle_service_id');
            $Service->date = request('date');
            $Service->next_service_date = request('next_service_date');
            $Service->service_station_name = request('service_station_name');
            $Service->service_km = request('service_km');
            $Service->next_service_km = request('next_service_km');
            $Service->note = request('note');
            $Service->clientid = auth()->user()->id;
            $Service->save();
             response()->json(['msg'=>'Service List Created Successfully'], $this->successStatus);
        }catch (\Exception $e){
            return response()->json(['msg'=>'error'], 404);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $success['VehicleServices'] = array();
        $VehicleServices = VehicleService::select('id','title')->where([['clientid',auth()->user()->id]])->orWhereNull('clientid')->get();
        foreach ($VehicleServices as $key => $VehicleService) {
            $Service = Service::where([['vehicle_service_id',$VehicleService->id],['vehicleId',$id]])->latest()->first();
            if (!empty($Service)) {
                $VehicleService->last = date("d-m-Y", strtotime($Service->date));
                $VehicleService->next = date("d-m-Y", strtotime($Service->next_service_date));
                $VehicleService->last_km = $Service->service_km;
                $VehicleService->next_km = $Service->next_service_km;
            }else{
                $VehicleService->last = ' - ';
                $VehicleService->next = ' - ';
                $VehicleService->last_km = ' - ';
                $VehicleService->next_km = ' - ';
            }
            $success['VehicleServices'][] = $VehicleService;
        }
        return response()->json(['msg'=>'Service List','data' => $success], $this->successStatus);
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
