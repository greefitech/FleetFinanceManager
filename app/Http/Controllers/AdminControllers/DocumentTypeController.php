<?php

namespace App\Http\Controllers\AdminControllers;

use App\DocumentType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DocumentTypeController extends Controller
{
    public function __construct(){
        $this->middleware('admin');
    }

    public function show(){
        $Data['DocumentTypes']=DocumentType::get()->all();
        return view('admin.documentType.view',compact('Data'));
    }

    public function add(){
        return view('admin.documentType.add');
    }

    public function addDocumentType(){
        try {
            DocumentType::create([
                'documentType' => request('documentType'),
            ]);
            return back()->with('success',['Document','Type Added Sucessfully!']);
        }catch (Exception $e){
            return back()->with('danger','Something went wrong!');
        }
    }

    public function editDocumentType($id){
        try {
            $Data['DocumentType'] = DocumentType::findOrfail($id);
            return view('admin.documentType.edit',compact('Data'));
        }catch (Exception $e){
            return back()->with('danger','Something went wrong!');
        }
    }

    public function updateDocumentType($id){
        try {
            $DocumentType = DocumentType::findOrfail($id);
            $DocumentType->documentType=request()->documentType;
            $DocumentType->save();
            return back()->with('success',['Document','Type Updated Sucessfully!']);
        }catch (Exception $e){
            return back()->with('danger','Something went wrong!');
        }
    }


    public function deleteDocumentType($id){
        try {
            DocumentType::findOrfail($id)->delete();
            return back()->with('success',['Document','Type Deleted Sucessfully!']);
        }catch (Exception $e){
            return back()->with('danger','Something went wrong!');
        }
    }
}