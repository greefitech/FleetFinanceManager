<?php

namespace App\Http\Controllers\API\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\DocumentType;
use App\Vehicle;
use App\Document;
use Illuminate\Support\Facades\Auth; 
use Validator;

class DocumentController extends Controller
{
    public $successStatus = 200;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request){
        $validator = Validator::make(request()->all(), [
           'documentType'=>'required|exists:document_types,id',
            'duedate'=>'required|date',
            'notifyBefore'=>'required',
            'issuingCompany'=>'required',
            'interval'=>'required',
            'amount'=>'required',
            'vehicleId'=>'required',
        ]);
        if ($validator->fails()) {
            foreach ($validator->errors()->toArray() as $value) {
               $errData[]=$value[0];
            }
            return response()->json(['msg'=>'Please check the data','error'=>$errData], 401);
        }
        try{
            $Vehicle = Vehicle::findorfail(request('vehicleId'));
            $document = new Document;
            $document->documentType = request('documentType');
            $document->duedate = request('duedate');
            $document->notifyBefore = request('notifyBefore');
            $document->interval = request('interval');
            $document->issuingCompany = request('issuingCompany');
            $document->amount = request('amount');
            $document->notes = request('notes');
            $document->vehicleId = request('vehicleId');
            if($request->file('file')){
                $file = $request->file('file');
                $imageName = hash('sha256', strval(time())).'.'.$request->file->getClientOriginalExtension();
                $destinationPath = config('mohan.uploads.vehicle_document').$Vehicle->vehicleNumber.'/';
                $file->move($destinationPath,$imageName);
                $document->file =$destinationPath.$imageName;
            }
            $document->save();
            return response()->json(['msg'=>'Vehicle Document Saved Successfully'], $this->successStatus);
        }catch (\Exception $e){
            return response()->json(['msg'=>'Something Went Wrong'],401);
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
        try{
            $success['DocumentTypes'] = DocumentType::select('id','documentType')->get();
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
        try{
            $success['DocumentTypes'] = DocumentType::select('id','documentType')->get();
            $success['Document'] = Document::findorfail($id);
            return response()->json(['msg'=>'Vehicle Document List','data' =>$success], $this-> successStatus);
        }catch (Exception $e){
            return response()->json(['msg'=>'Something Went Wrong'],401);
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
        $validator = Validator::make(request()->all(), [
           'documentType'=>'required|exists:document_types,id',
            'duedate'=>'required|date',
            'notifyBefore'=>'required',
            'issuingCompany'=>'required',
            'interval'=>'required',
            'amount'=>'required',
        ]);
        if ($validator->fails()) {
            foreach ($validator->errors()->toArray() as $value) {
               $errData[]=$value[0];
            }
            return response()->json(['msg'=>'Please check the data','error'=>$errData], 401);
        }
        try{
            $document = Document::findOrfail($id);
            $Vehicle = Vehicle::findorfail($document->vehicleId);
            $document->documentType = request('documentType');
            $document->duedate = request('duedate');
            $document->notifyBefore = request('notifyBefore');
            $document->interval = request('interval');
            $document->issuingCompany = request('issuingCompany');
            $document->amount = request('amount');
            $document->notes = request('notes');
            if($request->file('file')){
                $file = $request->file('file');
                $imageName = hash('sha256', strval(time())).'.'.$request->file->getClientOriginalExtension();
                $destinationPath = config('mohan.uploads.vehicle_document').$Vehicle->vehicleNumber.'/';
                $file->move($destinationPath,$imageName);
                $document->file =$destinationPath.$imageName;
            }
            $document->save();
            return response()->json(['msg'=>'Vehicle Document Updated Successfully'], $this->successStatus);
        }catch (\Exception $e){
            return response()->json(['msg'=>'Something Went Wrong'],401);
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

    public function vehicleDocumentTypes(){
         try{
           $success['DocumentTypes'] = DocumentType::select('id','documentType')->get();
           return response()->json(['msg'=>'Vehicle Document Type List','data' =>$success], $this->successStatus);
        }catch (Exception $e){
            return response()->json(['msg'=>'Something Went Wrong'],401);
        }
    }
}
