<?php

namespace App\Http\Controllers\ClientController\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Tyre;
use App\TyreLog;
use Yajra\DataTables\Facades\DataTables;

class TyreController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $Tyres=Tyre::where([['clientid',auth()->user()->id]])->get();
            return DataTables::of($Tyres)
            ->addColumn('action',function($Tyre){
                return '
                <a href="'.action('ClientController\Master\TyreController@show',$Tyre->id).'" class="btn btn-primary btn-sm"><i class="fa fa-eye"></i></a>
                <a href="'.action('ClientController\Master\TyreController@edit',$Tyre->id).'" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></a>
                <a href="'.action('ClientController\Master\TyreController@destroy',$Tyre->id).'" class="btn btn-md Delete" data-toggle="tooltip" data-placement="right" DeleteMessage="Delete Tyre" style="color:red"><i class="fa fa-trash"></i></a>
                ';
            })
            ->addColumn('vehicle',function($Tyre){
                return !empty($Tyre->vehicleId)?$Tyre->vehicle->vehicleNumber:'NA';
            })
            ->rawColumns(['action'])->make(true);
        }
        return view('client.master.tyre.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('client.master.tyre.create');
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
            'date'=>'required',
            'tyre_number'=>'required',
            'manufacture_company'=>'required',
        ]);
        try {
            $Tyre = new Tyre;
            $Tyre->date = request('date');
            $Tyre->tyre_number = request('tyre_number');
            $Tyre->model = request('model');
            $Tyre->manufacture_company = request('manufacture_company');
            $Tyre->condition = request('condition');
            $Tyre->original_depth = request('original_depth');
            $Tyre->current_depth = request('current_depth');
            $Tyre->purchased_from = request('purchased_from');
            $Tyre->tyre_status = 1;
            $Tyre->clientid=auth()->user()->id;
            $Tyre->save();
            return redirect(action('ClientController\Master\TyreController@index'))->with('success',['Tyre','Added Successfully!']);
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
        if (request()->ajax()) {
            $TyreLogs=TyreLog::where([['tyre_id',$id]])->orderBy('created_at', 'DESC')->get();
            return DataTables::of($TyreLogs)
            ->addColumn('manager',function($TyreLog){
                return @$TyreLog->manager->name;
            })
            ->addColumn('Staff',function($TyreLog){
                return @$TyreLog->Staff->name;
            })
            ->make(true);
        }

        try {
            $Data['Tyre'] = Tyre::findorfail($id);
            return view('client.master.tyre.view',$Data);
        }catch (Exception $e){
            return back()->with('danger','Something went wrong!');
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
            $Data['Tyre'] = Tyre::findorfail($id);
            return view('client.master.tyre.create',$Data);
        }catch (Exception $e){
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
    public function update(Request $request, $id)
    {
         $this->validate(request(),[
            'date'=>'required',
            'tyre_number'=>'required',
            'manufacture_company'=>'required',
        ]);
        try {
            $Tyre = Tyre::findorfail($id);
            $Tyre->date = request('date');
            $Tyre->tyre_number = request('tyre_number');
            $Tyre->model = request('model');
            $Tyre->manufacture_company = request('manufacture_company');
            $Tyre->condition = request('condition');
            $Tyre->original_depth = request('original_depth');
            $Tyre->current_depth = request('current_depth');
            $Tyre->purchased_from = request('purchased_from');
            $Tyre->tyre_status = 1;
            $Tyre->clientid=auth()->user()->id;
            $Tyre->save();
            return redirect(action('ClientController\Master\TyreController@index'))->with('success',['Tyre','Updated Successfully!']);
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
         try {
            Tyre::findorfail($id)->delete();
            return $output = ['status' => 'success','msg' => 'Tyre Deleted Successfully'];
        }catch (Exception $e){
            return back()->with('sorry','Sorry,Something went wrong!');
        }
    }
}
