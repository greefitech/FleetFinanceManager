<?php

namespace App\Http\Controllers\API\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Entry;
use App\Income;
use App\Customer;
use Illuminate\Support\Facades\Auth; 
use Validator;

class CustomerController extends Controller
{
    public $successStatus = 200;
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $customers=Customer::select('id','name','mobile','address','type')->where('clientid',auth()->user()->id)->orderBy('name')->get();
        $customers->map(function($customer) {
            $customerData = $customer;
            $total = ($customerData->customerEntryData->sum('balance')-$customerData->customerIncomeData->sum('recevingAmount')-$customerData->customerIncomeData->sum('discountAmount'));
            $customer->outStandingAmount=$total;

            unset($customer->customerEntryData,$customer->customerIncomeData);
            if (trim($total) != 0) {
                return $customer;
            }
        });
        $success['customers'] = array();
        foreach ($customers as $key => $customer) {
            if ($customer->outStandingAmount !=0) {
                $success['customers'][] = $customer;
            }
        }
        return response()->json(['msg'=>'Customer List','data' => $success], $this->successStatus);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $validator = Validator::make(request()->all(), [
            'name' => 'required',
            'mobile' => 'required|min:10|max:10',
            'address' => 'required',
            'type' => 'required|in:broker,direct',
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->toArray() as $value) {
               $errData[]=$value[0];
            }
            return response()->json(['msg'=>'Please check the data','error'=>$errData], 401);
        }

        // CHECK STAFF MOBILE ALREADY EXITS OR NOT
        $customerData=Customer::where([['clientid', Auth::user()->id],['mobile',request('mobile')]])->first();
        if(!empty($customerData->mobile)){
            return response()->json(['msg'=>'Customer Already Exist'], 401);
        }
        try {
            Customer::create([
                'name' => request('name'),
                'mobile' => request('mobile'),
                'address' => request('address'),
                'type' => request('type'),
                'clientid' => auth()->user()->id,
            ]);
            return response()->json(['msg'=>'Customer Created Successfully'], $this->successStatus);
        }catch (Exception $e){
            return response()->json(['msg'=>'Error On Insert'], 401);
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
        try {
            $success['customer']=Customer::select('id','name','mobile','address','type')->findorfail($id);
            return response()->json(['msg'=>'Customer List','data' => $success], $this->successStatus);
        }catch (Exception $e){
            return response()->json(['msg'=>'Something went wrong!!'], 401);
        } 
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
            $success['customer']=Customer::select('id','name','mobile','address','type')->findorfail($id);
            return response()->json(['msg'=>'Customer List','data' => $success], $this->successStatus);
        }catch (Exception $e){
            return response()->json(['msg'=>'Something went wrong!!'], 401);
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
        $validator = Validator::make(request()->all(), [
            'name' => 'required',
            'mobile' => 'required|min:10|max:10',
            'address' => 'required',
            'type' => 'required|in:broker,direct',
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->toArray() as $value) {
               $errData[]=$value[0];
            }
            return response()->json(['msg'=>'Please check the data','error'=>$errData], 401);
        }
        try {
            $customer = Customer::findOrfail($id);
            $customer->name = request('name');
            $customer->address = request('address');
            $customer->mobile = request('mobile');
            $customer->type = request('type');
            $customer->save();
            return response()->json(['msg'=>'Customer Updated Successfully'], $this->successStatus);
        }catch (Exception $e){
            return response()->json(['msg'=>'Error On Update'], 401);
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
        $EntryCount=Entry::where([['customerId',$id]])->count();
        $IncomeCount=Income::where([['customerId',$id]])->count();
        if($EntryCount>0 ||$IncomeCount>0){
            $errormsg['msg'] = 'Something Went Wrong!!';
            return response()->json(['status'=>'error','data'=>$errormsg], 401);
        }
        try {
            Customer::findOrfail($id)->delete();
            return response()->json(['msg'=>'Customer Deleted Successfully!'], $this->successStatus);
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json(['msg'=>'Error On Delete!'], 401);
        }  
    }

     public function ListAllCustomerList() {
        $success=Customer::select('id','name','mobile','address','type')->where('clientid',auth()->user()->id)->orderBy('name')->paginate(10);
        return response()->json(['msg'=>'All Customer List','data' => $success], $this->successStatus);
    }

    public function CustomerIncomePaymentList($id){
        if (isset($_GET['page'])) 
            $page = $_GET['page'];
        else
            $page = 1;
        $EntryArray = array('dateFrom as date','id','vehicleId','advance as amount','tripId','account_id');
        $IncomeArray = array('date','id','vehicleId','recevingAmount as amount','tripId','account_id');

        $Entry = collect(Entry::select($EntryArray)->with('Trip','vehicle','Account')->where([['customerId',$id]])->whereNotNull('advance')->get());
        $income = collect(Income::select($IncomeArray)->with('Trip','vehicle','Account')->where([['customerId',$id]])->whereNotNull('recevingAmount')->get());
        $merged = $Entry->merge($income)->sortByDesc('date')->forPage($page,10)->values();
        return response()->json(['msg'=>'Income List','data' => $merged], $this->successStatus);
    }
}
