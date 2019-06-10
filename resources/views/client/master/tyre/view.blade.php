@extends('client.layout.master')

@section('content')

    <div class="row">
        <div class="col-xs-12">
            <div class="box box-info">
                <div class="box-header">
                    <h4>
                        <center>Tyres</center>
                    </h4>
                    <a href="{{ route('client.AddTyre') }}" class="btn btn-info pull-right">Add Tyre</a>
                </div>
                <div class="box-body">
                    <div class="table-responsive">
                            <table  class="table table-bordered table-striped DataTable table-hover">
                                <thead>
                                    <tr>
                                        <th>Tyre Number</th>
                                        <th>Manufacture Company</th>
                                        <th>Purchased From</th>
                                        <th>Tyre Status</th>
                                        <th>Vehicle</th>
                                        <th>condition</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                            <blockquote><p>No Tyre till now added!!</p></blockquote>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection