@extends('manager.layout.master')

@section('content')

    <div class="row">
        <div class="col-xs-12">
            <div class="box box-info">
                <div class="box-header">
                    <h4>
                        <center>Customers</center>
                    </h4>
                    <a href="{{ route('manager.AddCustomer') }}" class="btn btn-info pull-right">Add Customer</a>
                </div>
                <div class="box-body">
                    <div class="table-responsive">
                        @if(!auth()->user()->Customers->isEmpty())
                            <table  class="table table-bordered table-striped DataTable table-hover">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Mobile</th>
                                        <th>Address</th>
                                        <th>Type</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach(auth()->user()->Customers as $Customer)
                                        <tr>
                                            <td>{{ $Customer->name }}</td>
                                            <td>{{ $Customer->mobile }}</td>
                                            <td>{{ $Customer->address }}</td>
                                            <td>{{ $Customer->type }}</td>
                                            <td>
                                                <a href="{{ route('manager.EditCustomer',$Customer->id) }}" class="btn"><i class="fa fa-pencil text-aqua"></i></a>
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