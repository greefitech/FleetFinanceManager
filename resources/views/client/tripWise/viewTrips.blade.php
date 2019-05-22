@extends('client.layout.master')

@section('content')

    <div class="row">
        <div class="col-xs-12">
            <div class="box box-info">
                <div class="box-header">
                    <h4>
                        <center><span style="color: green;font-size: 20px;">{{ $Vehicle->vehicleNumber }}</span> Trip List</center>
                    </h4>
                </div>
                <div class="box-body">
                    <div class="table-responsive">
                        @if(!empty($Trips))
                            <table  class="table table-bordered table-striped DataTable">
                                <thead>
                                    <tr>
                                        <th>Date From</th>
                                        <th>Date To</th>
                                        <th>Trip Name</th>
                                        <th>Total KM</th>
                                        <th>Staff</th>
                                        <th>Advance</th>
                                        <th>Trip Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($Trips as $Trip)
                                        <tr>
                                            <td>{{ date("d-m-Y", strtotime($Trip->dateFrom)) }}</td>
                                            <td>{{ date("d-m-Y", strtotime($Trip->dateTo)) }}</td>
                                            <td>{{ $Trip->tripName }}</td>
                                            <td>{{ $Trip->totalKm }}</td>
                                            <td>{{ $Trip->Staff1->name }}</td>
                                            <td>{{ $Trip->advance }}</td>
                                            <td><span style="color: {{ ($Trip->status == 0)?'red':'green' }}">{{ ($Trip->status == 0)?'Not Completed':'Completed' }}</span></td>
                                            <td>
                                                <a href="" class="btn btn-primary btn-sm">View Memo</a>
                                                <a href="" class="btn btn-primary btn-sm">Halt</a>
                                                <a href="{{ route('client.ViewTripEntryList',$Trip->id) }}" class="btn btn-primary btn-sm">Entries</a>
                                                <a href="{{ route('client.ViewTripExpenseList',$Trip->id) }}" class="btn btn-primary btn-sm">Expense</a>
                                                <a href="{{ route('client.EditTrip',$Trip->id) }}" class="btn btn-primary btn-sm">Edit</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <blockquote><p>No Vehicle till now added!!</p></blockquote>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection