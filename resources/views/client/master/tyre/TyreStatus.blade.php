@extends('client.layout.master')

@section('content')

    <div class="row">
        <div class="col-xs-12">
            <div class="box box-info">
                <div class="box-header">
                    <h4>
                        <center>Tyres Status</center>
                    </h4>
                </div>
                <div class="box-body">
                    <div class="table-responsive">
                            <table  class="table table-bordered table-striped DataTable table-hover">
                                <thead>
                                    <tr>
                                        <th>Transaction</th>
                                        <th>Date</th>
                                        <th>Lorry</th>
                                        <th>Position</th>
                                        <th>Depth</th>
                                        <th>KM</th>
                                        <th>Total KM</th>
                                        <th>Manager</th>
                                        <th>Driver</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                            <blockquote><p>No Tyre Status till now added!!</p></blockquote>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection