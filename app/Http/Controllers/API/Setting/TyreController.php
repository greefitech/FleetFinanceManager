<?php

namespace App\Http\Controllers\API\Setting;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Vehicle;
use App\AssignTyre;
use App\Tyre;
use App\TyreLog;

class TyreController extends Controller
{

    public $successStatus = 200;

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
        $this->validate(request(),[
            'tyre_id'=>'required',
            'position'=>'required',
            'vehicleId'=>'required',
        ]);
        if(AssignTyre::where([['vehicleId',request('vehicleId')],['position',request('position')]])->first()){
            return response()->json(['msg'=>'Vehicle Tyre Is Already Assigned on Position '.ucfirst(request('position'))], $this->successStatus);
        }
        try {
            $AssignTyre = new AssignTyre;
            $AssignTyre->tyre_id = request('tyre_id');
            $AssignTyre->position = request('position');
            $AssignTyre->vehicleId = request('vehicleId');
            $AssignTyre->clientid=auth()->user()->id;
            $AssignTyre->save();
            Tyre::findorfail(request('tyre_id'))->update(['vehicleId'=>request('vehicleId')]);
            TyreLog::create([
                'transaction'=>'Inserted',
                'vehicleId'=>$id,
                'tyre_id'=>request('tyre_id'),
                'position'=>request('position'),
                'km'=>request('km'),
                'current_depth'=>request('current_depth'),
                'note'=>request('note'),
                'staffId'=>request('staffId'),
                'clientid'=>auth()->user()->id,
            ]);
           return response()->json(['msg'=>'Tyre Position Created Successfully'], $this->successStatus);
        }catch (Exception $e){
             return response()->json(['msg'=>'error'], 404);
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
        try {
            $success['tyrePosition'] = AssignTyre::where([['vehicleId',$id]])->get()->pluck('position');
            return response()->json(['msg'=>'Tyre Position List','data' => $success], $this->successStatus);
        }catch (Exception $e){
            return response()->json(['msg'=>'error'], 404);
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
