<?php

namespace App\Http\Controllers\ClientController;

use App\TripAmount;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TripAdvanceController extends Controller
{

    public function add(){
        return view('client.trip.trip-advance.add');
    }

    public function save(){
        $this->validate(request(), [
            'date' => 'required|date',
            'tripId' => 'required|exists:trips,id',
            'account_id' => 'required',
            'amount' => 'required',
        ]);
        try {
            $TripAmount = new TripAmount;
            $TripAmount->date=request()->date;
            $TripAmount->tripId=request()->tripId;
            $TripAmount->account_id=request()->account_id;
            $TripAmount->amount=request()->amount;
            $TripAmount->clientid=auth()->user()->id;
            $TripAmount->save();
            return back()->with('success',['Trip Advance','Added Successfully!']);
        }catch (Exception $e){
            return back()->with('danger','Something went wrong!');
        }
    }

    public function edit($id){
        $Data['TripAdvance'] = TripAmount::findorfail($id);
        return view('client.trip.trip-advance.edit',$Data);
    }

    public function update($id)
    {
        $this->validate(request(), [
            'date' => 'required|date',
            'tripId' => 'required|exists:trips,id',
            'account_id' => 'required',
            'amount' => 'required',
        ]);
        try {
            $TripAmount = TripAmount::findorfail($id);
            $TripAmount->date = request('date');
            $TripAmount->tripId = request('tripId');
            $TripAmount->account_id = request('account_id');
            $TripAmount->amount = request('amount');
            $TripAmount->clientid = auth()->user()->id;
            $TripAmount->save();
            return redirect(route('client.ViewTripAdvanceList', request('tripId')))->with('success', ['Trip Advance', 'Updated Successfully!']);
        } catch (Exception $e) {
            return back()->with('danger', 'Something went wrong!');
        }
    }


    public function delete($id){
        try {
            $TripAmount = TripAmount::findorfail($id);
            $TripAmount->delete();
            return redirect(route('client.ViewTripAdvanceList',$TripAmount->id))->with('success',['Trip Advance','Deleted Successfully!']);
        }catch (Exception $e){
            return back()->with('danger','Something went wrong!');
        }
    }
}
