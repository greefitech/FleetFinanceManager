<?php

namespace App\Http\Controllers\ClientController;

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
            $Data['Trips'] =  $this->Trip::where([['clientid',auth()->user()->id],['vehicleId',$VehicleID]])->orderBy('dateFrom','desc')->withTrashed()->get();
            return view('client.tripWise.viewTrips',$Data);
        }catch (\Exception $e){
            return back()->with('danger','Something went wrong!');
        }
    }

    public function ViewTripEntryList($TripId){
        try{
            $Data['Trip'] =  $this->Trip::findorfail($TripId);
            $Data['Entries'] =  $this->Entry::where([['tripId',$TripId]])->get();
            return view('client.tripWise.EntryList',$Data);
        }catch (\Exception $e){
            return back()->with('danger','Something went wrong!');
        }
    }


    public function ViewTripExpenseList($TripId){
        try{
            $Data['Expenses'] = Expense::where([['tripId',$TripId]])->get();
            return view('client.tripWise.ExpenseList',$Data);
        }catch (\Exception $e){
            return back()->with('danger','Something went wrong!');
        }
    }

    public function ViewTripHaltList($TripId){
        try{
            $Data['Halts'] = Halt::where([['tripId',$TripId]])->get();
            return view('client.tripWise.HaltList',$Data);
        }catch (\Exception $e){
            return back()->with('danger','Something went wrong!');
        }
    }

    public function ViewTripAdvanceList($TripId){
        try{
            $Data['TripAdvances'] = TripAmount::where([['tripId',$TripId]])->get();
            return view('client.tripWise.TripAdvanceList',$Data);
        }catch (\Exception $e){
            return back()->with('danger','Something went wrong!');
        }
    }

    /*======================
        Delete trip Data
    ========================*/
    public function DeleteTripSheetData($TripId){
        try{
            $this->Entry::where([['tripId',$TripId]])->delete();
            $ExpenseData = Expense::where([['tripId',$TripId]])->delete();
            $HaltData = Halt::where([['tripId',$TripId]])->delete();
            $TripAmountData = TripAmount::where([['tripId',$TripId]])->delete();
            $this->Trip::findorfail($TripId)->delete();
            return back()->with('success',['Trip Sheet','Deleted Successfully']);
        }catch (\Exception $e){
            return back()->with('danger','Something went wrong!');
        }
    }

    public function TripUndoList($TripId){
         try{
            $TripData =  $this->Trip::withTrashed()->findorfail($TripId);
            if (DateDifference($TripData->deleted_at) >= env('UNDO_TRIP_DATE')) {
                return back()->with('danger','Trip Cannot Undo Contact Admin to Undo Trip');
            }
            $this->Trip::withTrashed()->findorfail($TripId)->restore();
            Expense::withTrashed()->where([['tripId',$TripId]])->whereDate('deleted_at',$TripData->deleted_at)->restore();
            $this->Entry::withTrashed()->where([['tripId',$TripId]])->whereDate('deleted_at',$TripData->deleted_at)->restore();
            Halt::withTrashed()->where([['tripId',$TripId]])->whereDate('deleted_at',$TripData->deleted_at)->restore();
            TripAmount::withTrashed()->where([['tripId',$TripId]])->whereDate('deleted_at',$TripData->deleted_at)->restore();
            return back()->with('success',['Trip Sheet','Undo Deleted!']);
        }catch (\Exception $e){
            return back()->with('danger','Something went wrong!');
        }
    }

    /*Old delete code for trip entry*/
    // public function DeleteTripSheetData($TripId){
    //     try{
    //         $EntryData = $this->Entry::where([['tripId',$TripId]])->get();
    //         $ExpenseData = Expense::where([['tripId',$TripId]])->get();
    //         $HaltData = Halt::where([['tripId',$TripId]])->get();
    //         $TripAmountData = TripAmount::where([['tripId',$TripId]])->get();
    //         if($EntryData->isEmpty() && $ExpenseData->isEmpty() && $HaltData->isEmpty() && $TripAmountData->isEmpty()){
    //             $this->Trip::findorfail($TripId)->delete();
    //             return back()->with('success',['Trip Sheet','Deleted Successfully']);
    //         }
    //         return back()->with('sorry','Some Data are in Entry,Expense,Halt Delete that data on that!!');
    //     }catch (\Exception $e){
    //         return back()->with('danger','Something went wrong!');
    //     }
    // }
}