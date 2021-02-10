<?php

namespace App\Http\Controllers\ManagerApi\Entry;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\TripTemp;
use DB;
use Validator;

class DieselController extends Controller{
    
    private $successStatus = 200,$errorStatus = 422;

    public function __construct(){
        $this->TripTemp = new TripTemp;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        try {
            $TempTrip = $this->TripTemp::findorfail(request('trip_id'));
            $diesel = unserialize($TempTrip->diesel);
            $FinalArray = array();
            if (!empty($diesel)) {
                foreach ($diesel['date'] as $key => $value) {
                    $NewArray=array(
                        'date'=>$diesel['date'][$key],
                        'vendor_id'=>$diesel['vendor_id'][$key],
                        'location'=>$diesel['location'][$key],
                        'discription'=>$diesel['discription'][$key],
                        'quantity'=>$diesel['quantity'][$key],
                        'amount'=>$diesel['amount'][$key],
                        'account_id'=>$diesel['account_id'][$key],
                        'status'=>$diesel['status'][$key],
                    );
                    $FinalArray[]=$NewArray;
                }
            }
             $success['diesel'] = $FinalArray;
            return response()->json(['msg'=>'Diesel List','data'=>$success], $this->successStatus);
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
    public function store(Request $request){
        $validator = Validator::make(request()->all(), [
            'date'=>'required',
            'trip_id'=>'required',
            'amount'=>'required',
            'account_id'=>'required',
            'vendor_id'=>'required',
            'quantity'=>'required',
        ]);
        if ($validator->fails()) {
            foreach ($validator->errors()->toArray() as $value) {
                return response()->json(['msg'=>$value[0]], 422);
            }
        }
        try {
            $TempTrip = $this->TripTemp::findorfail(request('trip_id'));
            $diesel = unserialize($TempTrip->diesel);
            $diesel['date'][]=request('date');
            $diesel['vendor_id'][]=request('vendor_id');
            $diesel['location'][]=request('location');
            $diesel['discription'][]=request('discription');
            $diesel['quantity'][]=request('quantity');
            $diesel['amount'][]=request('amount');
            $diesel['account_id'][]=request('account_id');
            $diesel['status'][]=request('status');

            $TempTrip->diesel = serialize($diesel);
            $TempTrip->save();
            return response()->json(['msg'=>'Diesel Created Successfully'], $this->successStatus);
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
        $validator = Validator::make(request()->all(), [
            'date'=>'required',
            'trip_id'=>'required',
            'amount'=>'required',
            'account_id'=>'required',
            'vendor_id'=>'required',
            'quantity'=>'required',        ]);
        if ($validator->fails()) {
            foreach ($validator->errors()->toArray() as $value) {
                return response()->json(['msg'=>$value[0]], 422);
            }
        }
         try {
            $TempTrip = $this->TripTemp::findorfail($id);
            $diesel = unserialize($TempTrip->diesel);
            array_splice($diesel['date'],request('index'),1);
            array_splice($diesel['vendor_id'],request('index'),1);
            array_splice($diesel['location'],request('index'),1);
            array_splice($diesel['discription'],request('index'),1);
            array_splice($diesel['quantity'],request('index'),1);
            array_splice($diesel['amount'],request('index'),1);
            array_splice($diesel['account_id'],request('index'),1);
            array_splice($diesel['status'],request('index'),1);

            $diesel['date'][]=request('date');
            $diesel['vendor_id'][]=request('vendor_id');
            $diesel['location'][]=request('location');
            $diesel['discription'][]=request('discription');
            $diesel['quantity'][]=request('quantity');
            $diesel['amount'][]=request('amount');
            $diesel['account_id'][]=request('account_id');
            $diesel['status'][]=request('status');
            $TempTrip->diesel = serialize($diesel);
            $TempTrip->save();
            return response()->json(['msg'=>'Diesel Updated Successfully'], $this->successStatus);
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
    public function destroy($id){
        try {
            $TempTrip = $this->TripTemp::findorfail($id);
            $diesel = unserialize($TempTrip->diesel);
            array_splice($diesel['date'],request('index'),1);
            array_splice($diesel['vendor_id'],request('index'),1);
            array_splice($diesel['location'],request('index'),1);
            array_splice($diesel['discription'],request('index'),1);
            array_splice($diesel['quantity'],request('index'),1);
            array_splice($diesel['amount'],request('index'),1);
            array_splice($diesel['account_id'],request('index'),1);
            array_splice($diesel['status'],request('index'),1);
            $TempTrip->diesel = serialize($diesel);
            $TempTrip->save();
            return response()->json(['msg'=>'Diesel Removed Successfully'], $this->successStatus);
        }catch (\Exception $e){
            return response()->json(['msg'=>'Something Went Wrong'],422);
        }
    }
}
