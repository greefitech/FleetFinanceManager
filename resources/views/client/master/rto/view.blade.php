@extends('client.layout.master')

@section('content')

    <div class="row">
        <div class="col-xs-12">
            <div class="box box-info">
                <div class="box-header">
                    <h4>
                        <center>RTO Master</center>
                    </h4>
                    <a href="{{ route('client.AddRTOMaster') }}" class="btn btn-info pull-right">Add RTO Master</a>
                </div>
                <div class="box-body">
                    <div class="table-responsive">
                        @if(!$RTOMasters->isEmpty())
                            <table  class="table table-bordered table-striped DataTable table-hover">
                                <thead>
                                    <tr>
                                        <th>Place</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($RTOMasters as $RTOMaster)
                                        <tr>
                                            <td>{{ $RTOMaster->place }}</td>
                                            <td>
                                                <form action="{{ route('client.DeleteRTOMaster',$RTOMaster->id) }}" method="POST">
                                                    {{ csrf_field() }}
                                                    <input type="hidden" name="_method" value="DELETE">
                                                    <a href="{{ route('client.EditRTOMaster',$RTOMaster->id) }}" class="btn"><i class="fa fa-pencil text-aqua"></i></a>
                                                    <button href="" onclick="return confirm('Are you sure?')" class="btn"><i class="fa fa-trash-o"></i></button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <blockquote><p>No RTO Master till now added!!</p></blockquote>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection