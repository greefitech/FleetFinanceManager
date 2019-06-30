@extends('manager.layout.master')

@section('content')

    <div class="row">
        <div class="col-xs-12">
            <div class="box box-info">
                <div class="box-header">
                    <h4>
                        <center>Vehicles List</center>
                    </h4>
                </div>
                <div class="box-body">
                    <div class="table-responsive">
                        @if(!auth()->user()->vehicles()->isEmpty())
                            <table  class="table table-bordered table-striped DataTable">
                                <thead>
                                    <tr>
                                        <th>Owner Name</th>
                                        <th>Vehicle Number</th>
                                        <th>Vehicle Name</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach(auth()->user()->vehicles() as $Vehicle)
                                        <tr>
                                            <td>{{ $Vehicle->ownerName }}</td>
                                            <td>{{ $Vehicle->vehicleNumber }}</td>
                                            <td>{{ $Vehicle->vehicleName }}</td>
                                            <td>
                                                <a href="{{ route('manager.NonTripVehicleExpenseList',$Vehicle->id) }}" class="btn btn-primary btn-sm">View Expense</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <blockquote><p>No Vehicle till now!!</p></blockquote>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection