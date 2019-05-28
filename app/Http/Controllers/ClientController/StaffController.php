<?php

namespace App\Http\Controllers\ClientController;

use App\Expense;
use App\Helpers\Helper;
use App\Staff;
use App\StaffsWork;
use App\Trip;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class StaffController extends Controller
{
    public function __construct(){
        $this->middleware('client');
        $this->Staff = new Staff;
        $this->Helper = new Helper;
    }


    public function view(){
        $Data['Helper'] = $this->Helper;
        return view('client.master.staff.view',$Data);
    }

    public function add(){
        return view('client.master.staff.add');
    }

    public function save(){
        $this->validate(request(),[
            'name'=>'required',
            'mobile1'=>'required|regex:/[0-9]{10}/',
            'mobile2'=>'nullable|regex:/[0-9]{10}/',
            'address'=>'required',
            'licenceNumber'=>'required',
            'type'=>'required|in:cleaner,driver,manager',
        ]);
        $StaffData = $this->Staff::where([['clientid',Auth::user()->id],['mobile1',request('mobile1')]])->first();
        if(!empty($StaffData->mobile1)){
            return back()->with('sorry','Staff Already Added!!')->withInput();
        }
        try {
            $this->Staff::create([
                'name' => request('name'),
                'mobile1' => request('mobile1'),
                'mobile2' => request('mobile2'),
                'address' => request('address'),
                'licenceNumber' => strtoupper(request('licenceNumber')),
                'licenceRenewal' => request('licenceRenewal'),
                'type' => request('type'),
                'clientid' => auth()->user()->id,
            ]);
            return redirect(route('client.ViewStaffs'))->with('success',['Staff','Created Successfully']);
        }catch (Exception $e){
            return back()->with('danger','Something went wrong!');
        }
    }

    public function edit($id){
        try{
            $Data['staff'] = $this->Staff::findOrfail($id);
            return view('client.master.staff.edit',$Data);
        }catch (Exception $e){
            return back()->with('danger','Something went wrong!');
        }
    }

    public function update($id){
        $this->validate(request(),[
            'name'=>'required',
            'mobile1'=>'required|regex:/[0-9]{10}/',
            'mobile2'=>'nullable|regex:/[0-9]{10}/',
            'address'=>'required',
            'licenceNumber'=>'required',
            'type'=>'required|in:cleaner,driver,manager',
        ]);
        $StaffData = $this->Staff::where([['clientid',Auth::user()->id],['id','!=',$id],['mobile1',request('mobile1')]])->get();
        if($StaffData->count() > 0){
            return back()->with('sorry','Staff Already Added!!')->withInput();
        }
        try {
            $staff = $this->Staff::findOrfail($id);
            $staff->name = request('name');
            $staff->mobile1 = request('mobile1');
            $staff->mobile2 = request('mobile2');
            $staff->address = request('address');
            $staff->licenceNumber = strtoupper(request('licenceNumber'));
            $staff->licenceRenewal = request('licenceRenewal');
            $staff->type = request('type');
            $staff->save();
            return redirect(route('client.ViewStaffs'))->with('success',['Staff','Updated Successfully']);
        }catch (Exception $e){
            return back()->with('danger','Something went wrong!');
        }
    }

    public function delete($id){
        $StaffTrip=Trip::where([['staff1',$id]])->orwhere([['staff2',$id]])->orwhere([['staff3',$id]])->count();
        $StaffWorkCount=StaffsWork::where([['staffId',$id]])->count();
        $ExpenseCount=Expense::where([['staffId',$id]])->count();
        if($StaffWorkCount > 0 || $ExpenseCount > 0 || $StaffTrip >0){
            return back()->with('sorry','Something went wrong! Delete Staff Cause Some Data Loss! Contact Admin!');
        }

        try {
            $this->Staff::findOrfail($id)->delete();
            return redirect(route('client.ViewStaffs'))->with('success',['Staff','Deleted Successfully']);
        } catch (\Illuminate\Database\QueryException $e) {
            return back()->with('danger','Something went wrong! Delete Not Allowed!');
        }
    }
}