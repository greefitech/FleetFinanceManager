<?php

namespace App\Http\Controllers\ManagerController;

use App\Trip;
use App\Vehicle;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TripController extends Controller
{
    public function __construct(){
        $this->middleware('manager');
        $this->Trip = new Trip;
        $this->Vehicle = new Vehicle;
    }

    /*
     * Add Trip Form
     */
    public function add(){
        return view('manager.trip.trip.add');
    }

    /*
      * Save Trip form
      */
    public function save(){
        $this->validate(request(),[
            'vehicleId'=>'required|exists:vehicles,id',
            'dateFrom'=>'required|date',
            'dateTo'=>'required|date|after_or_equal:dateFrom',
            'advance'=>'nullable|numeric|min:0',
            'startKm'=>'required|numeric|min:0',
            'endKm'=>'required|numeric|min:'.(int)request('startKm'),
            'staff1' => 'required|exists:staff,id',
            'staff2' => 'nullable|exists:staff,id',
            'staff3' => 'nullable|exists:staff,id',
        ],[
            'staff1.required'=>'Any One Staff Is needed.Select any one staff'
        ]);
        $tripCount= $this->Trip::where([['clientid', auth()->user()->owner->id],['vehicleId', request('vehicleId')]])->count();
        try {
            $Trip = $this->Trip;
            $Trip->vehicleId = request('vehicleId');
            $Trip->tripName = 'Trip '.++$tripCount;
            $Trip->dateFrom = request('dateFrom');
            $Trip->dateTo = request('dateTo');
            $Trip->startKm = request('startKm');
            $Trip->endKm = request('endKm');
            $Trip->totalKm = request('endKm')-request('startKm');
            $Trip->staff1 = request('staff1');
            $Trip->staff2 = request('staff2');
            $Trip->staff3 = request('staff3');
            $Trip->advance = request('advance');
            $Trip->clientid = auth()->user()->owner->id;
            $Trip->managerid = auth()->user()->id;
            $Trip->save();

            // Save Last Km to Vehicle Table
            $vehicle = $this->Vehicle::findorfail(request('vehicleId'));
            if($vehicle->vehicleLastKm < request('endKm')){
                $vehicle->vehicleLastKm = request('endKm');
                $vehicle->save();
            }
            return back()->with('success',['Trip','Created Successfully']);
        }catch (Exception $e){
            return back()->with('danger','Something went wrong!');
        }
    }

    /*
     * Edit Trip Data
     */
    public function edit($id){
        try {
            $Data['Trip'] = $this->Trip::findorfail($id);
            return view('manager.trip.trip.edit',$Data);
        }catch (Exception $e){
            return back()->with('danger','Something went wrong!');
        }
    }

    /*
     * Update Trip data
     */
    public function update($id){
        $this->validate(request(),[
            'vehicleId'=>'required|exists:vehicles,id',
            'dateFrom'=>'required|date',
            'dateTo'=>'required|date|after_or_equal:dateFrom',
            'advance'=>'nullable|numeric|min:0',
            'startKm'=>'required|numeric|min:0',
            'endKm'=>'required|numeric|min:'.(int)request('startKm'),
            'staff1' => 'required|exists:staff,id',
            'staff2' => 'nullable|exists:staff,id',
            'staff3' => 'nullable|exists:staff,id',
            'tripName' => 'required',
        ],[
            'staff1.required'=>'Any One Staff Is needed.Select any one staff'
        ]);

        try {
            $Trip = $this->Trip::findorfail($id);
            $Trip->vehicleId = request('vehicleId');
            $Trip->dateFrom = request('dateFrom');
            $Trip->dateTo = request('dateTo');
            $Trip->startKm = request('startKm');
            $Trip->endKm = request('endKm');
            $Trip->totalKm = request('endKm') - request('startKm');
            $Trip->driverPadi = request('driverPadi');
            $Trip->cleanerPadi = request('cleanerPadi');
            $Trip->staff1 = request('staff1');
            $Trip->staff2 = request('staff2');
            $Trip->staff3 = request('staff3');
            $Trip->advance = request('advance');
            $Trip->tripName = request('tripName');
            $Trip->save();
            return redirect(route('manager.ViewTripListVehicleWise', request('vehicleId')))->with('success', ['Trip', 'Updated Successfully']);
        } catch (Exception $e) {
            return back()->with('danger', 'Something went wrong!');
        }
    }

    /*
     * Update Trip Status completed and not completed
     */
    public function UpdateTripStatus($id){
        try {
            $Trip= $this->Trip::findorfail($id);
            $Trip->status = request('status');
            $Trip->save();
            return redirect(route('manager.ViewTripListVehicleWise', $Trip->vehicleId))->with('success',['Trip Status','Updated Successfully']);
        }catch (Exception $e){
            return back()->with('danger','Something went wrong!');
        }
    }
}
