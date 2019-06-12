<?php

namespace App\Http\Controllers\ClientController;

use App\AssignTyre;
use App\Tyre;
use App\TyreLog;
use App\Vehicle;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TyreController extends Controller
{
    public function view(){
        $Data['Tyres'] = Tyre::where([['clientid',auth()->user()->id]])->get();
        return view('client.master.tyre.view',$Data);
    }

    public function add(){
        return view('client.master.tyre.add');
    }

    public function save(){
        $this->validate(request(),[
            'tyre_number'=>'required',
            'manufacture_company'=>'required',
        ]);
        try {
            $Tyre = new Tyre;
            $Tyre->tyre_number = request('tyre_number');
            $Tyre->model = request('model');
            $Tyre->manufacture_company = request('manufacture_company');
            $Tyre->condition = request('condition');
            $Tyre->original_depth = request('original_depth');
            $Tyre->current_depth = request('current_depth');
            $Tyre->purchased_from = request('purchased_from');
            $Tyre->tyre_status = 1;
            $Tyre->clientid=auth()->user()->id;
            $Tyre->save();
            return redirect(route('client.ViewTyres'))->with('success',['Tyre','Added Successfully!']);
        }catch (Exception $e){
            return back()->with('danger','Something went wrong!');
        }
    }

    public function edit($id){
        try {
            $Data['Tyre'] = Tyre::findorfail($id);
            return view('client.master.tyre.edit',$Data);
        }catch (Exception $e){
            return back()->with('danger','Something went wrong!');
        }
    }

    public function update($id){
        $this->validate(request(),[
            'tyre_number'=>'required',
            'manufacture_company'=>'required',
        ]);



        try {
            $Tyre = Tyre::findorfail($id);
            $Tyre->tyre_number = request('tyre_number');
            $Tyre->model = request('model');
            $Tyre->manufacture_company = request('manufacture_company');
            $Tyre->condition = request('condition');
            $Tyre->original_depth = request('original_depth');
            $Tyre->current_depth = request('current_depth');
            $Tyre->purchased_from = request('purchased_from');
            $Tyre->tyre_status = request('tyre_status');
            $Tyre->clientid=auth()->user()->id;
//            if($Tyre->isDirty('tyre_number')){
//                return 'tyre number changes! insert data to tyre log';
//            }
            $Tyre->save();


            return redirect(route('client.ViewTyres'))->with('success',['Tyre','Updated Successfully!']);
        }catch (Exception $e){
            return back()->with('danger','Something went wrong!');
        }
    }

    public function ViewTyreStatus($id){
        try {
            $Data['TyreLogs'] =  TyreLog::where([['tyre_id',$id]])->orderBy('created_at', 'DESC')->get();
            $Data['Tyre'] = Tyre::findorfail($id);
            return view('client.master.tyre.TyreStatus',$Data);
        }catch (Exception $e){
            return back()->with('danger','Something went wrong!');
        }
    }


    /*Vehicle tyre assignment list*/

    public function ViewTyreVehicleList(){
        return view('client.tyre.AssignTyre.LorryList');
    }

    public function ViewVehicleTyreAssignedList($VehicleID){
        try {
            $Data['Vehicle'] = Vehicle::findorfail($VehicleID);
            $Data['AssignTyres'] = AssignTyre::where([['vehicleId',$VehicleID]])->get();
            return view('client.tyre.AssignTyre.TyreAssignedList',$Data);
        }catch (Exception $e){
            return back()->with('danger','Something went wrong!');
        }
    }

    public function AddAssignTyre($VehicleID) {
        try {
            $Data['Vehicle'] = Vehicle::findorfail($VehicleID);
            return view('client.tyre.AssignTyre.AddAssignTyre',$Data);
        }catch (Exception $e){
            return back()->with('danger','Something went wrong!');
        }
    }


    public function SaveVehicleAssignTyre($VehicleID) {
        $this->validate(request(),[
            'tyre_id'=>'required',
            'position'=>'required',
        ]);
        if(AssignTyre::where([['vehicleId',$VehicleID],['position',request('position')]])->first()){
            return back()->with('sorry','Vehicle Tyre Is Already Assigned on Position '.ucfirst(request('position')))->withInput();
        }
        try {
            $AssignTyre = new AssignTyre;
            $AssignTyre->tyre_id = request('tyre_id');
            $AssignTyre->position = request('position');
            $AssignTyre->vehicleId = $VehicleID;
            $AssignTyre->clientid=auth()->user()->id;
            $AssignTyre->save();
            Tyre::findorfail(request('tyre_id'))->update(['vehicleId'=>$VehicleID]);
            TyreLog::create([
                'transaction'=>'Inserted',
                'vehicleId'=>$VehicleID,
                'tyre_id'=>request('tyre_id'),
                'position'=>request('position'),
                'km'=>request('km'),
                'current_depth'=>request('current_depth'),
                'note'=>request('note'),
                'staffId'=>request('staffId'),
                'clientid'=>auth()->user()->id,
            ]);
            return redirect(route('client.ViewVehicleTyreAssignedList',$VehicleID))->with('success',['Tyre','Assigned Successfully!']);
        }catch (Exception $e){
            return back()->with('danger','Something went wrong!');
        }
    }

    public function EditVehicleAssignTyre($VehicleID,$AssignedTyreId) {
        try {
            $Data['Vehicle'] = Vehicle::findorfail($VehicleID);
            $Data['AssignTyre'] = AssignTyre::findorfail($AssignedTyreId);
            return view('client.tyre.AssignTyre.EditAssignTyre',$Data);
        }catch (Exception $e){
            return back()->with('danger','Something went wrong!');
        }
    }

    public function UpdateVehicleAssignTyre($VehicleID,$AssignedTyreId) {
        $this->validate(request(),[
            'position'=>'required',
        ]);
        if(AssignTyre::where([['vehicleId',$VehicleID],['position',request('position')],['id','!=',$AssignedTyreId]])->first()){
            return back()->with('sorry','Vehicle Tyre Is Already Assigned on Position '.ucfirst(request('position')))->withInput();
        }
        try {
            $AssignTyre = AssignTyre::findorfail($AssignedTyreId);
            $AssighedData = AssignTyre::findorfail($AssignedTyreId);
            $AssignTyre->tyre_id = request('tyre_id');
            $AssignTyre->position = request('position');
            if($AssignTyre->isDirty('position') && !$AssignTyre->isDirty('tyre_id')){
                TyreLog::create([
                    'transaction'=>'Changed From '.AssignTyre::findorfail($AssignedTyreId)->position.' To '.request('position'),
                    'vehicleId'=>$VehicleID,
                    'tyre_id'=>request('tyre_id'),
                    'position'=>request('position'),
                    'km'=>request('km'),
                    'current_depth'=>request('current_depth'),
                    'note'=>request('note'),
                    'staffId'=>request('staffId'),
                    'clientid'=>auth()->user()->id,
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
            if($AssignTyre->isDirty('tyre_id')) {
                if (request('tyre_id') != '') {
                    TyreLog::create([
                        'transaction'=>'Inserted',
                        'vehicleId'=>$VehicleID,
                        'tyre_id'=>request('tyre_id'),
                        'position'=>request('position'),
                        'km'=>request('km'),
                        'current_depth'=>request('current_depth'),
                        'note'=>request('note'),
                        'staffId'=>request('staffId'),
                        'clientid'=>auth()->user()->id,
                    ]);
                    Tyre::findorfail(request('tyre_id'))->update(['vehicleId' => $VehicleID]);
                }
            }

            $AssignTyre->save();
            return redirect(route('client.ViewVehicleTyreAssignedList',$VehicleID))->with('success',['Tyre','Updated Assigned Successfully!']);
        }catch (Exception $e){
            return back()->with('danger','Something went wrong!');
        }
    }
}
