<?php

namespace App\Http\Controllers\ClientController\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Servicetype;

class ServiceTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $Data['servicetypes'] = Servicetype::where([['clientid',auth()->user()->id]])->get();
        return view('client.master.servicetype.index',$Data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('client.master.servicetype.create');
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
            'name'=>'required|unique:servicetypes',
            'type'=>'required',
        ]);
        try{
        $servicetype = new Servicetype();
        $servicetype->name = $request->name;
        $servicetype->type = $request->type;
        $servicetype->clientid = auth()->user()->id;
        $servicetype->save();
        return redirect(action('ClientController\Master\ServiceTypeController@index'));
        }catch (\Exception $e){
            return redirect(url('/client/home'))->with('danger','Something went wrong!');
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
    
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id){
        try{
            $Data['servicetype'] = Servicetype::findOrfail($id);
            return view('client.master.servicetype.create',$Data);
        }catch (\Exception $e){
            return redirect(url('/client/home'))->with('danger','Something went wrong!');
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
        try{
        $servicetype = Servicetype::find($id);
        $this->validate(request(),[
            'name'=>'required',
            'type'=>'required|in:km,date',
        ]);
        $servicetype->name = $request->name;
        $servicetype->type = $request->type;
        $servicetype->clientid = auth()->user()->id;
        $servicetype->save();
        return redirect(action('ClientController\Master\ServiceTypeController@index'));
        }catch (\Exception $e){
            return redirect(url('/client/home'))->with('danger','Something went wrong!');
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
        Servicetype::findOrfail($id)->delete();
        return back();
    }
}
