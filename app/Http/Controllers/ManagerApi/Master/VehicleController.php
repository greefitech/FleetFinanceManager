<?php

namespace App\Http\Controllers\ManagerApi\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth; 
use Validator;
use App\ManagerLorry;
use App\Vehicle;

class VehicleController extends Controller
{
    private $successStatus = 200;
    private $errorStatus = 422;
    private $vehicleArray = array('id','ownerName','vehicleNumber','vehicleName','modelNumber','engine_number','chassis_number','manufacture_date','fuel_tank_capacity','vehicle_purchased_date','vehicleLastKm','VehicleProfit');

    public function __construct(){
        $this->ManagerLorry = new ManagerLorry;
        $this->Vehicle = new Vehicle;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ManagerAccessVehicle = ManagerLorry::where([['manager_login_id',auth()->user()->id]])->get()->pluck('vehicleId')->toArray();
        $Data['vehicles'] = Vehicle::select($this->vehicleArray)->whereIn('id',$ManagerAccessVehicle)->get();
        return response()->json(['status'=>'success','data' => $Data], $this->successStatus);
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
        //
    }
}
