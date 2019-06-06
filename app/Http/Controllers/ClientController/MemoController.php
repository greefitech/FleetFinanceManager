<?php

namespace App\Http\Controllers\ClientController;

use App\Entry;
use App\Expense;
use App\RTOMaster;
use App\Trip;
use App\Vehicle;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MemoController extends Controller
{

     public function __construct(){
        $this->middleware('client');
        $this->Trip = new Trip;
        $this->RTOMaster = new RTOMaster;
    }

    public function memo(){
        $Data['RTOMasters'] = $this->RTOMaster::where([['clientid',auth()->user()->id]])->get();
        return view('client.trip.memo',$Data);
    }


    public function SaveMemo(){
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
            if($vehicle->vehicleLastKm < request('Trip')['endKm']){
                $vehicle->vehicleLastKm = request('Trip')['endKm'];
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
                    $Expense->quantity = request('DieselData')['quantity'][$DieselDataKey];
                    $Expense->amount = request('DieselData')['amount'][$DieselDataKey];
                    $Expense->status = request('DieselData')['status'][$DieselDataKey];
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
            return back()->with('success',['Memo Entry','Added Successfully!']);
        }catch (Exception $e){
            return back()->with('danger','Something went wrong!');
        }

    }
}
