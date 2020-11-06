<?php

namespace App\Http\Controllers\API\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Expense;
use App\StaffsWork;
use App\Trip;
use App\Staff;
use Illuminate\Support\Facades\Auth;
use Validator;


class StaffController extends Controller
{

    public $successStatus = 200;

    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        $success['staffs']=Staff::select('id','name','mobile1','mobile2','address','type','licenceNumber')->where([['clientid',auth()->user()->id]])->get();
        return response()->json(['msg'=>'Staffs List','data' => $success], $this->successStatus);
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
    public function store(Request $request)
    {
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
           foreach ($validator->errors()->toArray() as $value) {
               $errData['error'][]=$value[0];
           }
            $errData['msg'] = 'Please check the data';
            return response()->json($errData, 401);
        }
        $StaffData=Staff::where([['clientid',Auth::user()->id],['mobile1',request('mobile1')]])->first();
        if(!empty($StaffData->mobile1)){
            return response()->json(['msg'=>'Staff Already Exist','data'=>$errormsg], 401);
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
            return response()->json(['msg'=>'Staff Created Successfully'], $this->successStatus);
        }catch (\Exception $e){
             $errormsg['msg'] = 'Error On Insert';
             return response()->json(['msg'=>'Error On Insert','data'=>$errormsg], 401);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id){
        try{
            $success['staff'] = Staff::findOrfail($id);
            return response()->json(['msg'=>'Staff List','data' => $success], $this-> successStatus);
        }catch (\Exception $e){
            return response()->json(['msg'=>'Something Went Wrong'], 401);
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
}
