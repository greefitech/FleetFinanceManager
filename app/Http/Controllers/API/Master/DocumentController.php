<?php

namespace App\Http\Controllers\API\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\DocumentType;
use App\Vehicle;
use App\Document;

class DocumentController extends Controller
{
    public $successStatus = 200;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try{
            $success['Documents'] = Document::with('DocumentType')->where('vehicleId',$id)->get();
            $success['Documents']->map(function($Document) {
                $Document->dude_days=DateDifference($Document->duedate);
                $Document->alert=(DateDifference($Document->duedate)<=$Document->notifyBefore)?'red':'green' ;
                return $Document;
            });
           return response()->json(['msg'=>'Vehicle Document List','data' =>$success], $this-> successStatus);
        }catch (Exception $e){
            return response()->json(['msg'=>'Something Went Wrong'],401);
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
