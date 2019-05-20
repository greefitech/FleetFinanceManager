<?php

namespace App\Http\Controllers\API;

use App\Trip;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;

class TripController extends Controller
{
    public $successStatus = 200;


    /**
     * @SWG\Post(
     *     path="/api/trip/create",
     *     description="Create New Trip",
     *     tags={"Trip"},
     *     @swg\Parameter(
     *       in="header",
     *       name="Authorization",
     *       description="",
     *       required=true,
     *       type="string",
     *     ),
     *     @SWG\Parameter(
     *         name="vehicleId",
     *         in="query",
     *         type="string",
     *         description="Enter Vehicle Id",
     *         required=true,
     *     ),
     *     @SWG\Parameter(
     *         name="tripName",
     *         in="query",
     *         type="string",
     *         description="Enter Trip Name",
     *         required=true,
     *     ),
     *     @SWG\Parameter(
     *         name="dateFrom",
     *         in="query",
     *         type="string",
     *         description="Enter Date yyyy-mm-dd",
     *         required=true,
     *     ),
     *     @SWG\Parameter(
     *         name="dateTo",
     *         in="query",
     *         type="string",
     *         description="Enter Date to yyyy-mm-dd",
     *         required=false,
     *     ),
     *     @SWG\Parameter(
     *         name="startKm",
     *         in="query",
     *         type="number",
     *         description="Enter Start Km",
     *         required=true,
     *     ),
     *     @SWG\Parameter(
     *         name="endKm",
     *         in="query",
     *         type="number",
     *         description="Enter End Km",
     *         required=true,
     *     ),
     *     @SWG\Parameter(
     *         name="staff1",
     *         in="query",
     *         type="string",
     *         description="Enter Staff 1 ID",
     *         required=true,
     *     ),
     *     @SWG\Parameter(
     *         name="staff2",
     *         in="query",
     *         type="string",
     *         description="Enter Staff 2 ID",
     *         required=false,
     *     ),
     *     @SWG\Parameter(
     *         name="staff3",
     *         in="query",
     *         type="string",
     *         description="Enter Staff 3 ID",
     *         required=false,
     *     ),
     *     @SWG\Parameter(
     *         name="advance",
     *         in="query",
     *         type="number",
     *         description="Enter Advance Amount",
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


    public function CreateExpenseType(Request $request){
        $validator = Validator::make($request->all(), [
            'dateFrom'=>'required|date',
            'vehicleId'=>'required|exists:vehicles,id',
            'tripName'=>'required',
            'startKm'=>'required',
            'staff1'=>'required',
        ]);
        if ($validator->fails()) {
            $errData['msg'] = 'Please check the data';
            return response()->json($errData, 401);
        }
        try {
            $Trip = new Trip;
            $Trip->vehicleId = request('vehicleId');
            $Trip->tripName = request('tripName');
            $Trip->dateFrom = request('dateFrom');
            $Trip->dateTo = request('dateTo');
            $Trip->startKm = request('startKm');
            $Trip->endKm = request('endKm');
            $Trip->totalKm = request('endKm')-request('startKm');
            $Trip->driverPadi = request('driverPadi');
            $Trip->cleanerPadi = request('cleanerPadi');
            $Trip->staff1 = request('staff1');
            $Trip->staff2 = request('staff2');
            $Trip->staff3 = request('staff3');
            $Trip->advance = request('advance');
            $Trip->clientid = auth()->user()->id;
            $Trip->save();

            $vehicle = Vehicle::findorfail(request('vehicleId'));
            if($vehicle->vehicleLastKm < request('endKm')){
                $vehicle->vehicleLastKm = request('endKm');
                $vehicle->save();
            }
            $finalData['msg']='Trip Created Successfully';
            return response()->json(['status'=>'success','data' => $finalData], $this-> successStatus);
        } catch (\Illuminate\Database\QueryException $e) {
            $errormsg['msg'] = 'Error On Insert';
            return response()->json(['status'=>'error','data'=>$errormsg], 401);
        }
    }



    /**
     * @SWG\Get(
     *     path="/api/trips",
     *     description="Return all Trips",
     *     tags={"Trip"},
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


    public function GetTrips(){
        $finalData['Trip']=Trip::select('id','dateFrom','dateTo','vehicleId','tripName','startKm','endKm','totalKm','advance','staff1','staff2','staff3','status')->where('clientid',auth()->user()->id)->get();
        return response()->json(['status'=>'success','data' => $finalData], $this-> successStatus);
    }

    /**
     * @SWG\Get(
     *     path="/api/trip/{id}/edit",
     *     description="Return particular Trip",
     *     tags={"Trip"},
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


    public function EditTrip($id){
        try{
            $finalData['staff'] = Trip::select('id','dateFrom','dateTo','vehicleId','tripName','startKm','endKm','totalKm','advance','staff1','staff2','staff3','status')->findOrfail($id);
            return response()->json(['status'=>'success','data' => $finalData], $this-> successStatus);
        }catch (Exception $e){
            $errormsg['msg'] = 'Something Went Wrong';
            return response()->json(['status'=>'error','data'=>$errormsg], 401);
        }
    }


    /**
     * @SWG\Post(
     *     path="/api/trip/{id}/update",
     *     description="Update Trip",
     *     tags={"Trip"},
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
     *         name="vehicleId",
     *         in="query",
     *         type="string",
     *         description="Enter Vehicle Id",
     *         required=true,
     *     ),
     *     @SWG\Parameter(
     *         name="tripName",
     *         in="query",
     *         type="string",
     *         description="Enter Trip Name",
     *         required=true,
     *     ),
     *     @SWG\Parameter(
     *         name="dateFrom",
     *         in="query",
     *         type="string",
     *         description="Enter Date yyyy-mm-dd",
     *         required=true,
     *     ),
     *     @SWG\Parameter(
     *         name="dateTo",
     *         in="query",
     *         type="string",
     *         description="Enter Date to yyyy-mm-dd",
     *         required=false,
     *     ),
     *     @SWG\Parameter(
     *         name="startKm",
     *         in="query",
     *         type="number",
     *         description="Enter Start Km",
     *         required=true,
     *     ),
     *     @SWG\Parameter(
     *         name="endKm",
     *         in="query",
     *         type="number",
     *         description="Enter End Km",
     *         required=true,
     *     ),
     *     @SWG\Parameter(
     *         name="staff1",
     *         in="query",
     *         type="string",
     *         description="Enter Staff 1 ID",
     *         required=true,
     *     ),
     *     @SWG\Parameter(
     *         name="staff2",
     *         in="query",
     *         type="string",
     *         description="Enter Staff 2 ID",
     *         required=false,
     *     ),
     *     @SWG\Parameter(
     *         name="staff3",
     *         in="query",
     *         type="string",
     *         description="Enter Staff 3 ID",
     *         required=false,
     *     ),
     *     @SWG\Parameter(
     *         name="advance",
     *         in="query",
     *         type="number",
     *         description="Enter Advance Amount",
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


    public function UpdateTrip(Request $request,$id){
        $validator = Validator::make($request->all(), [
            'dateFrom'=>'required|date',
            'vehicleId'=>'required|exists:vehicles,id',
            'tripName'=>'required',
            'startKm'=>'required',
            'staff1'=>'required',
        ]);
        if ($validator->fails()) {
            $errData['msg'] = 'Please check the data';
            return response()->json($errData, 401);
        }
        try {
            $Trip = Trip::findorfail($id);
            $Trip->vehicleId = request('vehicleId');
            $Trip->tripName = request('tripName');
            $Trip->dateFrom = request('dateFrom');
            $Trip->dateTo = request('dateTo');
            $Trip->startKm = request('startKm');
            $Trip->endKm = request('endKm');
            $Trip->totalKm = request('endKm')-request('startKm');
            $Trip->driverPadi = request('driverPadi');
            $Trip->cleanerPadi = request('cleanerPadi');
            $Trip->staff1 = request('staff1');
            $Trip->staff2 = request('staff2');
            $Trip->staff3 = request('staff3');
            $Trip->advance = request('advance');
            $Trip->save();

            $finalData['msg']='Trip Updated Successfully';
            return response()->json(['status'=>'success','data' => $finalData], $this-> successStatus);
        } catch (\Illuminate\Database\QueryException $e) {
            $errormsg['msg'] = 'Error On Insert';
            return response()->json(['status'=>'error','data'=>$errormsg], 401);
        }
    }
}
