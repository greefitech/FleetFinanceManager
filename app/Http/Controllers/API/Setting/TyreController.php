<?php

namespace App\Http\Controllers\API\Setting;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Vehicle;
use App\AssignTyre;
use App\Tyre;
use App\TyreLog;
use App\Staff;

class TyreController extends Controller
{

    public $successStatus = 200;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        $success['tyreList'] = GetNonUsedTyreList(auth()->user()->id);
        $success['staff'] =Staff::where('clientid',auth()->user()->id)->get();
        return response()->json(['msg'=>'Tyre List Data','data' => $success], $this->successStatus);
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
                'vehicleId'=>request('vehicleId'),
                'tyre_id'=>request('tyre_id'),
                'position'=>request('position'),
                'km'=>request('km'),
                'current_depth'=>request('current_depth'),
                'note'=>request('note'),
                'staffId'=>request('staffId'),
                'clientid'=>auth()->user()->id,
            ]);
           return response()->json(['msg'=>'Tyre Position Created Successfully'], $this->successStatus);
        }catch (\Exception $e){
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
            $success['tyreAssignedPosition'] = AssignTyre::where([['vehicleId',$id]])->whereNotNull('tyre_id')->get()->pluck('position');
            return response()->json(['msg'=>'Tyre Position List','data' => $success], $this->successStatus);
        }catch (\Exception $e){
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
        $this->validate(request(), [
            'position' => 'required',
            'tyre_id' => 'required',
        ]);
        $AssignedTyre = AssignTyre::where([['vehicleId',$id],['position',request('position')]])->first();
        if (AssignTyre::where([['vehicleId', $id], ['position', request('position')], ['id', '!=', @$AssignedTyre->id]])->first()) {
            return back()->with('sorry', 'Vehicle Tyre Is Already Assigned on Position ' . ucfirst(request('position')))->withInput();
        }
        try {
            $AssignTyre =AssignTyre::where([['vehicleId',$id],['position',request('position')]])->first();
            $AssighedData = AssignTyre::where([['vehicleId',$id],['position',request('position')]])->first();
            $AssignTyre->tyre_id = request('tyre_id');
            $AssignTyre->position = request('position');
            $AssignTyre->vehicleId = $id;
            if (request('tyre_id') == 'remove') {
                TyreLog::create([
                    'transaction' => 'Removed',
                    'vehicleId' => $id,
                    'tyre_id' => $AssighedData->tyre_id,
                    'position' => request('position'),
                    'km' => request('km'),
                    'current_depth' => request('current_depth'),
                    'note' => request('note'),
                    'staffId' => request('staffId'),
                    'clientid' => auth()->user()->id,
                ]);
                $AssignTyre->tyre_id = NULL;
                Tyre::findorfail($AssighedData->tyre_id)->update(['vehicleId' => NULL]);
            }
            if ($AssignTyre->isDirty('tyre_id') && request('tyre_id') != 'remove') {
                if (request('tyre_id') != '') {
                    TyreLog::create([
                        'transaction' => 'Inserted',
                        'vehicleId' => $id,
                        'tyre_id' => request('tyre_id'),
                        'position' => request('position'),
                        'km' => request('km'),
                        'current_depth' => request('current_depth'),
                        'note' => request('note'),
                        'staffId' => request('staffId'),
                        'clientid' => auth()->user()->id,
                    ]);
                    Tyre::findorfail(request('tyre_id'))->update(['vehicleId' => $id]);
                }
            }

            $AssignTyre->save();
            return response()->json(['msg'=>'Tyre Position Updated Successfully'], $this->successStatus);
        } catch (\Exception $e) {
            return response()->json(['msg'=>'error'], 404);
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
        //
    }

    public function getTyreListEdit($vehicleId,$position){
        try{
            $AssignedTyre = AssignTyre::where([['vehicleId',$vehicleId],['position',$position]])->first();
            if (empty($AssignedTyre)) {
                $success['tyreList'] = GetNonUsedTyreList(auth()->user()->id);
            }else {
                if (!empty($AssignedTyre->tyre_id)) {
                    $success['tyreList'][] = $AssignedTyre->Tyre;
                    $tyreNew['id'] = 'remove';
                    $tyreNew['tyre_number'] = 'Remove Tyre';
                    $tyreNew['model'] = '';
                    $success['tyreList'][] = $tyreNew;
                }else{
                    $success['tyreList'] = GetNonUsedTyreList(auth()->user()->id);
                }
            }
            return response()->json(['msg'=>'Tyre Position List','data' => $success], $this->successStatus);
        } catch (\Exception $e) {
            return response()->json(['msg'=>'error'], 404);
        }
    }


    public function SaveTyreCurrentStatusVehicle(){
        $this->validate(request(), [
            'transaction' => 'required',
            'position' => 'required',
            'vehicleId' => 'required',
        ]);
        try{
            $AssignedTyre = AssignTyre::where([['vehicleId',request('vehicleId')],['position',request('position')]])->first();
            if (!empty($AssignedTyre)) {
                 if(!empty($AssignedTyre->tyre_id) && !empty($AssignedTyre->position)){
                    TyreLog::create([
                        'transaction' => request('transaction'),
                        'vehicleId' => request('vehicleId'),
                        'tyre_id' =>$AssignedTyre->tyre_id,
                        'position' =>$AssignedTyre->position,
                        'km' => request('km'),
                        'current_depth' => request('current_depth'),
                        'note' => request('note'),
                        'staffId' => request('staffId'),
                        'clientid' => auth()->user()->id,
                    ]);
                }
            }
            return response()->json(['msg'=>'Tyre Position Updated Successfully'], $this->successStatus);
        } catch (\Exception $e) {
            return response()->json(['msg'=>'error'], 404);
        }
    }

     public function getTyreListDetail($vehicleId,$position){
        try{
            $success['tyreLogList'] = TyreLog::where([['vehicleId',$vehicleId],['position',$position]])->with('tyre')->latest()->take(20)->get();
            return response()->json(['msg'=>'Tyre Position List','data' => $success], $this->successStatus);
        } catch (\Exception $e) {
            return response()->json(['msg'=>'error'], 404);
        }
    }

     public function getTyreListDetail($vehicleId,$position){
        try{
            $success['tyreLogList'] = TyreLog::where([['vehicleId',$vehicleId],['position',$position]])->with('tyre')->latest()->take(20)->get();
           return response()->json(['msg'=>'Tyre Position List','data' => $success], $this->successStatus);
        } catch (Exception $e) {
            return response()->json(['msg'=>'error'], 404);
        }
    }
}
