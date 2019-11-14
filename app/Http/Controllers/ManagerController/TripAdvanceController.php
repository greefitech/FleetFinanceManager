<?php

namespace App\Http\Controllers\ManagerController;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\TripAmount;
use App\Trip;

class TripAdvanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){
        return view('manager.trip.trip-advance.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
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
            $TripAmount->clientid=auth()->user()->Owner->id;
            $TripAmount->managerid=auth()->user()->id;
            $TripAmount->save();
            return back()->with('success',['Trip Advance','Added Successfully!']);
        }catch (Exception $e){
            return back()->with('danger','Something went wrong!');
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
        //
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
            $Data['TripAdvance'] = TripAmount::findOrfail($id);
            $Data['Trips'] = Trip::findorfail($Data['TripAdvance']->tripId);
            return view('manager.trip.trip-advance.edit',$Data);
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
        $this->validate(request(), [
            'date' => 'required|date',
            'tripId' => 'required|exists:trips,id',
            'account_id' => 'required',
            'amount' => 'required',
        ]);
        try {
            $TripAmount = TripAmount::findorfail($id);
            $TripAmount->date=request()->date;
            $TripAmount->tripId=request()->tripId;
            $TripAmount->account_id=request()->account_id;
            $TripAmount->amount=request()->amount;
            $TripAmount->clientid=auth()->user()->Owner->id;
            $TripAmount->managerid=auth()->user()->id;
            $TripAmount->save();
            return back()->with('success',['Trip Advance','Added Successfully!']);
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
}
