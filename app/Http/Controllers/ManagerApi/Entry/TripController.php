<?php

namespace App\Http\Controllers\ManagerApi\Entry;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Trip;
use App\Vehicle;
use App\TripTemp;
use DB;
use Validator;

class TripController extends Controller
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
        //
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
            'dateFrom'=>'required',
            'dateTo'=>'required',
            'startKm'=>'required',
            'endKm'=>'required',
            'staff1'=>'required',
        ]);
         if ($validator->fails()) {
            foreach ($validator->errors()->toArray() as $value) {
                return response()->json(['msg'=>$value[0]], 422);
            }
        }
        try {
            $TripTemp = $this->TripTemp;
            $TripTemp->vehicleId = request('vehicleId');
            $TripTemp->tripName = 'Trip';
            $TripTemp->dateFrom = request('dateFrom');
            $TripTemp->dateTo = request('dateTo');
            $TripTemp->startKm = request('startKm');
            $TripTemp->endKm = request('endKm');
            $TripTemp->totalKm = request('endKm')-request('startKm');
            $TripTemp->staff1 = request('staff1');
            $TripTemp->staff2 = request('staff2');
            $TripTemp->staff3 = request('staff3');
            $TripTemp->advance = request('advance');
            $TripTemp->entry = serialize(array());
            $TripTemp->diesel = serialize(array());
            $TripTemp->rto = serialize(array());
            $TripTemp->pc = serialize(array());
            $TripTemp->extraExpense = serialize(array());
            $TripTemp->tollgate = serialize(array());
            $TripTemp->driverAdvance = serialize(array());
            $TripTemp->clientid = auth()->user()->clientid;
            $TripTemp->managerid = auth()->user()->id;
            $TripTemp->save();
               return response()->json(['msg'=>'Trip Created Successfully'], $this->successStatus);
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
