<?php

namespace App\Http\Controllers\API;

use App\Entry;
use App\Income;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Customer;
use Illuminate\Support\Facades\Auth; 
use Validator;

class CustomerController extends Controller
{
	public $successStatus = 200;


    /**
     * @SWG\Post(
     *     path="/api/customer/create",
     *     description="Create New Customer",
     *     tags={"Customer"},
     *     @swg\Parameter(
     *       in="header",
     *       name="Authorization",
     *       description="",
     *       required=true,
     *       type="string",
     *     ),
     *     @SWG\Parameter(
     *         name="name",
     *         in="query",
     *         type="string",
     *         description="Enter Name",
     *         required=true,
     *     ),
     *     @SWG\Parameter(
     *         name="mobile",
     *         in="query",
     *         type="string",
     *         format="number",
     *         description="Enter Mobile",
     *         required=true,
     *     ),
     *      @SWG\Parameter(
     *         name="address",
     *         in="query",
     *         type="string",
     *         description="Enter Address",
     *         required=true,
     *     ),
     *     @SWG\Parameter(
     *         name="type",
     *         in="query",
     *         type="string",
     *         description="Enter Type [broker,direct]",
     *         required=true,
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="OK",
     *     ),
     *     @SWG\Response(
     *         response=401,
     *         description="Invalid Data"
     *     ),
     *     security={ {"bearer": {}} },
     * )
     */

    public function CreateCustomer(){
        $validator = Validator::make(request()->all(), [
            'name' => 'required',
            'mobile' => 'required|min:10|max:10',
            'address' => 'required',
            'type' => 'required|in:broker,direct',
        ]);

        if ($validator->fails()) {
//            foreach ($validator->errors()->toArray() as $value) {
//                $errData['error'][]=$value[0];
//            }
            $errData['msg'] = 'Please check the data';
            return response()->json($errData, 401);
        }

        // CHECK STAFF MOBILE ALREADY EXITS OR NOT
        $customerData=Customer::where([['clientid', Auth::user()->id],['mobile',request('mobile')]])->first();
        if(!empty($customerData->mobile)){
            $errormsg['msg'] = 'Customer Already Exist';
            return response()->json(['status'=>'error','data'=>$errormsg], 401);
        }
        try {
    	 	Customer::create([
                'name' => request('name'),
                'mobile' => request('mobile'),
                'address' => request('address'),
                'type' => request('type'),
                'clientid' => auth()->user()->id,
            ]);
            $finalData['msg']='Customer Created Successfully';
        	return response()->json(['status'=>'success','data' => $finalData], $this-> successStatus);
        } catch (\Illuminate\Database\QueryException $e) {
            $errormsg['msg'] = 'Error On Insert';
            return response()->json(['status'=>'error','data'=>$errormsg], 401);
        } 
    }



    /**
     * @SWG\Get(
     *     path="/api/customers",
     *     description="Return all Customers",
     *     tags={"Customer"},
     *     @swg\Parameter(
     *       in="header",
     *       name="Authorization",
     *       description="",
     *       required=true,
     *       type="string",
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="OK",
     *     ),
     *     @SWG\Response(
     *         response=401,
     *         description="Invalid Data"
     *     ),
     *     security={ {"bearer": {}} },
     * )
     */


    public function GetCustomers(){
    	$finalData['customers']=Customer::select('id','name','mobile','address','type')->where('clientid',auth()->user()->id)->get();
        return response()->json(['status'=>'success','data' => $finalData], $this-> successStatus);
    }

    /**
     * @SWG\Get(
     *     path="/api/customer/{id}/edit",
     *     description="Return particular Customer",
     *     tags={"Customer"},
     *     @swg\Parameter(
     *       in="header",
     *       name="Authorization",
     *       description="",
     *       required=true,
     *       type="string",
     *     ),
     *      @SWG\Parameter(
     *          name="id",
     *          in="path",
     *          required=true,
     *          type="string"
     *      ),
     *     @SWG\Response(
     *         response=200,
     *         description="OK",
     *     ),
     *     @SWG\Response(
     *         response=401,
     *         description="Invalid Data"
     *     ),
     *     security={ {"bearer": {}} },
     * )
     */

    public function EditCustomers($id){
    	try {
	    	$finalData['customer'] = Customer::findOrfail($id);
            return response()->json(['status'=>'success','data' => $finalData], $this-> successStatus);
    	} catch (\Illuminate\Database\QueryException $e) {
            $errormsg['msg'] = 'Something Went Wrong!!';
            return response()->json(['status'=>'error','data'=>$errormsg], 401);
        } 
    }


    /**
     * @SWG\Post(
     *     path="/api/customer/{id}/update",
     *     description="Update Customer Data",
     *     tags={"Customer"},
     *     @swg\Parameter(
     *       in="header",
     *       name="Authorization",
     *       description="",
     *       required=true,
     *       type="string",
     *     ),
     *     @SWG\Parameter(
     *          name="id",
     *          in="path",
     *          required=true,
     *          type="string"
     *      ),
     *     @SWG\Parameter(
     *         name="name",
     *         in="query",
     *         type="string",
     *         description="Enter Name",
     *         required=true,
     *     ),
     *     @SWG\Parameter(
     *         name="mobile",
     *         in="query",
     *         type="string",
     *         format="number",
     *         description="Enter Mobile",
     *         required=true,
     *     ),
     *      @SWG\Parameter(
     *         name="address",
     *         in="query",
     *         type="string",
     *         description="Enter Address",
     *         required=true,
     *     ),
     *     @SWG\Parameter(
     *         name="type",
     *         in="query",
     *         type="string",
     *         description="Enter Type [broker,direct]",
     *         required=true,
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="OK",
     *     ),
     *     @SWG\Response(
     *         response=401,
     *         description="Invalid Data"
     *     ),
     *     security={ {"bearer": {}} },
     * )
     */

    public function UpdateCustomers($id){
        $validator = Validator::make(request()->all(), [
            'name' => 'required',
            'mobile' => 'required|min:10|max:10',
            'address' => 'required',
            'type' => 'required|in:broker,direct',
        ]);
        if ($validator->fails()) {
//            foreach ($validator->errors()->toArray() as $value) {
//                $errData['error'][]=$value[0];
//            }
            $errData['msg'] = 'Please check the data';
            return response()->json($errData, 401);
        }

        try {
        	$customer = Customer::findOrfail($id);
            $customer->name = request('name');
            $customer->address = request('address');
            $customer->mobile = request('mobile');
            $customer->type = request('type');
            $customer->save();
        	$finalData['msg']='Customer Updated Successfully';
            return response()->json(['status'=>'success','data' => $finalData], $this-> successStatus);
        } catch (\Illuminate\Database\QueryException $e) {
            $errormsg['msg'] = 'Something Went Wrong!!';
            return response()->json(['status'=>'error','data'=>$errormsg], 401);
        } 
    }




    /**
     * @SWG\Delete(
     *     path="/api/customer/{id}/delete",
     *     description="Delete Customer Data",
     *     tags={"Customer"},
     *     @swg\Parameter(
     *       in="header",
     *       name="Authorization",
     *       description="",
     *       required=true,
     *       type="string",
     *     ),
     *     @SWG\Parameter(
     *          name="id",
     *          in="path",
     *          required=true,
     *          type="string"
     *      ),
     *     @SWG\Response(
     *         response=200,
     *         description="OK",
     *     ),
     *     @SWG\Response(
     *         response=401,
     *         description="Invalid Data"
     *     ),
     *     security={ {"bearer": {}} },
     * )
     */


    public function DeleteCustomers($id){
        $EntryCount=Entry::where([['customerId',$id]])->count();
        $IncomeCount=Income::where([['customerId',$id]])->count();
        if($EntryCount>0 ||$IncomeCount>0){
            $errormsg['msg'] = 'Something Went Wrong!!';
            return response()->json(['status'=>'error','data'=>$errormsg], 401);
        }
        try {
            Customer::findOrfail($id)->delete();
        	$finalData['msg']='Customer Deleted Successfully';
            return response()->json(['status'=>'success','data' => $finalData], $this-> successStatus);
        } catch (\Illuminate\Database\QueryException $e) {
            $errormsg['msg'] = 'Something Went Wrong!!';
            return response()->json(['status'=>'error','data'=>$errormsg], 401);
        }   
    }
}
