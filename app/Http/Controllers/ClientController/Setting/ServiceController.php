<?php

namespace App\Http\Controllers\ClientController\Setting;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Vehicle;
use App\VehicleService;
use App\Service;
use Yajra\DataTables\Facades\DataTables;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('client.setting.service.vehiclewise');
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
            return redirect(action('ClientController\Setting\ServiceController@VehicleWiseService',request('vehicleId')))->with('success',['Service','Added Successfully']);
        }catch (Exception $e){
            return back()->with('sorry','Sorry,Something went wrong!');
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
        //
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
        try {
            $Service = Service::findorfail($id)->delete();
            return $output = ['status' => 'success','msg' => 'Services Deleted Successfully'];
        }catch (\Exception $e){
            return back()->with('sorry','Sorry,Something went wrong!');
        }
    }


    public function VehicleWiseService($VehicleId){
        $Data['Vehicle'] = Vehicle::findorfail($VehicleId);
        $Data['VehicleServices'] = VehicleService::where([['clientid',auth()->user()->id]])->orWhereNull('clientid')->get();
        return view('client.setting.service.index',$Data);
    }

    public function editService($VehicleServiceId,$VehicleId){
        try {
            if (request()->ajax()) {
                $Services = Service::where([['vehicle_service_id',$VehicleServiceId],['vehicleId',$VehicleId]]);
                return DataTables::of($Services)
                    ->addColumn('action',
                        '<a href="{{ action(\'ClientController\Setting\ServiceController@destroy\',[$id]) }}" class="btn btn-md DeleteData" style="color:red"DeleteMessage="You will not be able to recover this Data!"><i class="fa fa-trash"></i></a>'
                    )  
                    ->editColumn('vehicle_service_id',function($Service){

                        return $Service->VehicleService->title;
                    }
                    )
                     ->rawColumns(['action'])->make(true);
            }
            $Data['VehicleService'] = VehicleService::findorfail($VehicleServiceId);
            $Data['Vehicle'] = Vehicle::findorfail($VehicleId);
            return view('client.setting.service.create',$Data);
        }catch (\Exception $e){
            return back()->with('sorry','Sorry,Something went wrong!');
        }
    }
}
