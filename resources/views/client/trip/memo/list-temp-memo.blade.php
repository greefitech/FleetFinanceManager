@extends('client.layout.master')

@section('content')

    <div class="row">
        <div class="col-xs-12">
            <div class="box box-info">
                <div class="box-header">
                    <h4>
                        <center>Temporary Memo List</center>
                    </h4>
                </div>
                <div class="box-body">
                    <div class="table-responsive">
                        @if(!$TripTemps->isEmpty())
                            <table  class="table table-bordered table-striped DataTable">
                                <thead>
                                    <tr>
                                        <th>Vehicle</th>
                                        <th>Date From</th>
                                        <th>Date To</th>
                                        <th>Advance</th>
                                        <th>Total KM</th>
                                        <th>First Driver</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($TripTemps as $TripTemp)
                                        <tr> 
                                            <td>{{ $TripTemp->vehicle['vehicleNumber']}} - {{$TripTemp->vehicle['ownerName'] }}</td>
                                            <td>{{ date("d-m-Y", strtotime($TripTemp->dateFrom)) }}</td>
                                            <td>{{ date("d-m-Y", strtotime($TripTemp->dateTo)) }}</td>
                                            <td>{{ $TripTemp->advance }}</td>
                                            <td>{{ $TripTemp->totalKm }}</td>
                                            <td>{{ $TripTemp->Staff1['name'] }}</td>  
                                            <td>
                                                <form action="">
                                                    {{ csrf_field() }}
                                                    <input type="hidden" name="_method" value="DELETE">
                                                    <a href="{{ route('client.EditMemo',$TripTemp->id) }}" class="btn"><i class="fa fa-pencil text-aqua"></i></a>
                                                    <button href="" onclick="return confirm('Are you sure?')" class="btn"><i class="fa fa-trash-o"></i></button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <blockquote><p>No Temp Memo Sheet till now!!</p></blockquote>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection