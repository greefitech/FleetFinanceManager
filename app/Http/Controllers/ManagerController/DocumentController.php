<?php

namespace App\Http\Controllers\ManagerController;

use App\Document;
use App\DocumentType;
use App\Vehicle;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DocumentController extends Controller
{
    public function view($VehicleId){
        $Data['Vehicle'] = Vehicle::findorfail($VehicleId);
        return view('manager.master.vehicle.document.view',$Data);
    }

    public function add($VehicleId){
        $Data['Vehicle'] = Vehicle::findorfail($VehicleId);
        $Data['DocumentTypes'] =DocumentType::get()->all();
        return view('manager.master.vehicle.document.add',$Data);
    }

    public function save($vehicleId){
        $this->validate(request(),[
            'documentType'=>'required|exists:document_types,id',
            'duedate'=>'required|date',
            'notifyBefore'=>'required',
            'issuingCompany'=>'required',
            'interval'=>'required',
            'amount'=>'required',
        ]);

        try {
            Document::create([
                'documentType' => request('documentType'),
                'duedate' => request('duedate'),
                'notifyBefore' => request('notifyBefore'),
                'interval' => request('interval'),
                'issuingCompany' => request('issuingCompany'),
                'amount' => request('amount'),
                'notes' => request('notes'),
                'vehicleId' => $vehicleId,
            ]);
            return redirect(route('manager.ViewDocuments',$vehicleId))->with('success',['Document','Added Successfully!']);
        }catch (Exception $e){
            return back()->with('danger','Something went wrong!');
        }
    }


    public function edit($DocumentId){
        $Data['Document'] = Document::findOrfail($DocumentId);
        $Data['Vehicle'] = Vehicle::findorfail($Data['Document']->vehicleId);
        $Data['DocumentTypes'] =DocumentType::get()->all();
        return view('manager.master.vehicle.document.edit',$Data);
    }

    public function update($id){
        $this->validate(request(),[
            'documentType'=>'required|exists:document_types,id',
            'duedate'=>'required|date',
            'notifyBefore'=>'required',
            'issuingCompany'=>'required',
            'interval'=>'required',
            'amount'=>'required',
        ]);
        try{
            $document = Document::findOrfail($id);
            $document->documentType = request('documentType');
            $document->duedate = request('duedate');
            $document->notifyBefore = request('notifyBefore');
            $document->interval = request('interval');
            $document->issuingCompany = request('issuingCompany');
            $document->amount = request('amount');
            $document->notes = request('notes');
            $document->save();
            return redirect(route('manager.ViewDocuments',$document->vehicleId))->with('success',['Document','Updated Successfully!']);
        }catch (Exception $e){
            return back()->with('danger','Something went wrong!');
        }
    }

    public function delete($id){
        $DeleteData= Document::findOrfail($id);
        try {
            Document::findOrfail($id)->delete();
            return redirect(route('manager.ViewDocuments',$DeleteData->vehicleId))->with('success',['Document','Deleted Successfully!']);
        } catch (\Illuminate\Database\QueryException $e) {
            return back()->with('danger','Something went wrong!');
        }
    }
}
