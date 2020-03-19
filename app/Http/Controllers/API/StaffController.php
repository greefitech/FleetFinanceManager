<?php

namespace App\Http\Controllers\API;

use App\Expense;
use App\StaffsWork;
use App\Trip;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Staff;
use Illuminate\Support\Facades\Auth;
use Validator;


class StaffController extends Controller
{
    public $successStatus = 200;


    /**
     * @SWG\Post(
     *     path="/api/staff/create",
     *     description="Create New Staff",
     *     tags={"Staff"},
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
     *         name="mobile1",
     *         in="query",
     *         type="string",
     *         format="number",
     *         description="Enter Mobile 1",
     *         required=true,
     *     ),
     *     @SWG\Parameter(
     *         name="mobile2",
     *         in="query",
     *         type="string",
     *         format="number",
     *         description="Enter Mobile 2",
     *     ),
     *      @SWG\Parameter(
     *         name="address",
     *         in="query",
     *         type="string",
     *         description="Enter Address",
     *         required=true,
     *     ),
     *     @SWG\Parameter(
     *         name="licenceNumber",
     *         in="query",
     *         type="string",
     *         description="Enter licence Number",
     *         required=true,
     *     ),
     *     @SWG\Parameter(
     *         name="licenceRenewal",
     *         in="query",
     *         type="string",
     *         description="Enter licence Renewal Date [yyyy-mm-dd]",
     *     ),
     *     @SWG\Parameter(
     *         name="type",
     *         in="query",
     *         type="string",
     *         description="Enter Type [manager,driver,cleaner]",
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


    public function store(Request $request){
    	$validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'mobile1' => 'required|max:10|min:10',
            'mobile2' => 'max:10|min:10|different:mobile1',
            'address' => 'required',
            'licenceNumber' => 'required',
            'licenceRenewal' => 'date|date_format:Y-m-d',
            'type' => 'required|in:manager,driver,cleaner',
        ]);
        if ($validator->fails()) {
//            foreach ($validator->errors()->toArray() as $value) {
//                $errData['error'][]=$value[0];
//            }
            $errData['msg'] = 'Please check the data';
            return response()->json($errData, 401);
        }
        $StaffData=Staff::where([['clientid',Auth::user()->id],['mobile1',request('mobile1')]])->first();
        if(!empty($StaffData->mobile1)){
            $errormsg['msg'] = 'Staff Already Exist';
            return response()->json(['status'=>'error','data'=>$errormsg], 401);
        }

    	 try {
            Staff::create([
                'name' => request('name'),
                'mobile1' => request('mobile1'),
                'mobile2' => request('mobile2'),
                'address' => request('address'),
                'licenceNumber' => strtoupper(request('licenceNumber')),
                'licenceRenewal' => request('licenceRenewal'),
                'type' => request('type'),
                'clientid' => auth()->user()->id,
            ]);
            $finalData['msg']='Staff Created Successfully';
            return response()->json(['status'=>'success','data' => $finalData], $this-> successStatus);
        }catch (Exception $e){
             $errormsg['msg'] = 'Error On Insert';
             return response()->json(['status'=>'error','data'=>$errormsg], 401);
        }
    }


    /**
     * @SWG\Get(
     *     path="/api/staffs",
     *     description="Return all Staffs",
     *     tags={"Staff"},
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


    public function index(){
    	$finalData['Staff']=Staff::select('id','name','mobile1','mobile2','address','type','licenceNumber')->where('clientid',auth()->user()->id)->get()->all();
        return response()->json(['status'=>'success','data' => $finalData], $this-> successStatus);
    }

    /**
     * @SWG\Get(
     *     path="/api/staff/{id}/edit",
     *     description="Return particular Staff",
     *     tags={"Staff"},
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


    public function edit($id){
    	try{
            $finalData['staff'] = Staff::findOrfail($id);
            return response()->json(['status'=>'success','data' => $finalData], $this-> successStatus);
        }catch (Exception $e){
            $errormsg['msg'] = 'Something Went Wrong';
            return response()->json(['status'=>'error','data'=>$errormsg], 401);
        }
    }

    /**
     * @SWG\Post(
     *     path="/api/staff/{id}/update",
     *     description="Update New Staff",
     *     tags={"Staff"},
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
     *     @SWG\Parameter(
     *         name="name",
     *         in="query",
     *         type="string",
     *         description="Enter Name",
     *         required=true,
     *     ),
     *     @SWG\Parameter(
     *         name="mobile1",
     *         in="query",
     *         type="string",
     *         format="number",
     *         description="Enter Mobile 1",
     *         required=true,
     *     ),
     *     @SWG\Parameter(
     *         name="mobile2",
     *         in="query",
     *         type="string",
     *         format="number",
     *         description="Enter Mobile 2",
     *     ),
     *      @SWG\Parameter(
     *         name="address",
     *         in="query",
     *         type="string",
     *         description="Enter Address",
     *         required=true,
     *     ),
     *     @SWG\Parameter(
     *         name="licenceNumber",
     *         in="query",
     *         type="string",
     *         description="Enter licence Number",
     *         required=true,
     *     ),
     *     @SWG\Parameter(
     *         name="licenceRenewal",
     *         in="query",
     *         type="string",
     *         description="Enter licence Renewal Date [yyyy-mm-dd]",
     *     ),
     *     @SWG\Parameter(
     *         name="type",
     *         in="query",
     *         type="string",
     *         description="Enter Type [manager,driver,cleaner]",
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



    public function update($id,Request $request){
    	$validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'mobile1' => 'required|max:10|min:10',
            'mobile2' => 'max:10|min:10|different:mobile1',
            'address' => 'required',
            'licenceNumber' => 'required',
            'licenceRenewal' => 'date|date_format:Y-m-d',
            'type' => 'required|in:manager,driver,cleaner',
        ]);
        if ($validator->fails()) {
//            foreach ($validator->errors()->toArray() as $value) {
//                $errData['error'][]=$value[0];
//            }
            $errData['msg'] = 'Please check the data';
            return response()->json($errData, 401);   
        }

        try{
	        $staff = Staff::findOrfail($id);
	        $staff->name = request('name');
	        $staff->mobile1 = request('mobile1');
	        $staff->mobile2 = request('mobile2');
	        $staff->address = request('address');
	        $staff->licenceNumber = request('licenceNumber');
	        $staff->type = request('type');
	        $staff->save();
            $finalData['msg']='Staff Updated Successfully';
            return response()->json(['status'=>'success','data' => $finalData], $this-> successStatus);
         }catch (Exception $e){
            $errormsg['msg'] = 'Something Went Wrong';
            return response()->json(['status'=>'error','data'=>$errormsg], 401);
        }
    }

    /**
     * @SWG\Delete(
     *     path="/api/staff/{id}/delete",
     *     description="Delete Staff Data",
     *     tags={"Staff"},
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

    public function destroy($id){
        $StaffTrip=Trip::where([['staff1',$id]])->orwhere([['staff2',$id]])->orwhere([['staff3',$id]])->count();
        $StaffWorkCount=StaffsWork::where([['staffId',$id]])->count();
        $ExpenseCount=Expense::where([['staffId',$id]])->count();
        if($StaffWorkCount > 0 || $ExpenseCount > 0 || $StaffTrip >0){
            $errormsg['msg'] = 'Something Went Wrong';
            return response()->json(['status'=>'error','data'=>$errormsg], 401);
        }
        try {
            Staff::findOrfail($id)->delete();
            $finalData['msg']='Staff Deleted Successfully';
            return response()->json(['status'=>'success','data' => $finalData], $this-> successStatus);
        } catch (\Illuminate\Database\QueryException $e) {
            $errormsg['msg'] = 'Something Went Wrong';
            return response()->json(['status'=>'error','data'=>$errormsg], 401);
        }  
    }
}
