<?php

namespace App\Http\Controllers\ManagerApi\Entry;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\TripTemp;
use DB;
use Validator;

class TollController extends Controller
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
    public function index()
    {
        try {
            $TempTrip = $this->TripTemp::findorfail(request('trip_id'));
            $tollgate = unserialize($TempTrip->tollgate);
            $TollFinalArray = array();
            if (!empty($tollgate)) {
                foreach ($tollgate['location'] as $key => $value) {
                    $TollArray=array(
                        'location'=>$tollgate['location'][$key],
                        'amount'=>$tollgate['amount'][$key],
                        'account_id'=>$tollgate['account_id'][$key]
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
        $validator = Validator::make(request()->all(), [
            'trip_id'=>'required',
            'amount'=>'required',
            'account_id'=>'required',
        ]);
        if ($validator->fails()) {
            foreach ($validator->errors()->toArray() as $value) {
                return response()->json(['msg'=>$value[0]], 422);
            }
        }
        try {
            $TempTrip = $this->TripTemp::findorfail(request('trip_id'));
            $tollgate = unserialize($TempTrip->tollgate);
            $tollgate['location'][]=request('location');
            $tollgate['amount'][]=request('amount');
            $tollgate['account_id'][]=request('account_id');
            $TempTrip->tollgate = serialize($tollgate);
            $TempTrip->save();
            return response()->json(['msg'=>'Toll Created Successfully'], $this->successStatus);
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
    public function update(Request $request, $id){
         try {
            $TempTrip = $this->TripTemp::findorfail($id);
            $tollgate = unserialize($TempTrip->tollgate);
            array_splice($tollgate['location'],request('index'),1);
            array_splice($tollgate['amount'],request('index'),1);
            array_splice($tollgate['account_id'],request('index'),1);
            $tollgate['location'][]=request('location');
            $tollgate['amount'][]=request('amount');
            $tollgate['account_id'][]=request('account_id');
            $TempTrip->tollgate = serialize($tollgate);
            $TempTrip->save();
            return response()->json(['msg'=>'Toll Updated Successfully'], $this->successStatus);
        }catch (Exception $e){
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
            $tollgate = unserialize($TempTrip->tollgate);
            array_splice($tollgate['location'],request('index'),1);
            array_splice($tollgate['amount'],request('index'),1);
            array_splice($tollgate['account_id'],request('index'),1);
            $TempTrip->tollgate = serialize($tollgate);
            $TempTrip->save();
            return response()->json(['msg'=>'Toll Removed Successfully'], $this->successStatus);
        }catch (Exception $e){
            return response()->json(['msg'=>'Something Went Wrong'],422);
        }
    }
}
