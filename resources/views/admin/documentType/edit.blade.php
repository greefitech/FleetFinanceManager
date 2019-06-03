@extends('admin.layout.master')

@section('content')

    <div class="row">
        <div class="col-xs-12">
            <div class="box box-info">
                <div class="box-header">
                    <h4>
                        <center>Edit Document Type</center>
                    </h4>
                    <a href="{{ route('admin.view') }}" class="btn btn-info pull-right">View Document Type</a>
                </div>

                <div class="box-body">

                    <form action="{{route('admin.updateDocumentType',$Data['DocumentType']->id)}}" method="POST">
                        {{ csrf_field() }}

                        <div class="box-body">
                            <div class="row">
                                <div class="container">
                                    <div class="col-sm-12">
                                        <div class="form-group{{ $errors->has('documentType') ? ' has-error' : '' }}">
                                            <div class="col-sm-12">
                                                <label>Document Type</label>
                                                <input type="text" class="form-control" value="{{$Data['DocumentType']->documentType }}" name="documentType" id="document_type">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div><br>
                            <div class="row">
                                <div class="container">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <button type="submit" class="btn btn-info btn-block">Upadte</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

