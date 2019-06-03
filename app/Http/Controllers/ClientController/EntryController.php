<?php

namespace App\Http\Controllers\ClientController;

use App\Customer;
use App\Entry;
use App\StaffsWork;
use App\Trip;
use App\Vehicle;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EntryController extends Controller
{
    public function __construct(){
        $this->middleware('client');
    }

    public function add(){
        return view('client.trip.entry.add');
    }

    public function save(){
        $this->validate(request(),[
            'dateFrom'=>'required|date',
            'vehicleId'=>'required|exists:vehicles,id',
            'customerId'=>'nullable|exists:customers,id',
            'customerMobile'=>'required_without:customerId',
            'customerName'=>'required_without:customerId',
            'type'=>'required_without:customerId',
            'staff.0'=>'required_unless:staff,[]',
            'locationFrom'=>'required',
            'locationTo'=>'required',
            'loadType'=>'required',
            'tripId'=>'required|exists:trips,id',
            'billAmount'=>'required',
        ]);

        $Trip= Trip::findOrfail(request('tripId'));
        if($Trip->vehicleId != request('vehicleId')){
            return back()->with('sorry','Vehicle Trip and Vehicle Not Matched !!')->withInput();
        }
        try {
            $entry = new Entry;
            $entry->dateFrom=request()->dateFrom;
            $entry->vehicleId=request()->vehicleId;

            if(!empty(request()->customerId)){
                $entry->customerId=request()->customerId;
            }else{
                $CustomerData=Customer::where([['clientid',auth()->user()->id],['mobile',request('customerMobile')]])->first();
                if(!empty($CustomerData->mobile)){
                    $entry->customerId=$CustomerData->id;
                }else{
                    $customer = new Customer;
                    $customer->name = request('customerName');
                    $customer->mobile = request('customerMobile');
                    $customer->type = request('type');
                    $customer->clientid=auth()->user()->id;
                    $customer->save();
                    $entry->customerId=$customer->id;
                }
            }
            $entry->startKm=request('startKm');
            $entry->endKm=request('endKm');
            $entry->total=request('endKm')-request('startKm');
            $entry->locationFrom=request('locationFrom');
            $entry->locationTo=request('locationTo');
            $entry->loadType=request('loadType');
            $entry->ton=request('ton');
            $entry->billAmount=request('billAmount');
            $entry->advance=request('advance');
            $entry->driverPadi=request('driverPadi');
            $entry->cleanerPadi=request('cleanerPadi');
            $entry->driverPadiAmount=round((request('billAmount')* request('driverPadi')) / 100);
            $entry->cleanerPadiAmount=round((request('billAmount')* request('cleanerPadi')) / 100);
            $entry->comission= round(request('comission'));
            $entry->loadingMamool=request('loadingMamool');
            $entry->unLoadingMamool=request('unLoadingMamool');
            $balance =request('billAmount')- request('advance');
            $entry->balance=round($balance);
            $entry->account_id=request('account_id');
            $entry->tripId=request('tripId');
            $entry->clientid=auth()->user()->id;
            $entry->save();
            return back()->with('success',['Entry','Added Successfully!']);
        }catch (Exception $e){
            return back()->with('danger','Something went wrong!');
        }
    }

    public function edit($id){
        try {
            $Data['Entry'] = Entry::findOrfail($id);
            $Data['Trip'] = Trip::findorfail($Data['Entry']->tripId);
            return view('client.trip.entry.edit',$Data);
        }catch (Exception $e){
            return back()->with('danger','Something went wrong!');
        }
    }

    public function update($id){
        $this->validate(request(),[
            'dateFrom'=>'required|date',
            'vehicleId'=>'required|exists:vehicles,id',
            'customerId'=>'nullable|exists:customers,id',
            'customerMobile'=>'required_without:customerId',
            'customerName'=>'required_without:customerId',
            'type'=>'required_without:customerId',
            'staff.0'=>'required_unless:staff,[]',
            'locationFrom'=>'required',
            'locationTo'=>'required',
            'loadType'=>'required',
            'tripId'=>'required|exists:trips,id',
            'billAmount'=>'required',
        ]);

        $Trip= Trip::findOrfail(request('tripId'));
        if($Trip->vehicleId != request('vehicleId')){
            return back()->with('sorry','Vehicle Trip and Vehicle Not Matched !!')->withInput();
        }
        try {
            $entry = Entry::findorfail($id);
            $entry->dateFrom=request()->dateFrom;
            $entry->vehicleId=request()->vehicleId;

            if(!empty(request()->customerId)){
                $entry->customerId=request()->customerId;
            }else{
                $CustomerData=Customer::where([['clientid',auth()->user()->id],['mobile',request('customerMobile')]])->first();
                if(!empty($CustomerData->mobile)){
                    $entry->customerId=$CustomerData->id;
                }else{
                    $customer = new Customer;
                    $customer->name = request('customerName');
                    $customer->mobile = request('customerMobile');
                    $customer->type = request('type');
                    $customer->clientid=auth()->user()->id;
                    $customer->save();
                    $entry->customerId=$customer->id;
                }
            }
            $entry->startKm=request('startKm');
            $entry->endKm=request('endKm');
            $entry->total=request('endKm')-request('startKm');
            $entry->locationFrom=request('locationFrom');
            $entry->locationTo=request('locationTo');
            $entry->loadType=request('loadType');
            $entry->ton=request('ton');
            $entry->billAmount=request('billAmount');
            $entry->advance=request('advance');
            $entry->driverPadi=request('driverPadi');
            $entry->cleanerPadi=request('cleanerPadi');
            $entry->driverPadiAmount=round((request('billAmount')* request('driverPadi')) / 100);
            $entry->cleanerPadiAmount=round((request('billAmount')* request('cleanerPadi')) / 100);
            $entry->comission= round(request('comission'));
            $entry->loadingMamool=request('loadingMamool');
            $entry->unLoadingMamool=request('unLoadingMamool');
            $balance =request('billAmount')- request('advance');
            $entry->balance=round($balance);
            $entry->account_id=request('account_id');
            $entry->tripId=request('tripId');
            $entry->clientid=auth()->user()->id;
            $entry->save();
            return redirect(route('client.ViewTripEntryList',request('tripId')))->with('success',['Entry','Updated Successfully!']);
        }catch (Exception $e){
            return back()->with('danger','Something went wrong!');
        }
    }

    public function delete($id){
        $StaffsWork= StaffsWork::where('entryId',$id)->get();
        try {
            foreach ($StaffsWork as $key => $value) {
                StaffsWork::find($value->id)->delete();
            }
            $Entry = Entry::findOrfail($id);
            $Entry->delete();
            return redirect(route('client.ViewTripEntryList',$Entry->tripId))->with('success',['Entry','Deleted Successfully!']);
        }catch (Exception $e){
            return back()->with('danger','Something went wrong!');
        }
    }

    public function memo(){
        return view('client.trip.memo');
    }







    public function SaveMemo(){
//        $this->validate(request(),[
//            'vehicleId'=>'required|exists:vehicles,id',
//            'dateFrom'=>'required|date',
//            'dateTo'=>'required|date|after_or_equal:dateFrom',
//            'advance'=>'nullable|numeric|min:0',
//            'startKm'=>'required|numeric|min:0',
//            'endKm'=>'required|numeric|min:'.(int)request('startKm'),
//            'staff.0' => 'required|exists:staff,id',
//            'staff.1' => 'nullable|exists:staff,id',
//            'staff.2' => 'nullable|exists:staff,id',
//        ],
//        [
//            'staff.0.required'=>'Any One Staff Is needed.Select any one staff'
//        ]);


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

                $EntryValidator['EntryData.driverPadi.'.$EntryDataKey] = 'nullable|numeric|min:0|max:100|between:0,99.99';
                $EntryValidator['EntryData.cleanerPadi.'.$EntryDataKey] = 'nullable|numeric|min:0|max:100|between:0,99.99';

                $EntryValidator['EntryData.driverPadiAmount.'.$EntryDataKey] = 'nullable|numeric|min:0|max:100|between:0,99.99';
                $EntryValidator['EntryData.cleanerPadiAmount.'.$EntryDataKey] = 'nullable|numeric|min:0|max:100|between:0,99.99';

                $EntryValidator['EntryData.commission_status.'.$EntryDataKey] = 'required';
                $EntryValidator['EntryData.loading_mamool_status.'.$EntryDataKey] = 'required';
                $EntryValidator['EntryData.unloading_mamool_status.'.$EntryDataKey] = 'required';
//
                $EntryValidator['EntryData.loadingMamool.'.$EntryDataKey] = 'nullable|min:0|numeric';
                $EntryValidator['EntryData.unLoadingMamool.'.$EntryDataKey] = 'nullable|min:0|numeric';
            }
            $this->validate(request(), $EntryValidator);
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
         * Diesel validator
         * */
        if(!empty(request('DieselData'))){
            $DieselValidator=[];
            foreach(request('DieselData')['amount'] as $DieselDataKey=>$paall){
                $DieselValidator['DieselData.account_id.'.$DieselDataKey] = 'required';
                $DieselValidator['DieselData.date.'.$DieselDataKey] = 'required|date|after_or_equal:.'.request('dateFrom').'|before_or_equal:.'.request('dateTo');
                $DieselValidator['DieselData.quantity.'.$DieselDataKey] = 'required|min:1|numeric|between:1,99.99';
                $DieselValidator['DieselData.amount.'.$DieselDataKey] = 'required|min:0|numeric';
                $DieselValidator1['DieselData.amount.'.$DieselDataKey.'.required'] = 'The Diesel Amount Field is required';
            }
            $this->validate(request(), $DieselValidator,$DieselValidator1);
        }


        dd(request()->all());
    }
}
