<?php

namespace App\Http\Controllers\API\Income;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Customer;
use App\Entry;
use App\Vehicle;
use App\Trip;
use App\Income;
use Illuminate\Support\Facades\Auth;

class IncomeBalanceController extends Controller
{

    public $successStatus =200;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
        $this->validate(request(),[
            'date'=>'required|date',
            'account_id'=>'required',
        ]);
        // return request()->all();
        if (!empty(json_decode(request('income_datas'),true))) {
            foreach (json_decode(request('income_datas'),true) as $vehicleEntryId => $incomeDetail){
                if(!empty(trim($incomeDetail['recevingAmount'])) || !empty(trim($incomeDetail['discountAmount']))) {
                    $vehicleEntry = Entry::findOrfail($incomeDetail['entry_id']);
                    $vehicleTrip = Trip::findOrfail($vehicleEntry->tripId);
                    $income = new Income;
                    $income->date = request('date');
                    $income->account_id = request('account_id');
                    $income->customerId = request('customer_id');
                    $income->clientid= Auth::user()->id;
                    $income->vehicleId = $vehicleEntry->vehicleId;
                    $income->entryId = $incomeDetail['entry_id'];
                    $income->tripId = $vehicleTrip->id;
                    $income->recevingAmount =(trim($incomeDetail['recevingAmount']) == '' || (trim($incomeDetail['recevingAmount']) <=0)) ?0: $incomeDetail['recevingAmount'];
                    $income->discountAmount =(trim($incomeDetail['discountAmount']) == '' || (trim($incomeDetail['discountAmount']) <=0)) ?0: $incomeDetail['discountAmount'];
                    $income->save();
                }
            }
        }
        return response()->json(['msg'=>'Income Added Successfully'], $this->successStatus);
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
        //
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
        //
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


    public function CustomerBalance($CustomerId){
        try {
            $success['Customer'] = Customer::findOrfail($CustomerId);
            $customer = Customer::findOrfail($CustomerId);
            $entryDatas = $customer->customerEntryData->groupBy('id');
            $incomeDatas = $customer->customerIncomeData->groupBy('entryId');
            $vehicledatas = array();
            $FinalDataArray = array();
            $total = 0;
            foreach ($entryDatas as $vehicleEntryId => $entryData) {
                $vehicledatas[$vehicleEntryId]['entryAmount'] = $entryData->sum('balance');
            }

            foreach ($incomeDatas as $vehicleEntryId => $incomeData) {
                $vehicledatas[$vehicleEntryId]['incomeAmount'] = $incomeData->sum('recevingAmount');
                $vehicledatas[$vehicleEntryId]['discountAmount'] = $incomeData->sum('discountAmount');
            }
            if (!empty($vehicledatas)) {
                foreach ($vehicledatas as $vehicleEntryId => $vehicledata) {
                    $vehicleEntry = Entry::findOrfail($vehicleEntryId);
                    $vehicle = Vehicle::where('id', $vehicleEntry->vehicleId)->first();
                    $trip = Trip::where('id', $vehicleEntry->tripId)->first();
                    @$FinalDataArray[$vehicleEntryId]['balance'] = @$vehicledata['entryAmount'] - @$vehicledata['incomeAmount'] - @$vehicledata['discountAmount'];
                    @$FinalDataArray[$vehicleEntryId]['vehicle_name'] = $vehicle->vehicleNumber;
                    @$FinalDataArray[$vehicleEntryId]['EntryDetail'] = $vehicleEntry->locationFrom.' - '.$vehicleEntry->locationTo.' '.date("d-m-Y", strtotime($trip->dateFrom));
                    // @$FinalDataArray[$vehicleEntryId]['TripName'] = $trip;
                    // @$FinalDataArray[$vehicleEntryId]['Entry'] = $vehicleEntry;
                    @$total += @$vehicledata['entryAmount'] - @$vehicledata['incomeAmount'] - @$vehicledata['discountAmount'];
                }
            }
            $success['balance'] = $total;
            $success['income']=array();
            foreach ($FinalDataArray as $key => $FinalData) {
                if ($FinalData['balance'] != 0 ) {
                     $income=array();
                    $income['entry_id'] = $key;
                    $income['balance'] =$FinalData['balance'];
                    $income['vehicle_name'] = $FinalData['vehicle_name'];
                    $income['EntryDetail'] = $FinalData['EntryDetail'];
                    $success['income'][] = $income;
                }
            }
        // return $FinalDataArray;
        // return $success;
            return response()->json(['data'=>$success], $this->successStatus);
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json(['msg'=>'Error On Insert'], 401);
        } 
    }
}
