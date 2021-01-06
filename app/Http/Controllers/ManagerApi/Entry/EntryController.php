<?php

namespace App\Http\Controllers\ManagerApi\Entry;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\TripTemp;
use DB;
use Validator;

class EntryController extends Controller {

    private $successStatus = 200,$errorStatus = 200;

    public function __construct(){
        $this->TripTemp = new TripTemp;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        try {
            $TempTrip = $this->TripTemp::findorfail(request('trip_id'));
            $entry = unserialize($TempTrip->entry);
            $FinalArray = array();
            if (!empty($entry)) {
                foreach ($entry['dateFrom'] as $key => $value) {
                    $NewArray=array(
                        'dateFrom'=>$entry['dateFrom'][$key],
                        'customerId'=>$entry['customerId'][$key],
                        'locationFrom'=>$entry['locationFrom'][$key],
                        'locationTo'=>$entry['locationTo'][$key],
                        'loadType'=>$entry['loadType'][$key],
                        'ton'=>$entry['ton'][$key],
                        'account_id'=>$entry['account_id'][$key],
                        'billAmount'=>$entry['billAmount'][$key],
                        'advance'=>$entry['advance'][$key],
                        'comission'=>$entry['comission'][$key],
                        'commission_status'=>$entry['commission_status'][$key],
                        'driverPadi'=>$entry['driverPadi'][$key],
                        'cleanerPadi'=>$entry['cleanerPadi'][$key],
                        'driverPadiAmount'=>$entry['driverPadiAmount'][$key],
                        'cleanerPadiAmount'=>$entry['cleanerPadiAmount'][$key],
                        'loadingMamool'=>$entry['loadingMamool'][$key],
                        'loading_mamool_status'=>$entry['loading_mamool_status'][$key],
                        'unLoadingMamool'=>$entry['unLoadingMamool'][$key],
                        'unloading_mamool_status'=>$entry['unloading_mamool_status'][$key],
                    );
                    $FinalArray[]=$NewArray;
                }
            }
            $success['entries'] = $FinalArray;
            return response()->json(['msg'=>'Toll List','data'=>$success], $this->successStatus);
        }catch (\Exception $e){
            return response()->json(['msg'=>'Something Went Wrong'],$this->errorStatus);
        }
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
    public function store(Request $request){
        $validator = Validator::make(request()->all(), [
            'trip_id'=>'required',
            'dateFrom'=>'required',
            'customerId'=>'required',
            'account_id'=>'required',
            'billAmount'=>'required',
            'advance'=>'required',
        ]);
        if ($validator->fails()) {
            foreach ($validator->errors()->toArray() as $value) {
                return response()->json(['msg'=>$value[0]], 422);
            }
        }
        try {
            $TempTrip = $this->TripTemp::findorfail(request('trip_id'));
            $entry = unserialize($TempTrip->entry);
            $entry['dateFrom'][]=request('dateFrom');
            $entry['customerId'][]=request('customerId');
            $entry['locationFrom'][]=request('locationFrom');
            $entry['locationTo'][]=request('locationTo');
            $entry['loadType'][]=request('loadType');
            $entry['ton'][]=request('ton');
            $entry['account_id'][]=request('account_id');
            $entry['billAmount'][]=request('billAmount');
            $entry['advance'][]=request('advance');
            $entry['comission'][]=request('comission');
            $entry['commission_status'][]=request('commission_status');
            $entry['driverPadi'][]=request('driverPadi');
            $entry['cleanerPadi'][]=request('cleanerPadi');
             $entry['driverPadiAmount'][] = !empty(request('driverPadi'))?round((request('billAmount') * request('driverPadi')) / 100):request('driverPadiAmount');
             $entry['cleanerPadiAmount'][] = !empty(request('cleanerPadi'))?round((request('billAmount') * request('cleanerPadi')) / 100):request('cleanerPadiAmount');
            $entry['loadingMamool'][]=request('loadingMamool');
            $entry['loading_mamool_status'][]=request('loading_mamool_status');
            $entry['unLoadingMamool'][]=request('unLoadingMamool');
            $entry['unloading_mamool_status'][]=request('unloading_mamool_status');

            $TempTrip->entry = serialize($entry);
            $TempTrip->save();
            return response()->json(['msg'=>'Entry Created Successfully'], $this->successStatus);
        }catch (\Exception $e){
            return response()->json(['msg'=>'Something Went Wrong'],$this->errorStatus);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id){
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id){
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id){
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id){
        //
    }
}
