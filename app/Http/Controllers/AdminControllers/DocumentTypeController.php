<?php

namespace App\Http\Controllers\AdminControllers;

use App\Document;
use App\DocumentType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DocumentTypeController extends Controller
{
    public function __construct(){
        $this->middleware('admin');
    }

    /*view document type*/
    public function view(){
        $Data['DocumentTypes']=DocumentType::get()->all();
        return view('admin.master.documentType.view',$Data);
    }

    /*add document type*/
    public function add(){
        return view('admin.master.documentType.add');
    }

    /*Save Document Type*/
    public function save(){
        $this->validate(request(),[
            'documentType' => 'required|max:255',
        ]);

        try {
            DocumentType::create([
                'documentType' => request('documentType'),
            ]);
            return back()->with('success',['Document Type','Added Successfully!']);
        }catch (Exception $e){
            return back()->with('danger','Something went wrong!');
        }
    }

    /*Edit Document Type*/
    public function edit($id){
        try {
            $Data['DocumentTypes'] = DocumentType::findOrfail($id);
            return view('admin.master.documentType.edit',$Data);
        }catch (Exception $e){
            return back()->with('danger','Something went wrong!');
        }
    }

    /*Update Document type*/
    public function update($id){
        $this->validate(request(),[
            'documentType' => 'required|max:255',
        ]);
        try {
            $DocumentType = DocumentType::findOrfail($id);
            $DocumentType->documentType=request()->documentType;
            $DocumentType->save();
            return back()->with('success',['Document Type',' Updated Successfully!']);
        }catch (Exception $e){
            return back()->with('danger','Something went wrong!');
        }
    }

    /*Delete Document type*/
    public function delete($id){
        try {
            if(Document::where([['documentType',$id]])->count() > 0){
                return back()->with('sorry','Some Client Has Used this document type!!');
            }
            DocumentType::findOrfail($id)->delete();
            return back()->with('success',['Document Type','Deleted Successfully!']);
        }catch (Exception $e){
            return back()->with('danger','Something went wrong!');
        }
    }
}
