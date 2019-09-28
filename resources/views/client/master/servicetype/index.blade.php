@extends('client.layout.master')

@section('content')

    <div class="row">
        <div class="col-xs-12">
            <div class="box box-info">
                <div class="box-header">
                    <h4>
                        <center>Services</center>
                    </h4>
                    <a href="{{ action('ClientController\Master\ServiceTypeController@create') }}" class="btn btn-info pull-right">Add Service</a>
                </div>
                <div class="box-body">
                    <div class="table-responsive">
                        @if(!$servicetypes->isEmpty())
                            <table  class="table table-bordered table-striped DataTable table-hover">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Type</th>
                                        <th>Client Id</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($servicetypes as $servicetype)
                                    <tr>
                                        <td>{{$servicetype->name}}</td>
                                        <td>{{$servicetype->type}}</td>
                                        <td>{{$servicetype->clientid}}</td>
                                        <td>
                                        <form action="{{ action('ClientController\Master\ServiceTypeController@destroy',$servicetype->id) }}" method="POST">
                                                {{ csrf_field() }}
                                                <input type="hidden" name="_method" value="DELETE">
                                                <a href="{{ action('ClientController\Master\ServiceTypeController@edit',$servicetype->id) }}" class="btn"><i class="fa fa-pencil text-aqua"></i></a>
                                                <button href="" onclick="return confirm('Are you sure?')" class="btn"><i class="fa fa-trash-o"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <blockquote><p>No Services till now added!!</p></blockquote>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
