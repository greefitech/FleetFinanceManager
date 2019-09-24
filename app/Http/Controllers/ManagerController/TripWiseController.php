<?php

namespace App\Http\Controllers\ManagerController;

use App\Entry;
use App\Expense;
use App\Halt;
use App\Trip;
use App\TripAmount;
use App\Vehicle;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TripWiseController extends Controller
{
    public function __construct(){
        $this->middleware('manager');
        $this->Trip = new Trip;
        $this->Vehicle = new Vehicle;
        $this->Entry = new Entry;
    }

    public function ViewVehicleList(){
        return view('manager.tripWise.LorryList');
    }

    public function ViewTripListVehicleWise($VehicleID){
        try{
            $Data['Vehicle'] =  $this->Vehicle::findorfail($VehicleID);
            $Data['Trips'] =  $this->Trip::where([['managerid',auth()->user()->id],['vehicleId',$VehicleID]])->orderBy('dateFrom','desc')->get();
            return view('manager.tripWise.viewTrips',$Data);
        }catch (Exception $e){
            return back()->with('danger','Something went wrong!');
        }
    }

    public function ViewTripEntryList($TripId){
        try{
            $Data['Trip'] =  $this->Trip::findorfail($TripId);
            $Data['Entries'] =  $this->Entry::where([['tripId',$TripId]])->get();
            return view('manager.tripWise.EntryList',$Data);
        }catch (Exception $e){
            return back()->with('danger','Something went wrong!');
        }
    }


    public function ViewTripExpenseList($TripId){
        try{
            $Data['Expenses'] = Expense::where([['tripId',$TripId]])->get();
            return view('manager.tripWise.ExpenseList',$Data);
        }catch (Exception $e){
            return back()->with('danger','Something went wrong!');
        }
    }

    public function ViewTripHaltList($TripId){
        try{
            $Data['Halts'] = Halt::where([['tripId',$TripId]])->get();
            return view('manager.tripWise.HaltList',$Data);
        }catch (Exception $e){
            return back()->with('danger','Something went wrong!');
        }
    }

    public function ViewTripAdvanceList($TripId){
        try{
            $Data['TripAdvances'] = TripAmount::where([['tripId',$TripId]])->get();
            return view('manager.tripWise.TripAdvanceList',$Data);
        }catch (Exception $e){
            return back()->with('danger','Something went wrong!');
        }
    }
}
