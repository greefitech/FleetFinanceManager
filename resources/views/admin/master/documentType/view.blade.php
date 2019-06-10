@extends('admin.layout.master')

@section('content')

    <div class="row">
        <div class="col-xs-12">
            <div class="box box-info">
                <div class="box-header">
                    <h4>
                        <center>Document Type</center>
                    </h4>
                    <a href="{{ route('admin.AddDocumentType') }}" class="btn btn-info pull-right">Add Document Type</a>
                </div>
                <div class="box-body">
                    <div class="table-responsive">
                        @if(!empty($DocumentTypes))
                            <table  class="table table-bordered table-striped DataTable">
                                <thead>
                                    <tr>
                                        <th style="text-align:center">Vehicle Type</th>
                                        <th style="text-align:center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($DocumentTypes as $key=>$DocumentType)
                                        <tr>
                                            <td>{{ $DocumentType->documentType }}</td>
                                            <td style="text-align:center">
                                                <a href="{{ route('admin.EditDocumentType',$DocumentType->id) }}"><button type="button" class="btn btn-success">Edit</button></a>
                                                <a href="{{ route('admin.DeleteDocumentType',$DocumentType->id) }}"><button type="button" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</button></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <blockquote><p>No Documents Types added!!</p></blockquote>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection