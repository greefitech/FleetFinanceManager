@extends('admin.layout.master')


@section('content')

    <div class="row">
        <div class="col-xs-12">
            <div class="box box-info">
                <div class="box-header">
                    <h4>
                        <center>View Admin Wise</center>
                    </h4>
                </div>
                <div class="box-body">
                    <div class="table-responsive">
                        @if(!empty($Admins))
                            <table  class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Mobile Number</th>
                                        <th>Total Amount</th>
                                        <th>Paid Amount</th>
                                        <th>Balance Amount</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($Admins as $Admin)
                                        <tr>
                                            <td>{{ $Admin->name }}</td>
                                            <td>{{ (!empty($Admin->mobile))?$Admin->mobile:'-' }}</td>
                                            <td>{{ AdminVehicleCredits($Admin->id)->sum('total_amount') }}</td>
                                            <td>{{ AdminVehicleCredits($Admin->id)->sum('paid_amount') }}</td>
                                            <td>{{ AdminVehicleCredits($Admin->id)->sum('total_amount') - AdminVehicleCredits($Admin->id)->sum('paid_amount') }}</td>
                                            <td>
                                                <a href="{{ route('admin.AdminClientWise',$Admin->id) }}"><button type="button" class="btn btn-success">View</button></a>
                                            </td>
                                        </tr>
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

@section('script')

    <script>

        $(document).ready(function() {
            var total_amount = $('#total_amount').text();
            var paid_amount = $('#paid_amount').text();
            var sum = parseInt(total_amount) - parseInt(paid_amount);
            $('#OutStanding').text(sum);
        });


    </script>

@endsection