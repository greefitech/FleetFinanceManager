@extends('client.layout.master')

@section('content')

    <div class="row">
        <div class="col-xs-12">
            <div class="box box-info">
                <div class="box-header">
                    <h4>
                        <center>Staffs</center>
                    </h4>
                    <a href="{{ route('client.AddStaff') }}" class="btn btn-info pull-right">Add Staff</a>
                </div>
                <div class="box-body">
                    <div class="table-responsive">
                        @if(!auth()->user()->staffs->isEmpty())
                            <table  class="table table-bordered table-striped DataTable">
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
                                            <td>{{ $Staff->type }}</td>
                                            <td>{{ $Staff->licenceNumber }}</td>
                                            <?php $RenewalDays = $Helper::DateDifference($Staff->licenceRenewal) ?>
                                            <td>@if($RenewalDays <10)<span style="color: red;">{{ $RenewalDays }}</span> @else {{ $RenewalDays }} @endif</td>
                                            <td>
                                                <form action="{{ route('client.DeleteStaff',$Staff->id) }}" method="POST">
                                                    {{ csrf_field() }}
                                                    <input type="hidden" name="_method" value="DELETE">
                                                    <a href="#" class="btn"><i class="fa fa-eye text-aqua"></i></a>
                                                    <a href="{{ route('client.EditStaff',$Staff->id) }}" class="btn"><i class="fa fa-pencil text-aqua"></i></a>
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