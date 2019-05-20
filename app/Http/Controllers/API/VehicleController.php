<?php

namespace App\Http\Controllers\API;

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
     * @SWG\Post(
     *     path="/api/vehicle/create",
     *     description="Create New Vehicle",
     *     tags={"Vehicle"},
     *     @swg\Parameter(
     *       in="header",
     *       name="Authorization",
     *       description="",
     *       required=true,
     *       type="string",
     *     ),
     *     @SWG\Parameter(
     *         name="ownerName",
     *         in="query",
     *         type="string",
     *         description="Enter Owner Name",
     *         required=true,
     *     ),
     *     @SWG\Parameter(
     *         name="vehicleNumber",
     *         in="query",
     *         type="string",
     *         description="Enter Vehicle Number",
     *         required=true,
     *     ),
     *     @SWG\Parameter(
     *         name="vehicleName",
     *         in="query",
     *         type="string",
     *         description="Enter Vehicle Name",
     *         required=true,
     *     ),
     *     @SWG\Parameter(
     *         name="vehicleType",
     *         in="query",
     *         type="string",
     *         description="Enter Vehicle Type Id",
     *         required=true,
     *     ),
     *     @SWG\Parameter(
     *         name="vehicleLastKm",
     *         in="query",
     *         type="string",
     *         description="Enter Vehicle Last Km",
     *         required=true,
     *     ),
     *     @SWG\Parameter(
     *         name="modelNumber",
     *         in="query",
     *         type="string",
     *         description="Enter Model Number",
     *         required=false,
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="OK",
     *     ),
     *     @SWG\Response(
     *         response=401,
     *         description="Invalid Data"
     *     ),
     *     security={ {"bearer": {}} },
     * )
     */




    public function CreateVehicle(Request $request){
    	$validator = Validator::make($request->all(), [
            'ownerName'=>'required',
            'vehicleNumber'=>'required',
            'vehicleName'=>'required',
            'vehicleLastKm'=>'required',
            'vehicleType'=>'required|exists:vehicle_types,id',
        ]);
        if ($validator->fails()) {
            $errormsg['msg'] = 'Please check the data';
            return response()->json(['status'=>'error','data'=>$errormsg], 401);
        }
        // CHECK VEHICLE CREDIT LIMIT
        $Client=Client::findOrfail(auth()->user()->id);
        $vehicle = Vehicle::where([['clientid',auth()->user()->id]])->count();
        if($Client->vehicleCredit!=''&& $Client->vehicleCredit<=$vehicle){
            $errDatas['status']='Contact Admin To Add Vehicle!';
            return response()->json(['status'=>'success','data' => $errDatas], $this-> successStatus);
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
             $finalData['status']='Vehicle Created Successfully';
        	return response()->json(['status'=>'success','data' => $finalData], $this-> successStatus);
        }catch (Exception $e){
            $errormsg['msg']='Error On Insert';
            return response()->json(['status'=>'error','data'=>$errormsg]);
        }
    }

    /**
     * @SWG\Get(
     *     path="/api/vehicles",
     *     description="Return all Vehicles",
     *     tags={"Vehicle"},
     *     @swg\Parameter(
     *       in="header",
     *       name="Authorization",
     *       description="",
     *       required=true,
     *       type="string",
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="OK",
     *     ),
     *     @SWG\Response(
     *         response=401,
     *         description="Invalid Data"
     *     ),
     *     security={ {"bearer": {}} },
     * )
     */


    public function GetVehicles(){
        $finalData['VehicleType']=VehicleType::select('id','vehicleType')->get();
    	$finalData['Vehicles']=Vehicle::where('clientid',auth()->user()->id)->get()->all();
    	if (!empty($finalData['Vehicles'])) {
    		return response()->json(['status'=>'success','data' =>$finalData], $this-> successStatus);
    	}else{
            $errormsg['msg']='No Vehicle Till Now Added';
            return response()->json(['status'=>'error','data'=>$errormsg]);
    	}
    }



    /**
     * @SWG\Get(
     *     path="/api/vehicle/{id}/edit",
     *     description="Return particular Vehicle",
     *     tags={"Vehicle"},
     *     @swg\Parameter(
     *       in="header",
     *       name="Authorization",
     *       description="",
     *       required=true,
     *       type="string",
     *     ),
     *      @SWG\Parameter(
     *          name="id",
     *          in="path",
     *          required=true,
     *          type="string"
     *      ),
     *     @SWG\Response(
     *         response=200,
     *         description="OK",
     *     ),
     *     @SWG\Response(
     *         response=401,
     *         description="Invalid Data"
     *     ),
     *     security={ {"bearer": {}} },
     * )
     */

    public function EditVehicle($id){
        try{
            $finalData['VehicleType']=VehicleType::select('id','vehicleType')->get();
            $finalData['vehicle'] = Vehicle::findOrfail($id);
           return response()->json(['status'=>'success','data' =>$finalData], $this-> successStatus);
        }catch (Exception $e){
            $errormsg['msg']='Something Went Wrong';
            return response()->json(['status'=>'error','data'=>$errormsg]);
        }
    }


    /**
     * @SWG\Post(
     *     path="/api/vehicle/{id}/update",
     *     description="Update Vehicle",
     *     tags={"Vehicle"},
     *     @swg\Parameter(
     *       in="header",
     *       name="Authorization",
     *       description="",
     *       required=true,
     *       type="string",
     *     ),
     *     @SWG\Parameter(
     *          name="id",
     *          in="path",
     *          required=true,
     *          type="string"
     *      ),
     *     @SWG\Parameter(
     *         name="ownerName",
     *         in="query",
     *         type="string",
     *         description="Enter Owner Name",
     *         required=true,
     *     ),
     *     @SWG\Parameter(
     *         name="vehicleNumber",
     *         in="query",
     *         type="string",
     *         description="Enter Vehicle Number",
     *         required=true,
     *     ),
     *     @SWG\Parameter(
     *         name="vehicleName",
     *         in="query",
     *         type="string",
     *         description="Enter Vehicle Name",
     *         required=true,
     *     ),
     *     @SWG\Parameter(
     *         name="vehicleType",
     *         in="query",
     *         type="string",
     *         description="Enter Vehicle Type Id",
     *         required=true,
     *     ),
     *     @SWG\Parameter(
     *         name="vehicleLastKm",
     *         in="query",
     *         type="string",
     *         description="Enter Vehicle Last Km",
     *         required=true,
     *     ),
     *     @SWG\Parameter(
     *         name="modelNumber",
     *         in="query",
     *         type="string",
     *         description="Enter Model Number",
     *         required=false,
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="OK",
     *     ),
     *     @SWG\Response(
     *         response=401,
     *         description="Invalid Data"
     *     ),
     *     security={ {"bearer": {}} },
     * )
     */


    public function UpdateVehicle($id,Request $request){
    	$validator = Validator::make($request->all(), [
            'ownerName'=>'required',
            'vehicleNumber'=>'required',
            'vehicleName'=>'required',
            'vehicleLastKm'=>'required',
            'vehicleType'=>'required|exists:vehicle_types,id',
        ]);
        if ($validator->fails()) {
//            foreach ($validator->errors()->toArray() as $value) {
//                $errData['error'][]=$value[0];
//            }
            $errormsg['msg'] = 'Please check the data';
            return response()->json(['status'=>'error','data'=>$errormsg], 401);
        }

        try{
	        $vehicle = Vehicle::findOrfail($id);
            $vehicle->ownerName = request('ownerName');
            $vehicle->vehicleNumber = strtoupper(request('vehicleNumber'));
            $vehicle->vehicleName = request('vehicleName');
            $vehicle->vehicleType = request('vehicleType');
            $vehicle->modelNumber = request('modelNumber');
	        $vehicle->save();
	        $FinalData['status']='Vehicle Updated Created';
            return response()->json($FinalData);
         }catch (Exception $e){
            $errorData['status']='Something Went Wrong';
            return response()->json($errorData);
        }
    }


    /**
     * @SWG\Get(
     *     path="/api/vehicle/types",
     *     description="Return Vehicle Types",
     *     tags={"Vehicle"},
     *     @swg\Parameter(
     *       in="header",
     *       name="Authorization",
     *       description="",
     *       required=true,
     *       type="string",
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="OK",
     *     ),
     *     @SWG\Response(
     *         response=401,
     *         description="Invalid Data"
     *     ),
     *     security={ {"bearer": {}} },
     * )
     */

    public function VehicleType(){
        $finalData['VehicleType']=VehicleType::select('id','vehicleType')->get();
        return response()->json(['status'=>'success','data'=>$finalData ], $this-> successStatus);
    }

}
