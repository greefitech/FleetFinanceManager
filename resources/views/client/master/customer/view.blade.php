@extends('client.layout.master')

@section('content')

    <div class="row">
        <div class="col-xs-12">
            <div class="box box-info">
                <div class="box-header">
                    <h4>
                        <center>Customers</center>
                    </h4>
                    <a href="{{ route('client.AddCustomer') }}" class="btn btn-info pull-right">Add Customer</a>
                </div>
                <div class="box-body">
                    <div class="table-responsive">
                        @if(!empty(auth()->user()->customers))
                            <table  class="table table-bordered table-striped DataTable">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Mobile</th>
                                        <th>Address</th>
                                        <th>Type</th>
                                        <th>Created By</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach(auth()->user()->customers as $Customer)
                                        <tr>
                                            <td>{{ $Customer->name }}</td>
                                            <td>{{ $Customer->mobile }}</td>
                                            <td>{{ $Customer->address }}</td>
                                            <td>{{ $Customer->type }}</td>
                                            <td>{{ (!empty($Customer->managerid))?$Customer->manager->name:auth()->user()->name }}</td>
                                            <td>
                                                <form action="{{ route('client.DeleteCustomer',$Customer->id) }}" method="POST">
                                                    {{ csrf_field() }}
                                                    <input type="hidden" name="_method" value="DELETE">
                                                    <a href="#" class="btn"><i class="fa fa-eye text-aqua"></i></a>
                                                    <a href="{{ route('client.EditCustomer',$Customer->id) }}" class="btn"><i class="fa fa-pencil text-aqua"></i></a>
                                                    <button href="" onclick="return confirm('Are you sure?')" class="btn"><i class="fa fa-trash-o"></i></button>
                                                </form>
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