@extends('admin.layout.master')

@section('content')

    <div class="row">
        <div class="col-xs-12">
            <div class="box box-info">
                <div class="box-header">
                    <h4>
                        <center>Incomes</center>
                    </h4>
                </div>
                <div class="box-body">
                    <div class="table-responsive">
                        @if(!empty($Data['Clients']))
                            <table  class="table table-bordered table-striped DataTable">
                                <thead>
                                <tr>
                                    <th>Client Name	</th>
                                    <th>Transport</th>
                                    <th>Mobile</th>
                                    <th>Address</th>
                                    <th>Client Total Vehicle</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>

                                @foreach($Data['Clients'] as $Client)
                                    <tr class="c-table__row">
                                        <td>{{$Client->name}}</td>
                                        <td>{{$Client->transportName}}</td>
                                        <td>{{$Client->mobile}}</td>
                                        <td>{{$Client->address}}</td>
                                        <td>{{ count($Client->vehicles) }}</td>
                                        <td>
                                            <a href="/admin/Clients/VehicleList/{{$Client->id}}"><button type="button" class="btn btn-success">View Vehicle List</button></a>
                                            <a href="/admin/Clients/{{$Client->id}}/editClient"><button type="button" class="btn btn-primary">Edit Client</button></a>
                                            <a href="/admin/Clients/{{$Client->id}}/delete"><button type="button" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</button></a>
                                        </td>
                                    </tr>
                                @endforeach

                                </tbody>
                            </table>
                        @else
                            <blockquote><p>No Customer till now added!!</p></blockquote>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection