<?php

namespace App\Http\Controllers\ClientController\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


use App\Vendor;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class VendorController extends Controller
{

     public function __construct(){
        $this->Vendor = new Vendor;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        if (request()->ajax()) {
            $Vendors=$this->Vendor::where('clientid',auth()->user()->id)->get();
            return DataTables::of($Vendors)
            ->addColumn('action',function($Vendor){
                return '<a href="'.action('ClientController\Master\VendorController@edit',$Vendor->id).'" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></a>';
            })
            ->addColumn('balance',function($Vendor){
                return '~~~-~~~';
            })
            ->rawColumns(['action'])->make(true);
        }
        return view('client.master.vendor.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){
        return view('client.master.vendor.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
        $this->validate(request(),[
            'name'=>'required',
            'mobile'=>'nullable|regex:/[0-9]{10}/',
            'address'=>'nullable',
        ]);
        try {
            $Vendor = $this->Vendor;
            $Vendor->name=request('name');
            $Vendor->mobile=request('mobile');
            $Vendor->gst=request('gst');
            $Vendor->address=request('address');
            $Vendor->clientid=auth()->user()->id;
            $Vendor->save();
            return redirect(action('ClientController\Master\VendorController@index'))->with('success',['Vendor','Added Sucessfully!']);
        }catch (\Exception $e){
            return back()->with('danger','Something went wrong!');
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id){
        try{
            $Data['Vendor'] = $this->Vendor::findOrfail($id);
            return view('client.master.vendor.create',$Data);
        }catch (\Exception $e){
            return back()->with('danger','Something went wrong!');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id){
        $this->validate(request(),[
            'name'=>'required',
            'mobile'=>'nullable|regex:/[0-9]{10}/',
            'address'=>'nullable',
        ]);
        try {
            $Vendor = $this->Vendor::findOrfail($id);
            $Vendor->name=request('name');
            $Vendor->mobile=request('mobile');
            $Vendor->gst=request('gst');
            $Vendor->address=request('address');
            $Vendor->clientid=auth()->user()->id;
            $Vendor->save();
            return redirect(action('ClientController\Master\VendorController@index'))->with('success',['Vendor','Updated Sucessfully!']);
        }catch (\Exception $e){
            return back()->with('danger','Something went wrong!');
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
        //
    }
}
