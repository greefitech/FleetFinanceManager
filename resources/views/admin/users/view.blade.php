@extends('admin.layout.master')


@section('content')

    <div class="row">
        <div class="col-xs-12">
            <div class="box box-info">
                <div class="box-header">
                    <h4>
                        <center>View Admin Accounts</center>
                    </h4>
                    <a href="{{ route('admin.adminAccountAdd') }}" class="btn btn-info pull-right">Add Admin</a>
                </div>
                <div class="box-body">
                    <div class="table-responsive">
                        @if(!empty($admins))
                            <table  class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th style="text-align:center">Name</th>
                                    <th style="text-align:center">E-mail</th>
                                    <th style="text-align:center">Mobile Number</th>
                                </tr>
                                </thead>
                                <tbody>

                                @foreach($admins as $admin)
                                    @if(!empty($admin->mobile))
                                        <tr>
                                            <td>{{ $admin->name }}</td>
                                            <td>{{ $admin->email }}</td>
                                            <td>{{ $admin->mobile }}</td>
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