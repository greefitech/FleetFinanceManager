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
                                    @if(!empty($Admin))
                                        <tr>
                                            <td>{{ $Admin->name }}</td>
                                            <td>
                                                @if($Admin->mobile != '' || NULL)
                                                    {{ $Admin->mobile }}
                                                @else
                                                    ---
                                                @endif
                                            </td>
                                            <td>
                                            <?php $sum = 0; ?>
                                            @foreach($Admin->ClientDetails as $ClientDetails)
                                                @foreach($ClientDetails->TotalIncome as $TotalIncome)
                                                    @php($sum += $TotalIncome->total_amount)
                                                @endforeach
                                            @endforeach
                                                {{ $sum }}
                                            </td>
                                            <?php $sub = 0; ?>
                                            @foreach($Admin->ClientDetails as $ClientDetails)
                                                @foreach($ClientDetails->TotalIncome as $TotalIncome)
                                                    @php($sub += $TotalIncome->paid_amount)
                                                @endforeach
                                            @endforeach
                                            <td>{{ $sub }}</td>
                                            <td>{{ $sum-$sub }}</td>
                                            <td>
                                                <a href="{{ route('admin.AdminClientWise',$Admin->id) }}"><button type="button" class="btn btn-success">View</button></a>
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