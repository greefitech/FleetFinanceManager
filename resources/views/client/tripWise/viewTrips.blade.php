@extends('client.layout.master')

@section('TripSheetMenu','active')

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
                        @if(!$Trips->isEmpty())
                            <table  class="table table-bordered table-striped DataTable">
                                <thead>
                                    <tr>
                                        <th>Date From</th>
                                        <th>Date To</th>
                                        <th>Trip Name</th>
                                        <th>Total KM</th>
                                        <th>Staff</th>
                                        <th>Profit</th>
                                        <th>Trip Status</th>
                                        <th>Created By</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($Trips as $Trip)
                                        <tr>
                                            <td>{!! CheckTripDuplicateEntry($Trip->id,$Vehicle->id,$Trip->dateFrom,$Trip->dateTo) !!} {{ date("d-m-Y", strtotime($Trip->dateFrom)) }}</td>
                                            <td>{{ date("d-m-Y", strtotime($Trip->dateTo)) }}</td>
                                            <td>{{ $Trip->tripName }}</td>
                                            <td>{{ $Trip->totalKm }}</td>
                                            <td>{{ $Trip->Staff1->name }}</td>
                                            @if(!$Trip->deleted_at)
                                                <td>{{ auth()->user()->TripTotalIncome($Trip->id) - auth()->user()->TripTotalExpense($Trip->id) }}</td>
                                                <td><span class="label label-{{ ($Trip->status == 0)?'danger':'success' }}">{{ ($Trip->status == 0)?'Not Completed':'Completed' }}</span></td>
                                                <td>{{ $Trip->managerid !='' ? $Trip->Manager->name: $Trip->Client->name }}</td>
                                            @else
                                                <td colspan="3">
                                                    <span class="label label-primary">Trip Deleted on {{ date("d-M-Y", strtotime($Trip->deleted_at)) }}</span>
                                                </td>
                                            @endif
                                            @if(!$Trip->deleted_at)
                                                <td>
                                                    <a href="{{ route('client.DownloadTripSheet',$Trip->id) }}" class="btn btn-primary btn-sm"><i class="fa fa-eye" aria-hidden="true"></i> View Trip Sheet</a>
                                                    <div class="input-group input-group-sm">
                                                        <div class="input-group-btn">
                                                            <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-tasks" aria-hidden="true"></i> Action
                                                                <span class="fa fa-caret-down"></span></button>
                                                            <ul class="dropdown-menu">
                                                                <li><a href="{{ route('client.ViewTripEntryList',$Trip->id) }}">Entries</a></li>
                                                                <li><a href="{{ route('client.ViewTripExpenseList',$Trip->id) }}">Expense</a></li>
                                                                <li><a href="{{ route('client.ViewTripHaltList',$Trip->id) }}">Halt</a></li>
                                                                <li><a href="{{ route('client.ViewTripAdvanceList',$Trip->id) }}">Trip Advance</a></li>
                                                                <li class="divider"></li>
                                                                <li><a href="{{ route('client.EditTrip',$Trip->id) }}"><i class="fa fa-edit"></i>  Edit</a></li>
                                                                <li>
                                                                    <form action="{{ route('client.DeleteTripSheetData',$Trip->id) }}" method="POST">
                                                                        {{ csrf_field() }}
                                                                        <input type="hidden" name="_method" value="DELETE">
                                                                        <button href="" onclick="return confirm('Are you sure?')" class="btn btn-danger"><i class="fa fa-trash-o"></i> Delete</button>
                                                                    </form>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </td>
                                            @else
                                                <td>
                                                    <a onclick="return confirm('Are you sure? Undo Trip')" href="{{ action('ClientController\TripWiseController@TripUndoList',$Trip->id) }}" class="btn btn-info btn-sm"><i class="fa fa-undo"></i> Undo</a>
                                                </td>
                                            @endif
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <blockquote><p>No Trip till now added!!</p></blockquote>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection