<?php

namespace App\Http\Controllers\ClientController;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

use App\Expense;
use App\ExpenseType;
use App\Trip;
use App\Vehicle;
use DB;
use App\Vendor;


class ExpenseController extends Controller
{
    public function __construct(){
        $this->middleware('client');
        $this->ExpenseType = new ExpenseType;
        $this->Expense = new Expense;
        $this->Trip = new Trip;
        $this->Vehicle = new Vehicle;
        $this->Vendor = new Vendor;
    }

    public function add(){
        $Data['ExpenseTypes'] =  $this->ExpenseType::where('clientid',auth()->user()->id)->orWhereNull('clientid')->limit(10)->get();
        $Data['Vendors'] =  $this->Vendor::where('clientid',auth()->user()->id)->get();
        return view('client.trip.expense.add',$Data);
    }

    public function save(){
        $this->validate(request(),[
            'date'=>'required|date|after:'.date('2010-01-01'),
            'vehicleId'=>'required|exists:vehicles,id',
            // 'total_amount'=>'required',
            'amount'=>'required',
            'expense_type'=>'required|exists:expense_types,id',
            'staffId'=>'required_if:type,==,1',
            'quantity'=>'required_if:type,==,2',
            'tripId'=>'required|exists:trips,id|required_if:type,==,2|required_if:type,==,1',
        ]);
        if (!empty(request('tripId'))) {
            $Trip =  $this->Trip::findOrfail(request('tripId'));
            if ($Trip->vehicleId != request('vehicleId')) {
                return back()->with('sorry', 'Vehicle Trip and Vehicle Not Matched !!')->withInput();
            }
            $this->validate(request(),[
                'date'=>'required|date|after_or_equal:.'.$Trip->dateFrom.'|before_or_equal:.'.$Trip->dateTo,
            ],[
                'date.after_or_equal'=>'Check Date With Trip',
                'date.before_or_equal'=>'Check Date With Trip',
            ]);
        }
        try {
            $Expense = $this->Expense;
            $Expense->date = request('date');
            $Expense->expense_type = request('expense_type');
            $Expense->vehicleId = request('vehicleId');
            $Expense->staffId = request('staffId');
            $Expense->quantity = request('quantity');
            $Expense->amount = request('amount');
            $Expense->discription = request('discription');
            $Expense->location = request('location');
            $Expense->status = request('status');
            $Expense->account_id = request('account_id');
            $Expense->tripId = request('tripId');
            $Expense->paid_status = request('status');
            // $Expense->total_amount = request('total_amount');
            $Expense->vendor_id = request('vendor_id');
            $Expense->clientid = auth()->user()->id;
            if($request->file('image')){
                $file = $request->file('image');
                $imageName = hash('sha256', strval(time())).'.'.$request->image->getClientOriginalExtension();
                $destinationPath = config('mohan.uploads.expense_document').'/'.auth()->user()->id.'/'. request('vehicleId').'/';
                $file->move($destinationPath,$imageName);
                $Expense->image =$destinationPath.$imageName;
            }
            $Expense->save();

            return back()->with('success',['Expense','Added Successfully!'])->withInput();
         }catch (\Exception $e){
            return back()->with('danger', 'Something went wrong!');
        }
    }

    public function edit($id){
        try {
            $Data['ExpenseTypes'] =  $this->ExpenseType::where('clientid',auth()->user()->id)->orWhereNull('clientid')->get();
            $Data['Expense'] = $this->Expense::findorfail($id);
            $Data['Trips'] = $this->Trip::findorfail($Data['Expense']->tripId);
            $Data['Vendors'] =  $this->Vendor::where('clientid',auth()->user()->id)->get();
            return view('client.trip.expense.edit',$Data);
        }catch (\Exception $e){
            return back()->with('danger', 'Something went wrong!');
        }
    }

    public function update($id){
        $this->validate(request(),[
            'date'=>'required|date|after:'.date('2010-01-01'),
            'vehicleId'=>'required|exists:vehicles,id',
            'amount'=>'required',
            // 'total_amount'=>'required',
            'expense_type'=>'required|exists:expense_types,id',
            'staffId'=>'required_if:type,==,1',
            'quantity'=>'required_if:type,==,2',
            'tripId'=>'required|exists:trips,id|required_if:type,==,2|required_if:type,==,1',
        ]);
        if (!empty(request('tripId'))) {
            $Trip =  $this->Trip::findOrfail(request('tripId'));
            if ($Trip->vehicleId != request('vehicleId')) {
                return back()->with('sorry', 'Vehicle Trip and Vehicle Not Matched !!')->withInput();
            }
            $this->validate(request(),[
                'date'=>'required|date|after_or_equal:.'.$Trip->dateFrom.'|before_or_equal:.'.$Trip->dateTo,
            ],[
                'date.after_or_equal'=>'Check Date With Trip',
                'date.before_or_equal'=>'Check Date With Trip',
            ]);
        }
        try {
            $Expense = $this->Expense::findorfail($id);
            $Expense->date = request('date');
            $Expense->expense_type = request('expense_type');
            $Expense->vehicleId = request('vehicleId');
            $Expense->staffId = request('staffId');
            $Expense->quantity = request('quantity');
            $Expense->amount = request('amount');
            $Expense->discription = request('discription');
            $Expense->location = request('location');
            $Expense->status = request('status');
            $Expense->account_id = request('account_id');
            $Expense->tripId = request('tripId');
            $Expense->paid_status = request('status');
            // $Expense->total_amount = request('total_amount');
            $Expense->vendor_id = request('vendor_id');
            if($request->file('image')){
                $file = $request->file('image');
                $imageName = hash('sha256', strval(time())).'.'.$request->image->getClientOriginalExtension();
                $destinationPath = config('mohan.uploads.expense_document').'/'.auth()->user()->id.'/'. request('vehicleId').'/';
                $file->move($destinationPath,$imageName);
                $Expense->image =$destinationPath.$imageName;
            }
            $Expense->save();
            return back()->with('success',['Expense','Updated Successfully!'])->withInput();
         }catch (\Exception $e){
            return back()->with('danger', 'Something went wrong!');
        }
    }

    public function delete($id){
        try {
            $this->Expense::findOrfail($id)->delete();
            return back()->with('success', ['Expense', 'Deleted Successfully!']);
        }catch (\Exception $e){
            return back()->with('danger', 'Something went wrong! Delete Not Allowed!');
        }
    }

    public function GetLastExpenseTypeDetail(){
        $Expense= $this->Expense::where([['clientid', auth()->user()->id],['vehicleId', request('vehicleID')],['expense_type', request('ExpenseType')]])->orderBy('date', 'DESC')->first();
            return '        Date : '.date('d-m-Y', strtotime(@$Expense->date)).'
        Quantity : '.@$Expense->quantity.'
        Amount : '.@$Expense->amount.'
        Discription : '.@$Expense->discription;
    }

    /*=========================================
         NON Trip Expense List
     =========================================*/

    public function ExpenseVehcleListNonTrip(){
        if (request()->ajax()) {
            $NonTrips =  $this->Vehicle::where('clientid',auth()->user()->id);
            return DataTables::of($NonTrips)
            ->addColumn('action',
                '<a href="{{ action(\'ClientController\ExpenseController@NonTripVehicleExpenseList\',[$id]) }}" class="btn btn-md" data-toggle="tooltip" data-placement="right"><i class="fa fa-eye"></i></a>'
            )
            ->rawColumns(['action'])->make(true);
        }
        return view('client.trip.expense.LorryList');
    }

    public function NonTripVehicleExpenseList($VehicleId){
        try {
            $Data['Vehicle'] = Vehicle::findorfail($VehicleId);
            $Data['Expenses'] = $this->Expense::where([['clientid', auth()->user()->id], ['vehicleId', $VehicleId]])->where('tripId', NULL)->orderBy('date', 'DESC')->get();
            return view('client.trip.expense.view-non-trip-expense',$Data);
         }catch (\Exception $e){
            return back()->with('danger', 'Something went wrong!');
        }
    }


     public function CreateNonTripExpense(){
        $Data['ExpenseTypes'] =  $this->ExpenseType::where('clientid',auth()->user()->id)->orWhereNull('clientid')->get();
        $Data['Vendors'] =  $this->Vendor::where('clientid',auth()->user()->id)->get();
        return view('client.trip.expense.nontrip.add',$Data);
    }


     public function SaveNonTripExpense(Request $request){
        $this->validate(request(),[
            'date'=>'required|date|after:'.date('2010-01-01'),
            'vehicleId'=>'required|exists:vehicles,id',
            // 'total_amount'=>'required',
            'amount'=>'required',
            'expense_type'=>'required|exists:expense_types,id',
            'staffId'=>'required_if:type,==,1',
            'quantity'=>'required_if:type,==,2',
        ]);
        try {
            $Expense = $this->Expense();
            $Expense->date = request('date');
            $Expense->expense_type = request('expense_type');
            $Expense->vehicleId = request('vehicleId');
            $Expense->staffId = request('staffId');
            $Expense->quantity = request('quantity');
            // $Expense->total_amount = request('total_amount');
            $Expense->amount = request('amount');
            $Expense->discription = request('discription');
            $Expense->location = request('location');
            $Expense->status = request('status');
            $Expense->account_id = request('account_id');
            $Expense->vendor_id = request('vendor_id');
            $Expense->clientid = auth()->user()->id;
            if (request('status') ==0) {
                $Expense->paid_status = request('status');
            }else {
                $Expense->paid_status = request('status');
            }
            if($request->file('image')){
                $file = $request->file('image');
                $imageName = hash('sha256', strval(time())).'.'.$request->image->getClientOriginalExtension();
                $destinationPath = config('mohan.uploads.expense_document').'/'.auth()->user()->id.'/'. request('vehicleId').'/';
                $file->move($destinationPath,$imageName);
                $Expense->image =$destinationPath.$imageName;
            }
            $Expense->save();
            return back()->with('success',['Expense','Added Successfully!'])->withInput();
         }catch (\Exception $e){
            return back()->with('danger', 'Something went wrong!');
        }
    }

     public function EditNonTripExpense($id){
        try {
            $Data['ExpenseTypes'] =  $this->ExpenseType::where('clientid',auth()->user()->id)->orWhereNull('clientid')->get();
            $Data['Expense'] = $this->Expense::findorfail($id);
            $Data['Vendors'] =  $this->Vendor::where('clientid',auth()->user()->id)->get();
            return view('client.trip.expense.nontrip.edit',$Data);
        }catch (\Exception $e){
            return back()->with('danger', 'Something went wrong!');
        }
    }

    public function UpdateNonTripExpense(Request $request,$id){
        $this->validate(request(),[
            'date'=>'required|date|after:'.date('2010-01-01'),
            'vehicleId'=>'required|exists:vehicles,id',
            'amount'=>'required',
            // 'total_amount'=>'required',
            'expense_type'=>'required|exists:expense_types,id',
            'staffId'=>'required_if:type,==,1',
            'quantity'=>'required_if:type,==,2',
        ]);
        try {
            $Expense = $this->Expense->findorfail($id);
            $Expense->date = request('date');
            $Expense->expense_type = request('expense_type');
            $Expense->vehicleId = request('vehicleId');
            $Expense->staffId = request('staffId');
            $Expense->quantity = request('quantity');
            // $Expense->total_amount = request('total_amount');
            $Expense->amount = request('amount');
            $Expense->discription = request('discription');
            $Expense->location = request('location');
            $Expense->status = request('status');
            $Expense->account_id = request('account_id');
            $Expense->vendor_id = request('vendor_id');
            $Expense->paid_status = request('status');
            if($request->file('image')){
                $file = $request->file('image');
                $imageName = hash('sha256', strval(time())).'.'.$request->image->getClientOriginalExtension();
                $destinationPath = config('mohan.uploads.expense_document').'/'.auth()->user()->id.'/'. request('vehicleId').'/';
                $file->move($destinationPath,$imageName);
                $Expense->image =$destinationPath.$imageName;
            }
            $Expense->save();
            return back()->with('success',['Expense','Updated Successfully!'])->withInput();
        }catch (\Exception $e){
            return back()->with('danger', 'Something went wrong!');
        }
    }

    public function AutoExpense(Request $request){   
        $data = [];
        $data = DB::table("expense_types")->select("id","expenseType")->where([['clientid',auth()->user()->id]])->orWhereNull('clientid')->limit(10)->get();  
        if($request->has('q')){
            $search = $request->q;
            $data = DB::table("expense_types")->select("id","expenseType")->where([['clientid',auth()->user()->id],['expenseType','LIKE',"%$search%"]])->orWhereNull('clientid')->get();
            
        }
        return response()->json($data);
    }

    public function AutoVehicle(Request $request){ 
        $data = [];
        $data = DB::table("vehicles")->select("id","vehicleNumber")->where('clientid',auth()->user()->id)->get();  
        if($request->has('q')){
            $search = $request->q;
            $data = DB::table("vehicles")->select("id","vehicleNumber")->where('vehicleNumber','LIKE',"%$search%")->where('clientid','LIKE',auth()->user()->id)->get();    
        }
        return response()->json($data);
    }

    /*==================================
    Delete Multiple non trip expense 
    ====================================*/
    public function DeleteMultipleNonTripExpense(){
         try {
            $this->Expense::whereIn('id',request('exp_id'))->delete();
            return ['status'=>'success','Expense Deleted Successfully'];
        }catch (\Exception $e){
            return ['status'=>'error','Expense Deleted Error'];
        }
    }

}