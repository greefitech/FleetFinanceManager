<?php

namespace App\Http\Controllers\API;

use App\Entry;
use App\Trip;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EntryController extends Controller
{

    public $successStatus = 200;

    /**
     * @SWG\Post(
     *     path="/api/entry/create",
     *     description="Create New Entry",
     *     tags={"Entry"},
     *     @swg\Parameter(
     *       in="header",
     *       name="Authorization",
     *       description="",
     *       required=true,
     *       type="string",
     *     ),
     *     @SWG\Parameter(
     *         name="tripId",
     *         in="query",
     *         type="string",
     *         description="Enter Trip",
     *         required=true,
     *     ),
     *     @SWG\Parameter(
     *         name="dateFrom",
     *         in="query",
     *         type="string",
     *         description="Enter Date From",
     *         required=true,
     *     ),
     *     @SWG\Parameter(
     *         name="vehicleId",
     *         in="query",
     *         type="string",
     *         description="Enter Vehicle Id",
     *         required=true,
     *     ),
     *     @SWG\Parameter(
     *         name="customerId",
     *         in="query",
     *         type="string",
     *         description="Enter Customer Id",
     *         required=true,
     *     ),
     *     @SWG\Parameter(
     *         name="locationFrom",
     *         in="query",
     *         type="string",
     *         description="Enter location From",
     *         required=true,
     *     ),
     *     @SWG\Parameter(
     *         name="locationTo",
     *         in="query",
     *         type="string",
     *         description="Enter location To",
     *         required=false,
     *     ),
     *     @SWG\Parameter(
     *         name="loadType",
     *         in="query",
     *         type="string",
     *         description="Enter load Type",
     *         required=true,
     *     ),
     *     @SWG\Parameter(
     *         name="ton",
     *         in="query",
     *         type="string",
     *         description="Enter ton",
     *         required=false,
     *     ),
     *     @SWG\Parameter(
     *         name="account_id",
     *         in="query",
     *         type="string",
     *         description="Enter Account Id",
     *         required=true,
     *     ),
     *     @SWG\Parameter(
     *         name="billAmount",
     *         in="query",
     *         type="string",
     *         description="Enter Bill Amount",
     *         required=true,
     *     ),
     *     @SWG\Parameter(
     *         name="advance",
     *         in="query",
     *         type="string",
     *         description="Enter Advance",
     *         required=false,
     *     ),
     *     @SWG\Parameter(
     *         name="driverPadi",
     *         in="query",
     *         type="string",
     *         description="Enter Driver Padi",
     *         required=true,
     *     ),
     *     @SWG\Parameter(
     *         name="cleanerPadi",
     *         in="query",
     *         type="string",
     *         description="Enter Cleaner Padi",
     *         required=true,
     *     ),
     *     @SWG\Parameter(
     *         name="comission",
     *         in="query",
     *         type="string",
     *         description="Enter comission",
     *         required=false,
     *     ),
     *     @SWG\Parameter(
     *         name="loadingMamool",
     *         in="query",
     *         type="string",
     *         description="Enter loading Mamool",
     *         required=false,
     *     ),
     *     @SWG\Parameter(
     *         name="unLoadingMamool",
     *         in="query",
     *         type="string",
     *         description="Enter unLoadingMamool",
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


    public function CreateEntry(){
        $this->validate(request(),[
            'dateFrom'=>'required|date',
            'vehicleId'=>'required|exists:vehicles,id',
            'customerId'=>'required|exists:customers,id',
            'locationFrom'=>'required',
            'locationTo'=>'required',
            'loadType'=>'required',
            'tripId'=>'required|exists:trips,id',
            'billAmount'=>'required',
        ]);

        $Trip= Trip::findOrfail(request('tripId'));
        if($Trip->vehicleId != request('vehicleId')){
            $errData['msg'] = 'Vehicle Trip and Vehicle Not Matched !!';
            return response()->json($errData, 401);
        }
        try {
            $entry = new Entry;
            $entry->dateFrom=request()->dateFrom;
            $entry->vehicleId=request()->vehicleId;
            $entry->customerId=request()->customerId;
            $entry->startKm=request()->startKm;
            $entry->endKm=request()->endKm;
            $entry->total=request()->total;
            $entry->locationFrom=request()->locationFrom;
            $entry->locationTo=request()->locationTo;
            $entry->loadType=request()->loadType;
            $entry->ton=request()->ton;
            $entry->billAmount=request()->billAmount;
            $entry->advance=request()->advance;
            $entry->driverPadi=request()->driverPadi;
            $entry->cleanerPadi=request()->cleanerPadi;
            $entry->driverPadiAmount=round((request()->billAmount * request()->driverPadi) / 100);
            $entry->cleanerPadiAmount=round((request()->billAmount * request()->cleanerPadi) / 100);
            $entry->comission=request('comission');
            $entry->loadingMamool=request()->loadingMamool;
            $entry->unLoadingMamool=request()->unLoadingMamool;
            $balance =request()->billAmount - request()->advance;
            $entry->balance=$balance;
            $entry->account_id=request()->account_id;
            $entry->tripId=request('tripId');
            $entry->clientid = auth()->user()->id;
            $entry->save();
            $finalData['msg']='Entry Created Successfully';
            return response()->json(['status'=>'success','data' => $finalData], $this-> successStatus);
        }catch (Exception $e){
            $errormsg['msg'] = 'Error On Insert';
            return response()->json(['status'=>'error','data'=>$errormsg], 401);
        }
    }
}
