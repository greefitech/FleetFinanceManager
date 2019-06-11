@extends('client.layout.master')

@section('content')

    <div class="row">
        <div class="col-xs-12">
            <div class="box box-info">
                <div class="box-header">
                    <h4>
                        <center>{{ $Vehicle->vehicleNumber }} Assigned Tyre List</center>
                    </h4>
                </div>
                <div class="box-body">
                    <div class="table-responsive">
                        @if(!auth()->user()->vehicles->isEmpty())
                            <table  class="table table-bordered table-striped DataTable">
                                <thead>
                                    <tr>
                                        <th>Tyre Number</th>
                                        <th>Position</th>
                                        <th>Last Updated</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        @else
                            <blockquote><p>No Tyre List till now!!</p></blockquote>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection