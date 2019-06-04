@extends('admin.layout.master')

@section('content')

    <div class="row">
        <div class="col-xs-12">
            <div class="box box-info">
                <div class="box-header">
                    <h4>
                        <center>View Vehicle Credit Payment</center>
                    </h4>
                    <a href="{{ route('admin.AddVehicleCreditPayment') }}" class="btn btn-info pull-right">Add Vehicle Credit Payment</a>
                </div>
                <div class="box-body">
                    <div class="table-responsive">
                        @if(!empty($VehicleCreditPayment))
                            <table  class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th style="text-align:center">Expense Type</th>
                                    <th style="text-align:center">Action</th>
                                </tr>
                                </thead>
                                <tbody>


                                </tbody>
                            </table>
                        @else
                            <blockquote><p>No Settlement Here added!!</p></blockquote>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection