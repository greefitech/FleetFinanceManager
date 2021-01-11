<?php

namespace App\Http\Controllers\ManagerApi\Entry;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\TripTemp;
use DB;
use Validator;

class PCController extends Controller
{

    private $successStatus = 200,$errorStatus = 200;

    public function __construct(){
        $this->TripTemp = new TripTemp;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $TempTrip = $this->TripTemp::findorfail(request('trip_id'));
            $pc = unserialize($TempTrip->pc);
            $FinalArray = array();
            if (!empty($pc)) {
                foreach ($pc['location'] as $key => $value) {
                    $NewArray=array(
                        'location'=>$pc['location'][$key],
                        'amount'=>$pc['amount'][$key],
                    );
                    $FinalArray[]=$NewArray;
                }
            }
            $success['pc'] = $FinalArray;
            return response()->json(['msg'=>'RTO List','data'=>$success], $this->successStatus);
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
    public function store(Request $request)
    {
         $validator = Validator::make(request()->all(), [
           'trip_id'=>'required',
            'pc'=>'required',
        ]);
        if ($validator->fails()) {
            foreach ($validator->errors()->toArray() as $value) {
                return response()->json(['msg'=>$value[0]], $this->errorStatus);
            }
        }
        try {
            $TempTrip = $this->TripTemp::findorfail(request('trip_id'));
            $pc = unserialize($TempTrip->pc);
            if (!empty(json_decode(request('pc'),true))) {
                foreach ( json_decode(request('pc'),true) as $key => $value) {
                    if(!empty($value['amount'])){
                        $pc['location'][] = $value['location'];
                        $pc['amount'][] = $value['amount'];
                    }
                }
            }
            $TempTrip->pc = serialize($pc);
            $TempTrip->save();
            return response()->json(['msg'=>'PC Created Successfully'], $this->successStatus);
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
            $TempTrip = $this->TripTemp::findorfail($id);
            $pc = unserialize($TempTrip->pc);
            array_splice($pc['location'],request('index'),1);
            array_splice($pc['amount'],request('index'),1);
            $TempTrip->pc = serialize($pc);
            $TempTrip->save();
            return response()->json(['msg'=>'PC Removed Successfully'], $this->successStatus);
        }catch (\Exception $e){
            return response()->json(['msg'=>'Something Went Wrong'],422);
        }
    }
}
