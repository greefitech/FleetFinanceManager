@extends('admin.layout.master')


@section('content')

    <div class="row">
        <div class="col-xs-12">
            <div class="box box-info">
                <div class="box-header">
                    <h4>
                        <center>View Admin Wise</center>
                    </h4>
                    {{--                    <a href="{{ route('admin.adminAccountAdd') }}" class="btn btn-info pull-right">Add Admin</a>--}}
                </div>
                <div class="box-body">
                    <div class="table-responsive">
                        @if(!empty($Data['Admin']))
                            <table  class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Mobile Number</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>

                                @foreach($Data['Admin'] as $Admin)
                                    @if(!empty($Admin))
                                        <tr>
                                            <td>{{ $Admin->name }}</td>
{{--                                            <td>{{ $Admin->transportName }}</td>--}}
                                            <td>{{ $Admin->mobile }}</td>
{{--                                            <td>{{ $Admin->address }}</td>--}}
{{--                                            <td>{{ $Admin->vehicleCredit }}</td>--}}
                                            <td>
                                                <a href="{{ route('admin.AdminClientWise',$Admin->id) }}"><button type="button" class="btn btn-success">View</button></a>
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach

                                </tbody>
                            </table>
                        @else
                            <blockquote><p>No Admin Records!!</p></blockquote>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection