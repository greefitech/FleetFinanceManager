<?php

namespace App\Http\Controllers\ClientController;

use App\Customer;
use App\Entry;
use App\Income;
use App\Trip;
use App\Vehicle;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class IncomeController extends Controller
{
    public function IncomeBalanceCustomerList(){
        return view('client.income.incomeBalanceCustomerList');
    }

    public function AddCustomerIncome($CustomerId){
        $Data['Customer'] = Customer::findOrfail($CustomerId);
        $customer = Customer::findOrfail($CustomerId);
        $entryDatas = $customer->customerEntryData->groupBy('id');
        $incomeDatas = $customer->customerIncomeData->groupBy('entryId');
        $vehicledatas = array();
        $total = 0;
        foreach ($entryDatas  as $vehicleEntryId => $entryData){
            $vehicledatas[$vehicleEntryId]['entryAmount'] = $entryData->sum('balance');
        }

        foreach ($incomeDatas  as $vehicleEntryId => $incomeData){
            $vehicledatas[$vehicleEntryId]['incomeAmount'] = $incomeData->sum('recevingAmount');
            $vehicledatas[$vehicleEntryId]['discountAmount'] = $incomeData->sum('discountAmount');
        }
        if (!empty($vehicledatas)) {
            foreach ($vehicledatas as $vehicleEntryId => $vehicledata){
                $vehicleEntry = Entry::findOrfail($vehicleEntryId);
                $vehicle = Vehicle::where('id',$vehicleEntry->vehicleId)->first();
                $trip = Trip::where('id',$vehicleEntry->tripId)->first();
                @$final_data[$vehicleEntryId]['balance'] = @$vehicledata['entryAmount']-@$vehicledata['incomeAmount']-@$vehicledata['discountAmount'];
                @$final_data[$vehicleEntryId]['name'] = $vehicle->vehicleNumber;
                @$final_data[$vehicleEntryId]['Trip'] = $trip;
                @$final_data[$vehicleEntryId]['Entry'] = $vehicleEntry;
                @$total += @$vehicledata['entryAmount']-@$vehicledata['incomeAmount']-@$vehicledata['discountAmount'];
            }
        }
        if (!empty($final_data)) {
            return view('client.income.CustomerIncomeBalanceList',$Data,compact('final_data', 'customer', 'total'));
        }else{
            return redirect('/client/home');
        }
    }
    public function SaveCustomerIncome($customerId){
        $this->validate(request(),[
            'date'=>'required|date',
            'account_id'=>'required',
        ]);

        foreach (request()->income as $vehicleEntryId => $incomeDetail){
            if(!empty($incomeDetail['recevingAmount']) || !empty($incomeDetail['discountAmount'])){
                $vehicleEntry = Entry::findOrfail($vehicleEntryId);
                $vehicleTrip = Trip::findOrfail($vehicleEntry->tripId);
                $income = new Income;
                $income->date = request('date');
                $income->account_id = request('account_id');
                $income->customerId = $customerId;
                $income->clientid= Auth::user()->id;
                $income->vehicleId = $vehicleEntry->vehicleId;
                $income->vehicleId = $vehicleEntry->vehicleId;
                $income->entryId = $vehicleEntryId;
                $income->tripId = $vehicleTrip->id;
                $income->recevingAmount = $incomeDetail['recevingAmount'];
                $income->discountAmount = $incomeDetail['discountAmount'];
                $income->save();
            }
        }
        return redirect(route('client.IncomeBalanceCustomerList'))->with('success',['Income','Added Sucessfully!']);
    }
}
