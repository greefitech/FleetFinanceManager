<?php

namespace App\Http\Controllers\ClientController\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\VehicleService;
use Yajra\DataTables\Facades\DataTables;

class VehicleServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $VehicleServices=VehicleService::where('clientid',auth()->user()->id)->get();
            return DataTables::of($VehicleServices)
            ->addColumn('action',function($VehicleService){
                return '<a href="'.action('ClientController\Master\VehicleServiceController@edit',$VehicleService->id).'" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></a>';
            })
            ->rawColumns(['action'])->make(true);
        }

        return view('client.master.vehicleservice.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('client.master.vehicleservice.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate(request(),[
            'title' => 'required',
        ]);
        try {
            $VehicleService = new VehicleService();
            $VehicleService->title=request('title');
            $VehicleService->clientid=auth()->user()->id;
            $VehicleService->save();
            return redirect(action('ClientController\Master\VehicleServiceController@index'))->with('success',['Vehicle Service','Added Successfully!']);
        } catch (\Illuminate\Database\QueryException $e) {
            return back()->with('danger', 'Something went wrong!');
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
    public function edit($id)
    {
        try { 
            $Data['VehicleService'] = VehicleService::findorfail($id);
            return view('client.master.vehicleservice.create',$Data);
        }catch (\Exception $e){
            return back()->with('sorry','Sorry,Something went wrong!');
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
        $this->validate(request(),[
            'title' => 'required',
        ]);
        try {
            $VehicleService = VehicleService::findorfail($id);
            $VehicleService->title=request('title');
            $VehicleService->save();
            return redirect(action('ClientController\Master\VehicleServiceController@index'))->with('success',['Vehicle Service','Updated Successfully!']);
        } catch (\Illuminate\Database\QueryException $e) {
            return back()->with('danger', 'Something went wrong!');
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
