<?php

namespace App\Http\Controllers\ClientController;

use App\Trip;
use App\Vehicle;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TripController extends Controller
{
    /*
   |--------------------------------------------------------------------------
   | Trip Controller
   |--------------------------------------------------------------------------
   |
   | This controller will handle Trip functions
   |
   */

    public function __construct(){
        $this->middleware('client');
        $this->Trip = new Trip;
        $this->Vehicle = new Vehicle;
    }

    /*
     * Add Trip Form
     */
    public function add(){
        return view('client.master.trip.add');
    }

    /*
     * Save Trip form
     */
    public function save(){
        $this->validate(request(),[
            'dateFrom'=>'required|date',
            'dateTo'=>'nullable|date|after:dateFrom',
            'vehicleId'=>'required|exists:vehicles,id',
            'startKm'=>'required|min:0',
            'staff1'=>'nullable|min:0',
        ]);
        $tripCount= $this->Trip::where([['clientid', auth()->user()->id],['vehicleId', request('vehicleId')]])->count();
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
            $Trip->clientid = auth()->user()->id;
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
            return view('client.master.trip.edit',$Data);
        }catch (Exception $e){
            return back()->with('danger','Something went wrong!');
        }
    }

    /*
     * Update Trip data
     */
    public function update($id){
        $this->validate(request(), [
            'dateFrom' => 'required|date',
            'dateTo' => 'nullable|date|after:dateFrom',
            'vehicleId' => 'required|exists:vehicles,id',
            'startKm' => 'required',
            'staff1' => 'required',
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

            $Trip->save();
            return redirect(route('client.ViewTripListVehicleWise', request('vehicleId')))->with('success', ['Trip', 'Updated Successfully']);
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
            return redirect(route('client.ViewTripListVehicleWise', $Trip->vehicleId))->with('success',['Trip Status','Updated Successfully']);
        }catch (Exception $e){
            return back()->with('danger','Something went wrong!');
        }
    }
}
