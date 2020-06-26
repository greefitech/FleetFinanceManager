<?php

namespace App\Http\Controllers\ClientController\Setting;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Vehicle;
use App\AssignTyre;
use App\Tyre;
use App\TyreLog;

class TyreController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('client.setting.tyre.index');
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
        //
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
            $Data['Vehicle'] = Vehicle::findorfail($id);
            $Data['AssignTyres'] = AssignTyre::where([['vehicleId',$id]])->get();
            return view('client.setting.tyre.view',$Data);
        }catch (Exception $e){
            return back()->with('danger','Something went wrong!');
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
        try {
            $Data['Vehicle'] = Vehicle::findorfail($id);
            return view('client.setting.tyre.create',$Data);
        }catch (Exception $e){
            return back()->with('danger','Something went wrong!');
        }
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
          $this->validate(request(),[
            'tyre_id'=>'required',
            'position'=>'required',
        ]);
        if(AssignTyre::where([['vehicleId',$id],['position',request('position')]])->first()){
            return back()->with('sorry','Vehicle Tyre Is Already Assigned on Position '.ucfirst(request('position')))->withInput();
        }
        try {
            $AssignTyre = new AssignTyre;
            $AssignTyre->tyre_id = request('tyre_id');
            $AssignTyre->position = request('position');
            $AssignTyre->vehicleId = $id;
            $AssignTyre->clientid=auth()->user()->id;
            $AssignTyre->save();
            Tyre::findorfail(request('tyre_id'))->update(['vehicleId'=>$id]);
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
            return redirect(action('ClientController\Setting\TyreController@show',$id))->with('success',['Tyre','Assigned Successfully!']);
        }catch (Exception $e){
            return back()->with('danger','Something went wrong!');
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

    public function EditVehicleAssignTyre($VehicleID,$AssignedTyreId) {
        try {
            $Data['Vehicle'] = Vehicle::findorfail($VehicleID);
            $Data['AssignTyre'] = AssignTyre::findorfail($AssignedTyreId);
            return view('client.setting.tyre.edit',$Data);
        }catch (Exception $e){
            return back()->with('danger','Something went wrong!');
        }
    }

    public function UpdateVehicleAssignTyre($VehicleID,$AssignedTyreId){
        $this->validate(request(), [
            'position' => 'required',
        ]);
        if (AssignTyre::where([['vehicleId', $VehicleID], ['position', request('position')], ['id', '!=', $AssignedTyreId]])->first()) {
            return back()->with('sorry', 'Vehicle Tyre Is Already Assigned on Position ' . ucfirst(request('position')))->withInput();
        }
        try {
            $AssignTyre = AssignTyre::findorfail($AssignedTyreId);
            $AssighedData = AssignTyre::findorfail($AssignedTyreId);
            $AssignTyre->tyre_id = request('tyre_id');
            $AssignTyre->position = request('position');
            if ($AssignTyre->isDirty('position') && !$AssignTyre->isDirty('tyre_id')) {
                TyreLog::create([
                    'transaction' => 'Changed From ' . ucfirst(AssignTyre::findorfail($AssignedTyreId)->position) . ' To ' . ucfirst(request('position')),
                    'vehicleId' => $VehicleID,
                    'tyre_id' => request('tyre_id'),
                    'position' => request('position'),
                    'km' => request('km'),
                    'current_depth' => request('current_depth'),
                    'note' => request('note'),
                    'staffId' => request('staffId'),
                    'clientid' => auth()->user()->id,
                ]);
                $AssignTyre->vehicleId = $VehicleID;
                $AssignTyre->position = request('position');
            }
            $AssignTyre->vehicleId = $VehicleID;
            if (request('tyre_id') == '') {
                TyreLog::create([
                    'transaction' => 'Removed',
                    'vehicleId' => $VehicleID,
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
            if ($AssignTyre->isDirty('tyre_id')) {
                if (request('tyre_id') != '') {
                    TyreLog::create([
                        'transaction' => 'Inserted',
                        'vehicleId' => $VehicleID,
                        'tyre_id' => request('tyre_id'),
                        'position' => request('position'),
                        'km' => request('km'),
                        'current_depth' => request('current_depth'),
                        'note' => request('note'),
                        'staffId' => request('staffId'),
                        'clientid' => auth()->user()->id,
                    ]);
                    Tyre::findorfail(request('tyre_id'))->update(['vehicleId' => $VehicleID]);
                }
            }

            $AssignTyre->save();
            return redirect(action('ClientController\Setting\TyreController@show', $VehicleID))->with('success', ['Tyre', 'Updated Assigned Successfully!']);
        } catch (Exception $e) {
            return back()->with('danger', 'Something went wrong!');
        }
    }
    public function AddTyreCurrentStatusVehicle($VehicleID,$AssignedTyreId){
        $Data['Vehicle'] = Vehicle::findorfail($VehicleID);
        $Data['AssignedTyre'] = AssignTyre::findorfail($AssignedTyreId);
        return view('client.setting.tyre.updatestatus',$Data);
    }

    public function SaveTyreCurrentStatusVehicle($VehicleID,$AssignedTyreId){
        $this->validate(request(), [
            'transaction' => 'required',
        ]);
        try{
            $AssignedTyre = AssignTyre::findorfail($AssignedTyreId);
            if(!empty($AssignedTyre->tyre_id) && !empty($AssignedTyre->position)){
                TyreLog::create([
                    'transaction' => request('transaction'),
                    'vehicleId' => $VehicleID,
                    'tyre_id' =>$AssignedTyre->tyre_id,
                    'position' =>$AssignedTyre->position,
                    'km' => request('km'),
                    'current_depth' => request('current_depth'),
                    'note' => request('note'),
                    'staffId' => request('staffId'),
                    'clientid' => auth()->user()->id,
                ]);
            }
            return redirect(action('ClientController\Setting\TyreController@show', $VehicleID))->with('success', ['Tyre Status', 'Added Successfully!']);
        } catch (Exception $e) {
            return back()->with('danger', 'Something went wrong!');
        }
    }
}
