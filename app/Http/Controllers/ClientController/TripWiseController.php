<?php

namespace App\Http\Controllers\ClientController;

use App\Entry;
use App\Expense;
use App\Trip;
use App\Vehicle;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TripWiseController extends Controller
{

    public function __construct(){
        $this->middleware('client');
        $this->Trip = new Trip;
        $this->Vehicle = new Vehicle;
        $this->Entry = new Entry;
    }

    public function ViewVehicleList(){
        return view('client.tripWise.LorryList');
    }

    public function ViewTripListVehicleWise($VehicleID){
        try{
            $Data['Vehicle'] =  $this->Vehicle::findorfail($VehicleID);
            $Data['Trips'] =  $this->Trip::where([['clientid',auth()->user()->id],['vehicleId',$VehicleID]])->orderBy('dateFrom','desc')->get();
            return view('client.tripWise.viewTrips',$Data);
        }catch (Exception $e){
            return back()->with('danger','Something went wrong!');
        }
    }

    public function ViewTripEntryList($TripId){
        try{
            $Data['Trip'] =  $this->Trip::findorfail($TripId);
            $Data['Entries'] =  $this->Entry::where([['tripId',$TripId]])->get();
            return view('client.tripWise.EntryList',$Data);
        }catch (Exception $e){
            return back()->with('danger','Something went wrong!');
        }
    }


    public function ViewTripExpenseList($TripId){
        try{
            $Data['Expenses'] = Expense::where([['tripId',$TripId]])->get();
            return view('client.tripWise.ExpenseList',$Data);
        }catch (Exception $e){
            return back()->with('danger','Something went wrong!');
        }
    }
}
