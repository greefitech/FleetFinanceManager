<?php

namespace App\Http\Controllers\API\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Vehicle;
use App\Client;
use App\VehicleType;
use Illuminate\Support\Facades\Auth;
use Validator;

class VehicleController extends Controller
{
     public $successStatus = 200;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $success['Vehicles']=Vehicle::with('GetVehicleType')->where('clientid',auth()->user()->id)->get();
        return response()->json(['msg'=>'Vehicle List','data' => $success], $this->successStatus);
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
        $validator = Validator::make($request->all(), [
            'ownerName'=>'required',
            'vehicleNumber'=>'required',
            'vehicleName'=>'required',
            'vehicleLastKm'=>'required',
            'vehicleType'=>'required|exists:vehicle_types,id',
        ]);
        if ($validator->fails()) {
            foreach ($validator->errors()->toArray() as $value) {
               $errData[]=$value[0];
            }
            return response()->json(['msg'=>'Please check the data','error'=>$errData], 401);
        }
        // CHECK VEHICLE CREDIT LIMIT
        $Client=Client::findOrfail(auth()->user()->id);
        $vehicle = Vehicle::where([['clientid',auth()->user()->id]])->count();
        if($Client->vehicleCredit!=''&& $Client->vehicleCredit<=$vehicle){
            return response()->json(['msg'=>'Contact Admin To Add Vehicle!'],401);
        }
        try {
            Vehicle::create([
                'ownerName' => request('ownerName'),
                'vehicleNumber' => strtoupper(request('vehicleNumber')),
                'vehicleName' => request('vehicleName'),
                'vehicleType' => request('vehicleType'),
                'vehicleLastKm' => request('vehicleLastKm'),
                'modelNumber' => request('modelNumber'),
                'clientid' => auth()->user()->id,
            ]);
            return response()->json(['msg'=>'Vehicle Created Successfully'], $this-> successStatus);
        }catch (Exception $e){
            return response()->json(['msg'=>'Error On Insert'],401);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id){
        try{
            $success['VehicleType']=VehicleType::select('id','vehicleType')->get();
            $success['vehicle'] = Vehicle::with('GetVehicleType')->findOrfail($id);
           return response()->json(['msg'=>'Vehicle Show','data' =>$success], $this-> successStatus);
        }catch (Exception $e){
            return response()->json(['msg'=>'Something Went Wrong'],401);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try{
            $success['VehicleType']=VehicleType::select('id','vehicleType')->get();
            $success['vehicle'] = Vehicle::with('GetVehicleType')->findOrfail($id);
           return response()->json(['msg'=>'Vehicle Edit','data' =>$success], $this-> successStatus);
        }catch (Exception $e){
            return response()->json(['msg'=>'Something Went Wrong'],401);
        }
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
        $validator = Validator::make($request->all(), [
            'ownerName'=>'required',
            'vehicleNumber'=>'required',
            'vehicleName'=>'required',
            'vehicleLastKm'=>'required',
            'vehicleType'=>'required|exists:vehicle_types,id',
        ]);
        if ($validator->fails()) {
            foreach ($validator->errors()->toArray() as $value) {
               $errData[]=$value[0];
            }
            return response()->json(['msg'=>'Please check the data','error'=>$errData], 401);
        }

        try{
            $vehicle = Vehicle::findOrfail($id);
            $vehicle->ownerName = request('ownerName');
            $vehicle->vehicleNumber = strtoupper(request('vehicleNumber'));
            $vehicle->vehicleName = request('vehicleName');
            $vehicle->vehicleType = request('vehicleType');
            $vehicle->modelNumber = request('modelNumber');
            $vehicle->save();
            return response()->json(['msg'=>'Vehicle Updated Successfully!'],  $this->successStatus);
         }catch (Exception $e){
            return response()->json(['msg'=>'Something Went Wrong'], 401);
        }
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
