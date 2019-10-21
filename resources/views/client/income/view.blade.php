@extends('client.layout.master')

@section('content')

    <div class="row">
        <div class="col-xs-12">
            <div class="box box-info">
                <div class="box-header">
                    <h4>
                        <center>Incomes</center>
                    </h4>
                </div>
                <div class="box-body">
                    <div class="table-responsive">
                        @if(!auth()->user()->incomes->isEmpty())
                        <table  class="table table-bordered table-striped DataTable">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Vehicle</th>
                                    <th>Customer</th>
                                    <th>Amount</th>
                                    <th>Received By</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach(auth()->user()->incomes as $Income)
                                    <tr>
                                        <td>{{ date("d-m-Y", strtotime($Income->date)) }}</td>
                                        <td>{{ $Income->vehicle->vehicleNumber }}</td>
                                        <td>{{ $Income->customer->name }}</td>
                                        <td>{{ $Income->recevingAmount }}</td>
                                        <td>{{ (!empty($Income->managerid))?$Income->manager->name:auth()->user()->name }}</td>
                                        <td>
                                            <form action="{{ route('client.DeleteIncome',$Income->id) }}" method="POST">
                                                {{ csrf_field() }}
                                                <input type="hidden" name="_method" value="DELETE">
                                                <a href="{{ route('client.EditIncome',$Income->id) }}" class="btn"><i class="fa fa-pencil text-aqua"></i></a>
                                                <button href="" onclick="return confirm('Are you sure?')" class="btn"><i class="fa fa-trash-o"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @else
                            <blockquote><p>No Customer Income Balance till now!!</p></blockquote>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection