@extends('client.layout.master')

@section('content')

    <div class="row">
        <div class="col-xs-12">
            <div class="box box-info">
                <div class="box-header">
                    <h4>
                        <center>{{ $Trip->vehicle->vehicleNumber }} - {{ $Trip->tripName }} Entry List</center>
                    </h4>
                </div>
                <div class="box-body">
                    <div class="table-responsive">
                        @if(!empty($Entries))
                            <table  class="table table-bordered table-striped DataTable">
                                <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Customer</th>
                                    <th>Location From</th>
                                    <th>Location To</th>
                                    <th>Load</th>
                                    <th>Bill Amount</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($Entries as $Entry)
                                    <tr>
                                        <td>{{ date("d-m-Y", strtotime($Entry->dateFrom)) }}</td>
                                        <td>{{ $Entry->customer->name }}</td>
                                        <td>{{ $Entry->locationFrom }}</td>
                                        <td>{{ $Entry->locationTo }}</td>
                                        <td>{{ $Entry->loadType }}</td>
                                        <td>{{ $Entry->billAmount }}</td>
                                        <td>
                                            <form action="{{ route('client.DeleteEntry',$Entry->id) }}" method="POST">
                                                {{ csrf_field() }}
                                                <input type="hidden" name="_method" value="DELETE">
                                                <a href="" class="btn"><i class="fa fa-pencil text-aqua"></i></a>
                                                <button href="" onclick="return confirm('Are you sure?')" class="btn"><i class="fa fa-trash-o"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        @else
                            <blockquote><p>No Entry till now added!!</p></blockquote>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection