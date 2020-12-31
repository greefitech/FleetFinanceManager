<?php

namespace App\Http\Controllers\ManagerApi\Entry;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\TripTemp;
use DB;
use Validator;

class DriverAdvanceController extends Controller
{

    private $successStatus = 200;

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
            $driverAdvance = unserialize($TempTrip->driverAdvance);
            $TollFinalArray = array();
            if (!empty($driverAdvance)) {
                foreach ($driverAdvance['date'] as $key => $value) {
                    $TollArray=array(
                        'date'=>$driverAdvance['date'][$key],
                        'amount'=>$driverAdvance['amount'][$key],
                        'account_id'=>$driverAdvance['account_id'][$key]
                    );
                    $TollFinalArray[]=$TollArray;
                }
            }
             $success['toll'] = $TollFinalArray;

            return response()->json(['msg'=>'Toll List','data'=>$success], $this->successStatus);
        }catch (\Exception $e){
            return response()->json(['msg'=>'Something Went Wrong'],422);
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
        // return request()->all();
        $validator = Validator::make(request()->all(), [
            'trip_id'=>'required',
            'amount'=>'required',
            'account_id'=>'required',
            'date'=>'required',
        ]);
        if ($validator->fails()) {
            foreach ($validator->errors()->toArray() as $value) {
                return response()->json(['msg'=>$value[0]], 422);
            }
        }
        try {
            $TempTrip = $this->TripTemp::findorfail(request('trip_id'));
            $driverAdvance = unserialize($TempTrip->driverAdvance);
            $driverAdvance['date'][]=request('date');
            $driverAdvance['amount'][]=request('amount');
            $driverAdvance['account_id'][]=request('account_id');
            $TempTrip->driverAdvance = serialize($driverAdvance);
            $TempTrip->save();
            return response()->json(['msg'=>'Driver Advance Created Successfully'], $this->successStatus);
        }catch (\Exception $e){
            return response()->json(['msg'=>'Something Went Wrong'],422);
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
        $validator = Validator::make(request()->all(), [
            'trip_id'=>'required',
            'amount'=>'required',
            'account_id'=>'required',
            'date'=>'required',
        ]);
        if ($validator->fails()) {
            foreach ($validator->errors()->toArray() as $value) {
                return response()->json(['msg'=>$value[0]], 422);
            }
        }
        try {
            $TempTrip = $this->TripTemp::findorfail($id);
            $driverAdvance = unserialize($TempTrip->driverAdvance);
            array_splice($driverAdvance['date'],request('index'),1);
            array_splice($driverAdvance['amount'],request('index'),1);
            array_splice($driverAdvance['account_id'],request('index'),1);
            $driverAdvance['date'][]=request('date');
            $driverAdvance['amount'][]=request('amount');
            $driverAdvance['account_id'][]=request('account_id');
            $TempTrip->driverAdvance = serialize($driverAdvance);
            $TempTrip->save();
            return response()->json(['msg'=>'Driver Advance Updated Successfully'], $this->successStatus);
        }catch (\Exception $e){
            return response()->json(['msg'=>'Something Went Wrong'],422);
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
        try {
            $TempTrip = $this->TripTemp::findorfail($id);
            $driverAdvance = unserialize($TempTrip->driverAdvance);
            array_splice($driverAdvance['date'],request('index'),1);
            array_splice($driverAdvance['amount'],request('index'),1);
            array_splice($driverAdvance['account_id'],request('index'),1);
            $TempTrip->driverAdvance = serialize($driverAdvance);
            $TempTrip->save();
            return response()->json(['msg'=>'Driver Advance Removed Successfully'], $this->successStatus);
        }catch (\Exception $e){
            return response()->json(['msg'=>'Something Went Wrong'],422);
        }
    }
}
