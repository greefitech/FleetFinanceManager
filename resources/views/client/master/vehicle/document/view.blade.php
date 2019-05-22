@extends('client.layout.master')

@section('content')

    <div class="row">
        <div class="col-xs-12">
            <div class="box box-info">
                <div class="box-header">
                    <h4>
                        <center>Vehicle Document</center>
                    </h4>
                    <a href="{{ route('client.AddVehicle') }}" class="btn btn-info pull-right">Add Document</a>
                </div>
                <div class="box-body">
                    <div class="table-responsive">
                            <table  class="table table-bordered table-striped DataTable">
                                <thead>
                                    <tr>
                                        <th>Owner Name</th>
                                        <th>Vehicle Number</th>
                                        <th>Vehicle Name</th>
                                        <th>Model</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                            <blockquote><p>No Document till now added!!</p></blockquote>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection