<?php

namespace App\Http\Controllers\ClientController;

use App\Customer;
use App\Entry;
use App\StaffsWork;
use App\Trip;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EntryController extends Controller
{
    public function __construct(){
        $this->middleware('client');
    }

    public function add(){
        return view('client.entry.add');
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
            $balance =request('billAmount ')- request('advance');
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
            return view('client.entry.edit',$Data);
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
            $balance =request('billAmount ')- request('advance');
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
}
