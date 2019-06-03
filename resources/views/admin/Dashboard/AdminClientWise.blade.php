@extends('admin.layout.master')


@section('content')

    <div class="row">
        <div class="col-xs-12">
            <div class="box box-info">
                <div class="box-header">
                    <h4>
                        <center>View Admin Wise</center>
                    </h4>
                    {{--                    <a href="{{ route('admin.adminAccountAdd') }}" class="btn btn-info pull-right">Add Admin</a>--}}
                </div>
                <div class="box-body">
                    <div class="table-responsive">
                        @if(!empty($Clients))
                            <table  class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Transport Name</th>
                                    <th>Mobile Number</th>
                                    <th>Address</th>
                                    <th>Vehicle Credit</th>
                                    <th>Total Amount</th>
                                    <th>Balance Amount</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>

                                @foreach($Clients as $Clients)
                                    @if(!empty($Clients))
                                        <tr>
                                            <td>{{ $Clients->name }}</td>
                                            <td>{{ $Clients->transportName }}</td>
                                            <td>{{ $Clients->mobile }}</td>
                                            <td>{{ $Clients->address }}</td>
                                            <td>{{ $Clients->vehicleCredit }}</td>
                                            <?php $sum = 0; ?>
                                            @foreach($Clients->TotalIncome as $TotalIncome)
                                                @php($sum += $TotalIncome->total_amount)
                                            @endforeach
                                                    <td>{{ $sum  }}</td>
                                                <?php $sub = 0; ?>
                                            @foreach($Clients->TotalIncome as $TotalIncome)
                                                @php($sub -= ($TotalIncome->paid_amount) - ($TotalIncome->total_amount))
                                            @endforeach
                                                <td>{{ $sub }}</td>

                                            <td>
                                                <a href=""><button type="button" class="btn btn-success">View</button></a>
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach

                                </tbody>
                            </table>
                        @else
                            <blockquote><p>No Admin Records!!</p></blockquote>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection