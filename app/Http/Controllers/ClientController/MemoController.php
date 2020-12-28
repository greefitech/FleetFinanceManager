<?php

namespace App\Http\Controllers\ClientController;

use App\Entry;
use App\Expense;
use App\RTOMaster;
use App\Trip;
use App\TripAmount;
use App\TripTemp;
use App\Vehicle;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class MemoController extends Controller
{

     public function __construct(){
        $this->middleware('client');
        $this->Trip = new Trip;
        $this->RTOMaster = new RTOMaster;
        $this->TripTemp = new TripTemp;
    }

    public function memo(){
        $Data['RTOMasters'] = $this->RTOMaster::where([['clientid',auth()->user()->id]])->get();
        // $Data['RTOMasters'] = Trip::all()->sortBy("startKm");
        return view('client.trip.memo',$Data);
    }


    /*
    /----------------------------------------
    /Save Memo function
    /----------------------------------------
    / This function will is used to save the memo sheet on (Trip , entry , expense table)
    / on temp save the data will saved on the temp table.the data will be editable on future
    */

    public function SaveMemo(){

        if(request()->get('btnSubmit') == 'save_memo') {
             $this->validate(request(),[
                'vehicleId'=>'required|exists:vehicles,id',
                'dateFrom'=>'required|date|after:'.date('2010-01-01'),
                'dateTo'=>'required|date|after_or_equal:dateFrom|after:'.date('2010-01-01'),
                'advance'=>'nullable|numeric|min:0',
                'startKm'=>'required|numeric|min:0',
                'endKm'=>'required|numeric|min:'.(int)request('startKm'),
                'staff.0' => 'required|exists:staff,id',
                'staff.1' => 'nullable|exists:staff,id',
                'staff.2' => 'nullable|exists:staff,id',
            ],
            [
                'staff.0.required'=>'Any One Staff Is needed.Select any one staff'
            ]);

            if(!empty(request('EntryData'))){
                $EntryValidator=[];
                foreach(request('EntryData')['dateFrom'] as $EntryDataKey=>$paall){
                    $EntryValidator['EntryData.dateFrom.'.$EntryDataKey] = 'required|date|after_or_equal:.'.request('dateFrom').'|before_or_equal:.'.request('dateTo');
                    $EntryValidator['EntryData.account_id.'.$EntryDataKey] = 'required';
                    $EntryValidator['EntryData.customerId.'.$EntryDataKey] = 'required|exists:customers,id';
                    $EntryValidator['EntryData.locationFrom.'.$EntryDataKey] = 'required';
                    $EntryValidator['EntryData.locationTo.'.$EntryDataKey] = 'required';
                    $EntryValidator['EntryData.loadType.'.$EntryDataKey] = 'required';
                    $EntryValidator['EntryData.ton.'.$EntryDataKey] = 'required|min:1|between:1,99.99';
                    $EntryValidator['EntryData.billAmount.'.$EntryDataKey] = 'required|min:0|numeric';
                    $EntryValidator['EntryData.advance.'.$EntryDataKey] = 'nullable|min:0|numeric';

                    $EntryValidator['EntryData.driverPadi.'.$EntryDataKey] = 'required|numeric|min:0|max:100|between:0,99.99';
                    $EntryValidator['EntryData.cleanerPadi.'.$EntryDataKey] = 'required|numeric|min:0|max:100|between:0,99.99';

                    $EntryValidator['EntryData.driverPadiAmount.'.$EntryDataKey] = 'nullable|numeric|min:0';
                    $EntryValidator['EntryData.cleanerPadiAmount.'.$EntryDataKey] = 'nullable|numeric|min:0';

                    $EntryValidator['EntryData.commission_status.'.$EntryDataKey] = 'required';
                    $EntryValidator['EntryData.loading_mamool_status.'.$EntryDataKey] = 'required';
                    $EntryValidator['EntryData.unloading_mamool_status.'.$EntryDataKey] = 'required';

                    $EntryValidator['EntryData.loadingMamool.'.$EntryDataKey] = 'nullable|min:0|numeric';
                    $EntryValidator['EntryData.unLoadingMamool.'.$EntryDataKey] = 'nullable|min:0|numeric';
                }
                $this->validate(request(), $EntryValidator);
            }

            
            /*
             * Diesel validator
             * */
            if(!empty(request('DieselData'))){
                $DieselValidator=[];
                foreach(request('DieselData')['amount'] as $DieselDataKey=>$paall){
                    $DieselValidator['DieselData.account_id.'.$DieselDataKey] = 'required';
                    $DieselValidator['DieselData.date.'.$DieselDataKey] = 'required|date|after_or_equal:.'.request('dateFrom').'|before_or_equal:.'.request('dateTo');
                    $DieselValidator['DieselData.quantity.'.$DieselDataKey] = 'required|min:1|numeric|between:1,50000.99';
                    $DieselValidator['DieselData.amount.'.$DieselDataKey] = 'required|min:0|numeric';
                    $DieselValidator1['DieselData.amount.'.$DieselDataKey.'.required'] = 'The Diesel Amount Field is required';
                }
                $this->validate(request(), $DieselValidator,$DieselValidator1);
            }

             /*
             * Extra Expense Validator
             */
            if(!empty(request('ExtraExpense'))){
                $PCValidator=[];
                foreach(request('ExtraExpense')['expense_type'] as $ExtraExpenseKey=>$EXt){
                    $PCValidator['ExtraExpense.expense_type.'.$ExtraExpenseKey] = 'required|exists:expense_types,id';
                    $PCValidator['ExtraExpense.account_id.'.$ExtraExpenseKey] = 'required';
                    $PCValidator['ExtraExpense.amount.'.$ExtraExpenseKey] = 'required|min:0|numeric';
                }
                $this->validate(request(), $PCValidator);
            }

            /*
             * PC data validation validate location and amount all data are required
             */
            if(!empty(request('PCData'))){
                $PCValidator=[];
                foreach(request('PCData')['location'] as $PCKey=>$PCD){
                    $PCValidator['PCData.location.'.$PCKey] = 'required';
                    $PCValidator['PCData.amount.'.$PCKey] = 'required|min:0|numeric';
                }
                $this->validate(request(), $PCValidator);
            }

            /*
             * RTO data validation validate location and amount all data are required
             */
            if(!empty(request('RTOData'))){
                $PCValidator=[];
                foreach(request('RTOData')['location'] as $PCKey=>$PCD){
                    $PCValidator['RTOData.location.'.$PCKey] = 'required';
                    $PCValidator['RTOData.amount.'.$PCKey] = 'required|min:0|numeric';
                }
                $this->validate(request(), $PCValidator);
            }

            /*
             * Paalam Toll validator
             * */
            if(!empty(request('PaalamToll'))){
                $PCValidator=[];
                foreach(request('PaalamToll')['amount'] as $PaalamTollKey=>$paall){
                    $PCValidator['PaalamToll.account_id.'.$PaalamTollKey] = 'required';
                    $PCValidator['PaalamToll.amount.'.$PaalamTollKey] = 'required|min:0|numeric';
                }
                $this->validate(request(), $PCValidator);
            }



            /*
             * Driver Advance Validaor*/
            if(!empty(request('DriverAdvance'))){
                $DriverAdvanceValidator=[];
                foreach(request('DriverAdvance')['amount'] as $DriverAdvanceKey=>$Driver){
                    $DriverAdvanceValidator['DriverAdvance.date.'.$DriverAdvanceKey] = 'required|date|after_or_equal:.'.request('dateFrom').'|before_or_equal:.'.request('dateTo');
                    $DriverAdvanceValidator['DriverAdvance.account_id.'.$DriverAdvanceKey] = 'required';
                    $DriverAdvanceValidator['DriverAdvance.amount.'.$DriverAdvanceKey] = 'required|min:0|numeric';
                }
                $this->validate(request(), $DriverAdvanceValidator);
            }

//        dd(request()->all());
            try {

                $tripCount= $this->Trip::where([['clientid', auth()->user()->id],['vehicleId', request('vehicleId')]])->count();
                $Trip = $this->Trip;
                $Trip->vehicleId = request('vehicleId');
                $Trip->tripName = 'Trip '.++$tripCount;
                $Trip->dateFrom = request('dateFrom');
                $Trip->dateTo = request('dateTo');
                $Trip->startKm = request('startKm');
                $Trip->endKm = request('endKm');
                $Trip->totalKm = request('endKm')-request('startKm');
                $Trip->staff1 = request('staff')[0];
                $Trip->staff2 = request('staff')[1];
                $Trip->staff3 = request('staff')[2];
                $Trip->advance = request('advance');
                $Trip->clientid = auth()->user()->id;
                $Trip->save();
                $vehicle = Vehicle::findorfail(request('vehicleId'));
                if($vehicle->vehicleLastKm < request('endKm')){
                    $vehicle->vehicleLastKm = request('endKm');
                    $vehicle->save();
                }
                if(!empty(request('EntryData'))){
                    foreach(request('EntryData')['dateFrom'] as $EntryDataKey=>$ENTr){
                        $entry = new Entry;
                        $entry->dateFrom=request('EntryData')['dateFrom'][$EntryDataKey];
                        $entry->vehicleId=request('vehicleId');
                        $entry->customerId=request('EntryData')['customerId'][$EntryDataKey];
                        $entry->locationFrom=request('EntryData')['locationFrom'][$EntryDataKey];
                        $entry->locationTo=request('EntryData')['locationTo'][$EntryDataKey];
                        $entry->loadType=request('EntryData')['loadType'][$EntryDataKey];
                        $entry->ton=request('EntryData')['ton'][$EntryDataKey];
                        $entry->billAmount=request('EntryData')['billAmount'][$EntryDataKey];
                        $entry->advance=request('EntryData')['advance'][$EntryDataKey];
                        $entry->driverPadi=request('EntryData')['driverPadi'][$EntryDataKey];
                        $entry->cleanerPadi=request('EntryData')['cleanerPadi'][$EntryDataKey];

                        $entry->driverPadiAmount=   (isset(request('EntryData')['driverPadi'][$EntryDataKey]))?round((request('EntryData')['billAmount'][$EntryDataKey] * request('EntryData')['driverPadi'][$EntryDataKey]) / 100):request('EntryData')['driverPadiAmount'][$EntryDataKey];
                        $entry->cleanerPadiAmount=   (isset(request('EntryData')['cleanerPadi'][$EntryDataKey]))?round((request('EntryData')['billAmount'][$EntryDataKey] * request('EntryData')['cleanerPadi'][$EntryDataKey]) / 100):request('EntryData')['cleanerPadiAmount'][$EntryDataKey];

                        $entry->comission=request('EntryData')['comission'][$EntryDataKey];
                        $entry->loadingMamool=request('EntryData')['loadingMamool'][$EntryDataKey];
                        $entry->unLoadingMamool=request('EntryData')['unLoadingMamool'][$EntryDataKey];

                        $entry->commission_status=request('EntryData')['commission_status'][$EntryDataKey];
                        $entry->loading_mamool_status=request('EntryData')['loading_mamool_status'][$EntryDataKey];
                        $entry->unloading_mamool_status=request('EntryData')['unloading_mamool_status'][$EntryDataKey];

                        $balance =request('EntryData')['billAmount'][$EntryDataKey] - request('EntryData')['advance'][$EntryDataKey];
                        $entry->balance=$balance;
                        $entry->account_id=request('EntryData')['account_id'][$EntryDataKey];
                        $entry->tripId=$Trip->id;
                        $entry->clientid=auth()->user()->id;
                        $entry->save();
                    }
                }


                if(!empty(request('DieselData'))){
                    foreach(request('DieselData')['amount'] as $DieselDataKey=>$Dis){
                        $Expense = new Expense;
                        $Expense->date = request('DieselData')['date'][$DieselDataKey];
                        $Expense->expense_type = 2;
                        $Expense->vehicleId = request('vehicleId');
                        $Expense->vendor_id = request('DieselData')['vendor_id'][$DieselDataKey];
                        $Expense->quantity = request('DieselData')['quantity'][$DieselDataKey];
                        $Expense->amount = request('DieselData')['amount'][$DieselDataKey];
                        $Expense->status = request('DieselData')['status'][$DieselDataKey];
                        $Expense->paid_status = request('DieselData')['status'][$DieselDataKey];
                        $Expense->location = request('DieselData')['location'][$DieselDataKey];
                        $Expense->discription = request('DieselData')['discription'][$DieselDataKey];
                        $Expense->account_id = request('DieselData')['account_id'][$DieselDataKey];
                        $Expense->tripId=$Trip->id;
                        $Expense->clientid=auth()->user()->id;
                        $Expense->save();
                    }
                }


                if(!empty(request('RTOData'))){
                    foreach(request('RTOData')['location'] as $RTOKey=>$PCD){
                        $Expense = new Expense;
                        $Expense->date = request('dateTo');
                        $Expense->expense_type = 4;
                        $Expense->vehicleId = request('vehicleId');
                        $Expense->amount = request('RTOData')['amount'][$RTOKey];
                        $Expense->status = 1;
                        $Expense->location = request('RTOData')['location'][$RTOKey];
                        $Expense->account_id = 1;
                        $Expense->tripId=$Trip->id;
                        $Expense->clientid=auth()->user()->id;
                        $Expense->save();
                    }
                }


                if(!empty(request('PCData'))){
                    foreach(request('PCData')['location'] as $PCKey=>$PCD){
                        $Expense = new Expense;
                        $Expense->date = request('dateTo');
                        $Expense->expense_type = 12;
                        $Expense->vehicleId = request('vehicleId');
                        $Expense->amount = request('PCData')['amount'][$PCKey];
                        $Expense->status = 1;
                        $Expense->location = request('PCData')['location'][$PCKey];
                        $Expense->account_id = 1;
                        $Expense->tripId=$Trip->id;
                        $Expense->clientid=auth()->user()->id;
                        $Expense->save();
                    }
                }


                if(!empty(request('ExtraExpense'))){
                    foreach(request('ExtraExpense')['expense_type'] as $ExtraExpenseKey=>$Extra){
                        $Expense = new Expense;
                        $Expense->date = request('dateTo');
                        $Expense->expense_type = request('ExtraExpense')['expense_type'][$ExtraExpenseKey];
                        $Expense->vehicleId = request('vehicleId');
                        $Expense->quantity = request('ExtraExpense')['quantity'][$ExtraExpenseKey];
                        $Expense->amount = request('ExtraExpense')['amount'][$ExtraExpenseKey];
                        $Expense->status = request('ExtraExpense')['status'][$ExtraExpenseKey];
                        $Expense->location = request('ExtraExpense')['location'][$ExtraExpenseKey];
                        $Expense->discription = request('ExtraExpense')['discription'][$ExtraExpenseKey];
                        $Expense->account_id = request('ExtraExpense')['account_id'][$ExtraExpenseKey];
                        $Expense->tripId=$Trip->id;
                        $Expense->status=request('ExtraExpense')['status'][$ExtraExpenseKey];
                        $Expense->clientid=auth()->user()->id;
                        $Expense->save();
                    }
                }


                if(!empty(request('PaalamToll'))){
                    foreach(request('PaalamToll')['amount'] as $PaalamTollKey=>$paall){
                        $Expense = new Expense;
                        $Expense->date = request('dateTo');
                        $Expense->expense_type = 6;
                        $Expense->vehicleId = request('vehicleId');
                        $Expense->amount = request('PaalamToll')['amount'][$PaalamTollKey];
                        $Expense->status = 1;
                        $Expense->location = request('PaalamToll')['location'][$PaalamTollKey];
                        $Expense->account_id = request('PaalamToll')['account_id'][$PaalamTollKey];
                        $Expense->tripId=$Trip->id;
                        $Expense->status=1;
                        $Expense->clientid=auth()->user()->id;
                        $Expense->save();
                    }
                }

                if(!empty(request('DriverAdvance'))){
                    foreach(request('DriverAdvance')['date'] as $DriverAdvanceKey=>$Driver){
                        $TripAmount = new TripAmount;
                        $TripAmount->date = request('DriverAdvance')['date'][$DriverAdvanceKey];
                        $TripAmount->account_id = request('DriverAdvance')['account_id'][$DriverAdvanceKey];
                        $TripAmount->amount = request('DriverAdvance')['amount'][$DriverAdvanceKey];
                        $TripAmount->tripId=$Trip->id;
                        $TripAmount->clientid = auth()->user()->id;
                        $TripAmount->save();
                    }
                }
                return redirect(action('ClientController\TripWiseController@ViewVehicleList'))->with('success',['Memo Entry','Added Successfully!']);
             }catch (\Exception $e){
                return back()->with('danger','Something went wrong!');
            }

        } else if(request()->get('btnSubmit') == 'add_partially_memo') {

            /*The partially filled data will be daved on temp table data*/

            $this->validate(request(),[
                'vehicleId'=>'required|exists:vehicles,id',
                'dateFrom'=>'required|date|after:'.date('2010-01-01'),
                'dateTo'=>'required|date|after_or_equal:dateFrom|after:'.date('2010-01-01'),
                'advance'=>'nullable|numeric|min:0',
                'startKm'=>'required|numeric|min:0',
                'endKm'=>'required|numeric|min:'.(int)request('startKm'),
                'staff.0' => 'required|exists:staff,id',
                'staff.1' => 'nullable|exists:staff,id',
                'staff.2' => 'nullable|exists:staff,id',
            ],
            [
                'staff.0.required'=>'Any One Staff Is needed.Select any one staff'
            ]);
            
            try {
                $TripTemp = $this->TripTemp;
                $TripTemp->vehicleId = request('vehicleId');
                $TripTemp->tripName = 'Trip';
                $TripTemp->dateFrom = request('dateFrom');
                $TripTemp->dateTo = request('dateTo');
                $TripTemp->startKm = request('startKm');
                $TripTemp->endKm = request('endKm');
                $TripTemp->totalKm = request('endKm')-request('startKm');
                $TripTemp->staff1 = request('staff')[0];
                $TripTemp->staff2 = request('staff')[1];
                $TripTemp->staff3 = request('staff')[2];
                $TripTemp->advance = request('advance');
                $TripTemp->entry = serialize(request('EntryData'));
                $TripTemp->diesel = serialize(request('DieselData'));
                $TripTemp->rto = serialize(request('RTOData'));
                $TripTemp->pc = serialize(request('PCData'));
                $TripTemp->extraExpense = serialize(request('ExtraExpense'));
                $TripTemp->tollgate = serialize(request('PaalamToll'));
                $TripTemp->driverAdvance = serialize(request('DriverAdvance'));
                $TripTemp->clientid = auth()->user()->id;
                $TripTemp->save();
                return redirect(action('ClientController\MemoController@ViewTempMemo'))->with('success',['Memo Entry','Added Partially!']);
            }catch (\Exception $e){
                return back()->with('danger','Something went wrong!');
            }
        }

    }

    public function ViewTempMemo(){
        try {
            $Data['TripTemps'] =  $this->TripTemp::where([['clientid',auth()->user()->id]])->get();
            return view('client.trip.memo.list-temp-memo',$Data);
        }catch (\Exception $e){
            return back()->with('danger','Something went wrong!');
        }
    }


    public function getendingkm(){
        return Trip::where('vehicleId',request('VehicleId'))->get()->sortByDesc('dateTo')->first();
    }


    /*Edit temp memo function*/
    public function edit($id){
        try {
            $Data['TripTemp'] = $this->TripTemp::findOrfail($id);
            $Data['RTOMasters'] = $this->RTOMaster::where([['clientid',auth()->user()->id]])->get();
            return view('client.trip.memo',$Data);
        }catch (\Exception $e){
            return back()->with('danger','Something went wrong!');
        }
    }



    /*
    /-------------------------------------
    /Update Memo Function 
    /-------------------------------------
    / This function is for update the temp memo sheet and if saved Permanently
    / if save as temp -> this will update the old temp memo sheet on it. 
    */
     public function updateMemo($id){
         if(request()->get('btnSubmit') == 'save_memo') {
             $this->validate(request(),[
                'vehicleId'=>'required|exists:vehicles,id',
                'dateFrom'=>'required|date',
                'dateTo'=>'required|date|after_or_equal:dateFrom',
                'advance'=>'nullable|numeric|min:0',
                'startKm'=>'required|numeric|min:0',
                'endKm'=>'required|numeric|min:'.(int)request('startKm'),
                'staff.0' => 'required|exists:staff,id',
                'staff.1' => 'nullable|exists:staff,id',
                'staff.2' => 'nullable|exists:staff,id',
            ],
            [
                'staff.0.required'=>'Any One Staff Is needed.Select any one staff'
            ]);

            if(!empty(request('EntryData'))){
                $EntryValidator=[];
                foreach(request('EntryData')['dateFrom'] as $EntryDataKey=>$paall){
                    $EntryValidator['EntryData.dateFrom.'.$EntryDataKey] = 'required|date|after_or_equal:.'.request('dateFrom').'|before_or_equal:.'.request('dateTo');
                    $EntryValidator['EntryData.account_id.'.$EntryDataKey] = 'required';
                    $EntryValidator['EntryData.customerId.'.$EntryDataKey] = 'required|exists:customers,id';
                    $EntryValidator['EntryData.locationFrom.'.$EntryDataKey] = 'required';
                    $EntryValidator['EntryData.locationTo.'.$EntryDataKey] = 'required';
                    $EntryValidator['EntryData.loadType.'.$EntryDataKey] = 'required';
                    $EntryValidator['EntryData.ton.'.$EntryDataKey] = 'required|min:1|between:1,99.99';
                    $EntryValidator['EntryData.billAmount.'.$EntryDataKey] = 'required|min:0|numeric';
                    $EntryValidator['EntryData.advance.'.$EntryDataKey] = 'nullable|min:0|numeric';

                    $EntryValidator['EntryData.driverPadi.'.$EntryDataKey] = 'required|numeric|min:0|max:100|between:0,99.99';
                    $EntryValidator['EntryData.cleanerPadi.'.$EntryDataKey] = 'required|numeric|min:0|max:100|between:0,99.99';

                    $EntryValidator['EntryData.driverPadiAmount.'.$EntryDataKey] = 'nullable|numeric|min:0';
                    $EntryValidator['EntryData.cleanerPadiAmount.'.$EntryDataKey] = 'nullable|numeric|min:0';

                    $EntryValidator['EntryData.commission_status.'.$EntryDataKey] = 'required';
                    $EntryValidator['EntryData.loading_mamool_status.'.$EntryDataKey] = 'required';
                    $EntryValidator['EntryData.unloading_mamool_status.'.$EntryDataKey] = 'required';

                    $EntryValidator['EntryData.loadingMamool.'.$EntryDataKey] = 'nullable|min:0|numeric';
                    $EntryValidator['EntryData.unLoadingMamool.'.$EntryDataKey] = 'nullable|min:0|numeric';
                }
                $this->validate(request(), $EntryValidator);
            }

            
            /*
             * Diesel validator
             * */
            if(!empty(request('DieselData'))){
                $DieselValidator=[];
                foreach(request('DieselData')['amount'] as $DieselDataKey=>$paall){
                    $DieselValidator['DieselData.account_id.'.$DieselDataKey] = 'required';
                    $DieselValidator['DieselData.date.'.$DieselDataKey] = 'required|date|after_or_equal:.'.request('dateFrom').'|before_or_equal:.'.request('dateTo');
                    $DieselValidator['DieselData.quantity.'.$DieselDataKey] = 'required|min:1|numeric|between:1,50000.99';
                    $DieselValidator['DieselData.amount.'.$DieselDataKey] = 'required|min:0|numeric';
                    $DieselValidator1['DieselData.amount.'.$DieselDataKey.'.required'] = 'The Diesel Amount Field is required';
                }
                $this->validate(request(), $DieselValidator,$DieselValidator1);
            }

             /*
             * Extra Expense Validator
             */
            if(!empty(request('ExtraExpense'))){
                $PCValidator=[];
                foreach(request('ExtraExpense')['expense_type'] as $ExtraExpenseKey=>$EXt){
                    $PCValidator['ExtraExpense.expense_type.'.$ExtraExpenseKey] = 'required|exists:expense_types,id';
                    $PCValidator['ExtraExpense.account_id.'.$ExtraExpenseKey] = 'required';
                    $PCValidator['ExtraExpense.amount.'.$ExtraExpenseKey] = 'required|min:0|numeric';
                }
                $this->validate(request(), $PCValidator);
            }

            /*
             * PC data validation validate location and amount all data are required
             */
            if(!empty(request('PCData'))){
                $PCValidator=[];
                foreach(request('PCData')['location'] as $PCKey=>$PCD){
                    $PCValidator['PCData.location.'.$PCKey] = 'required';
                    $PCValidator['PCData.amount.'.$PCKey] = 'required|min:0|numeric';
                }
                $this->validate(request(), $PCValidator);
            }

            /*
             * RTO data validation validate location and amount all data are required
             */
            if(!empty(request('RTOData'))){
                $PCValidator=[];
                foreach(request('RTOData')['location'] as $PCKey=>$PCD){
                    $PCValidator['RTOData.location.'.$PCKey] = 'required';
                    $PCValidator['RTOData.amount.'.$PCKey] = 'required|min:0|numeric';
                }
                $this->validate(request(), $PCValidator);
            }

            /*
             * Paalam Toll validator
             * */
            if(!empty(request('PaalamToll'))){
                $PCValidator=[];
                foreach(request('PaalamToll')['amount'] as $PaalamTollKey=>$paall){
                    $PCValidator['PaalamToll.account_id.'.$PaalamTollKey] = 'required';
                    $PCValidator['PaalamToll.amount.'.$PaalamTollKey] = 'required|min:0|numeric';
                }
                $this->validate(request(), $PCValidator);
            }



            /*
             * Driver Advance Validaor*/
            if(!empty(request('DriverAdvance'))){
                $DriverAdvanceValidator=[];
                foreach(request('DriverAdvance')['amount'] as $DriverAdvanceKey=>$Driver){
                    $DriverAdvanceValidator['DriverAdvance.date.'.$DriverAdvanceKey] = 'required|date|after_or_equal:.'.request('dateFrom').'|before_or_equal:.'.request('dateTo');
                    $DriverAdvanceValidator['DriverAdvance.account_id.'.$DriverAdvanceKey] = 'required';
                    $DriverAdvanceValidator['DriverAdvance.amount.'.$DriverAdvanceKey] = 'required|min:0|numeric';
                }
                $this->validate(request(), $DriverAdvanceValidator);
            }

//        dd(request()->all());
            try {

                $tripCount= $this->Trip::where([['clientid', auth()->user()->id],['vehicleId', request('vehicleId')]])->count();
                $Trip = $this->Trip;
                $Trip->vehicleId = request('vehicleId');
                $Trip->tripName = 'Trip '.++$tripCount;
                $Trip->dateFrom = request('dateFrom');
                $Trip->dateTo = request('dateTo');
                $Trip->startKm = request('startKm');
                $Trip->endKm = request('endKm');
                $Trip->totalKm = request('endKm')-request('startKm');
                $Trip->staff1 = request('staff')[0];
                $Trip->staff2 = request('staff')[1];
                $Trip->staff3 = request('staff')[2];
                $Trip->advance = request('advance');
                $Trip->clientid = auth()->user()->id;
                $Trip->save();
                $vehicle = Vehicle::findorfail(request('vehicleId'));
                if($vehicle->vehicleLastKm < request('endKm')){
                    $vehicle->vehicleLastKm = request('endKm');
                    $vehicle->save();
                }
                if(!empty(request('EntryData'))){
                    foreach(request('EntryData')['dateFrom'] as $EntryDataKey=>$ENTr){
                        $entry = new Entry;
                        $entry->dateFrom=request('EntryData')['dateFrom'][$EntryDataKey];
                        $entry->vehicleId=request('vehicleId');
                        $entry->customerId=request('EntryData')['customerId'][$EntryDataKey];
                        $entry->locationFrom=request('EntryData')['locationFrom'][$EntryDataKey];
                        $entry->locationTo=request('EntryData')['locationTo'][$EntryDataKey];
                        $entry->loadType=request('EntryData')['loadType'][$EntryDataKey];
                        $entry->ton=request('EntryData')['ton'][$EntryDataKey];
                        $entry->billAmount=request('EntryData')['billAmount'][$EntryDataKey];
                        $entry->advance=request('EntryData')['advance'][$EntryDataKey];
                        $entry->driverPadi=request('EntryData')['driverPadi'][$EntryDataKey];
                        $entry->cleanerPadi=request('EntryData')['cleanerPadi'][$EntryDataKey];

                        $entry->driverPadiAmount=   (isset(request('EntryData')['driverPadi'][$EntryDataKey]))?round((request('EntryData')['billAmount'][$EntryDataKey] * request('EntryData')['driverPadi'][$EntryDataKey]) / 100):request('EntryData')['driverPadiAmount'][$EntryDataKey];
                        $entry->cleanerPadiAmount=   (isset(request('EntryData')['cleanerPadi'][$EntryDataKey]))?round((request('EntryData')['billAmount'][$EntryDataKey] * request('EntryData')['cleanerPadi'][$EntryDataKey]) / 100):request('EntryData')['cleanerPadiAmount'][$EntryDataKey];

                        $entry->comission=request('EntryData')['comission'][$EntryDataKey];
                        $entry->loadingMamool=request('EntryData')['loadingMamool'][$EntryDataKey];
                        $entry->unLoadingMamool=request('EntryData')['unLoadingMamool'][$EntryDataKey];

                        $entry->commission_status=request('EntryData')['commission_status'][$EntryDataKey];
                        $entry->loading_mamool_status=request('EntryData')['loading_mamool_status'][$EntryDataKey];
                        $entry->unloading_mamool_status=request('EntryData')['unloading_mamool_status'][$EntryDataKey];

                        $balance =request('EntryData')['billAmount'][$EntryDataKey] - request('EntryData')['advance'][$EntryDataKey];
                        $entry->balance=$balance;
                        $entry->account_id=request('EntryData')['account_id'][$EntryDataKey];
                        $entry->tripId=$Trip->id;
                        $entry->clientid=auth()->user()->id;
                        $entry->save();
                    }
                }


                if(!empty(request('DieselData'))){
                    foreach(request('DieselData')['amount'] as $DieselDataKey=>$Dis){
                        $Expense = new Expense;
                        $Expense->date = request('DieselData')['date'][$DieselDataKey];
                        $Expense->expense_type = 2;
                        $Expense->vehicleId = request('vehicleId');
                        $Expense->vendor_id = request('DieselData')['vendor_id'][$DieselDataKey];
                        $Expense->quantity = request('DieselData')['quantity'][$DieselDataKey];
                        $Expense->amount = request('DieselData')['amount'][$DieselDataKey];
                        $Expense->status = request('DieselData')['status'][$DieselDataKey];
                        $Expense->paid_status = request('DieselData')['status'][$DieselDataKey];
                        $Expense->location = request('DieselData')['location'][$DieselDataKey];
                        $Expense->discription = request('DieselData')['discription'][$DieselDataKey];
                        $Expense->account_id = request('DieselData')['account_id'][$DieselDataKey];
                        $Expense->tripId=$Trip->id;
                        $Expense->clientid=auth()->user()->id;
                        $Expense->save();
                    }
                }


                if(!empty(request('RTOData'))){
                    foreach(request('RTOData')['location'] as $RTOKey=>$PCD){
                        $Expense = new Expense;
                        $Expense->date = request('dateTo');
                        $Expense->expense_type = 4;
                        $Expense->vehicleId = request('vehicleId');
                        $Expense->amount = request('RTOData')['amount'][$RTOKey];
                        $Expense->status = 1;
                        $Expense->location = request('RTOData')['location'][$RTOKey];
                        $Expense->account_id = 1;
                        $Expense->tripId=$Trip->id;
                        $Expense->clientid=auth()->user()->id;
                        $Expense->save();
                    }
                }


                if(!empty(request('PCData'))){
                    foreach(request('PCData')['location'] as $PCKey=>$PCD){
                        $Expense = new Expense;
                        $Expense->date = request('dateTo');
                        $Expense->expense_type = 12;
                        $Expense->vehicleId = request('vehicleId');
                        $Expense->amount = request('PCData')['amount'][$PCKey];
                        $Expense->status = 1;
                        $Expense->location = request('PCData')['location'][$PCKey];
                        $Expense->account_id = 1;
                        $Expense->tripId=$Trip->id;
                        $Expense->clientid=auth()->user()->id;
                        $Expense->save();
                    }
                }


                if(!empty(request('ExtraExpense'))){
                    foreach(request('ExtraExpense')['expense_type'] as $ExtraExpenseKey=>$Extra){
                        $Expense = new Expense;
                        $Expense->date = request('dateTo');
                        $Expense->expense_type = request('ExtraExpense')['expense_type'][$ExtraExpenseKey];
                        $Expense->vehicleId = request('vehicleId');
                        $Expense->quantity = request('ExtraExpense')['quantity'][$ExtraExpenseKey];
                        $Expense->amount = request('ExtraExpense')['amount'][$ExtraExpenseKey];
                        $Expense->status = request('ExtraExpense')['status'][$ExtraExpenseKey];
                        $Expense->location = request('ExtraExpense')['location'][$ExtraExpenseKey];
                        $Expense->discription = request('ExtraExpense')['discription'][$ExtraExpenseKey];
                        $Expense->account_id = request('ExtraExpense')['account_id'][$ExtraExpenseKey];
                        $Expense->tripId=$Trip->id;
                        $Expense->status=request('ExtraExpense')['status'][$ExtraExpenseKey];
                        $Expense->clientid=auth()->user()->id;
                        $Expense->save();
                    }
                }


                if(!empty(request('PaalamToll'))){
                    foreach(request('PaalamToll')['amount'] as $PaalamTollKey=>$paall){
                        $Expense = new Expense;
                        $Expense->date = request('dateTo');
                        $Expense->expense_type = 6;
                        $Expense->vehicleId = request('vehicleId');
                        $Expense->amount = request('PaalamToll')['amount'][$PaalamTollKey];
                        $Expense->status = 1;
                        $Expense->location = request('PaalamToll')['location'][$PaalamTollKey];
                        $Expense->account_id = request('PaalamToll')['account_id'][$PaalamTollKey];
                        $Expense->tripId=$Trip->id;
                        $Expense->status=1;
                        $Expense->clientid=auth()->user()->id;
                        $Expense->save();
                    }
                }

                if(!empty(request('DriverAdvance'))){
                    foreach(request('DriverAdvance')['date'] as $DriverAdvanceKey=>$Driver){
                        $TripAmount = new TripAmount;
                        $TripAmount->date = request('DriverAdvance')['date'][$DriverAdvanceKey];
                        $TripAmount->account_id = request('DriverAdvance')['account_id'][$DriverAdvanceKey];
                        $TripAmount->amount = request('DriverAdvance')['amount'][$DriverAdvanceKey];
                        $TripAmount->tripId=$Trip->id;
                        $TripAmount->clientid = auth()->user()->id;
                        $TripAmount->save();
                    }
                }
                $this->TripTemp::findorfail($id)->delete();
                return redirect(action('ClientController\TripWiseController@ViewVehicleList'))->with('success',['Memo Entry Trip','Created Successfully!']);
             }catch (\Exception $e){
                return back()->with('danger','Something went wrong!');
            }

        } else if(request()->get('btnSubmit') == 'add_partially_memo') {

            /*The partially filled data will be daved on temp table data*/

            $this->validate(request(),[
                'vehicleId'=>'required|exists:vehicles,id',
                'dateFrom'=>'required|date',
                'dateTo'=>'required|date|after_or_equal:dateFrom',
                'advance'=>'nullable|numeric|min:0',
                'startKm'=>'required|numeric|min:0',
                'endKm'=>'required|numeric|min:'.(int)request('startKm'),
                'staff.0' => 'required|exists:staff,id',
                'staff.1' => 'nullable|exists:staff,id',
                'staff.2' => 'nullable|exists:staff,id',
            ],
            [
                'staff.0.required'=>'Any One Staff Is needed.Select any one staff'
            ]);
            
            try {
                $TripTemp = $this->TripTemp::findorfail($id);
                $TripTemp->vehicleId = request('vehicleId');
                $TripTemp->tripName = 'Trip';
                $TripTemp->dateFrom = request('dateFrom');
                $TripTemp->dateTo = request('dateTo');
                $TripTemp->startKm = request('startKm');
                $TripTemp->endKm = request('endKm');
                $TripTemp->totalKm = request('endKm')-request('startKm');
                $TripTemp->staff1 = request('staff')[0];
                $TripTemp->staff2 = request('staff')[1];
                $TripTemp->staff3 = request('staff')[2];
                $TripTemp->advance = request('advance');
                $TripTemp->entry = serialize(request('EntryData'));
                $TripTemp->diesel = serialize(request('DieselData'));
                $TripTemp->rto = serialize(request('RTOData'));
                $TripTemp->pc = serialize(request('PCData'));
                $TripTemp->extraExpense = serialize(request('ExtraExpense'));
                $TripTemp->tollgate = serialize(request('PaalamToll'));
                $TripTemp->driverAdvance = serialize(request('DriverAdvance'));
                $TripTemp->clientid = auth()->user()->id;
                $TripTemp->save();
                return redirect(action('ClientController\MemoController@ViewTempMemo'))->with('success',['Memo Entry','Updated Partially!']);
            }catch (\Exception $e){
                return back()->with('danger','Something went wrong!');
            }
        }
    }


    public function checkEntryAlreadyPresent(){
        if (!empty(request('VehicleId')) && !empty(request('dateFrom')) && !empty(request('dateTo')) ) {
            $Trip = Trip::where([['dateFrom',request('dateFrom')],['dateTo',request('dateTo')],['vehicleId',request('VehicleId')],['clientid',auth()->user()->id]])->first();
            if (!empty($Trip)) {
                return ['status'=>'present','msg'=>'Trip Data Already present'];
            }
            return ['status'=>'not'];
        }else{
            return ['status'=>'not'];
        }
    }

    public function deleteTempMemo($tripId){
        try{
            $TripTemp = $this->TripTemp::findorfail($tripId)->delete();
          return redirect(action('ClientController\MemoController@ViewTempMemo'))->with('success',['Memo Entry','Deleted Successfully!']);
        }catch (\Exception $e){
            return back()->with('danger','Something went wrong!');
        }
    }
}
