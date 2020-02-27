@extends('client.layout.master')

@section('MasterMenu','active')

@section('content')

    <div class="row">
        <div class="col-xs-12">
            <div class="box box-info">
                <div class="box-header">
                    <h4>
                        <center>Staffs</center>
                    </h4>
                    <a href="{{ action('ClientController\StaffController@create') }}" class="btn btn-info pull-right">Add Staff</a>
                </div>
                <div class="box-body">
                    <div class="table-responsive">
                        @if(!auth()->user()->staffs->isEmpty())
                            <table  class="table table-bordered table-striped DataTable table-hover">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Mobile</th>
                                        <th>Address</th>
                                        <th>Type</th>
                                        <th>License Number</th>
                                        <th>License Renewal</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach(auth()->user()->staffs as $Staff)
                                        <tr>
                                            <td>{{ $Staff->name }}</td>
                                            <td>{{ $Staff->mobile1 }}</td>
                                            <td>{{ $Staff->address }}</td>
                                            <td>{{ ucfirst($Staff->type) }}</td>
                                            <td>{{ $Staff->licenceNumber }}</td>
                                            <th>@if(DateDifference($Staff->licenceRenewal) < 10)<span style="color: red;">{{ DateDifference($Staff->licenceRenewal) }}</span> @else {{ DateDifference($Staff->licenceRenewal) }} @endif</th>
                                            <td>
                                                <form action="{{ action('ClientController\StaffController@destroy',$Staff->id) }}" method="POST">
                                                    {{ csrf_field() }}
                                                    <input type="hidden" name="_method" value="DELETE">
                                                    <a href="#" class="btn"><i class="fa fa-eye text-aqua"></i></a>
                                                    <a href="{{ action('ClientController\StaffController@edit',$Staff->id) }}" class="btn"><i class="fa fa-pencil text-aqua"></i></a>
                                                    <button href="" onclick="return confirm('Are you sure?')" class="btn"><i class="fa fa-trash-o"></i></button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <blockquote><p>No Staff till now added!!</p></blockquote>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection