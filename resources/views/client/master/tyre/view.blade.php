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
                        @if(!$Tyres->isEmpty())
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
                                    @foreach($Tyres as $Tyre)
                                        <tr>
                                            <td>{{ $Tyre->tyre_number }}</td>
                                            <td>{{ $Tyre->manufacture_company }}</td>
                                            <td>{{ $Tyre->purchased_from }}</td>
                                            <td>{{ $Tyre->tyre_status }}</td>
                                            <td>{{ !empty($Tyre->vehicleId)?$Tyre->vehicle->vehicleNumber:'NA' }}</td>
                                            <td>{{ $Tyre->condition }}</td>
                                            <td>
                                                <form action="" method="POST">
                                                    {{ csrf_field() }}
                                                    <input type="hidden" name="_method" value="DELETE">
                                                    <a href="#" class="btn"><i class="fa fa-eye text-aqua"></i></a>
                                                    <a href="{{ route('client.EditTyre',$Tyre->id) }}" class="btn"><i class="fa fa-pencil text-aqua"></i></a>
                                                    <button href="" onclick="return confirm('Are you sure?')" class="btn"><i class="fa fa-trash-o"></i></button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <blockquote><p>No Tyre till now added!!</p></blockquote>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection