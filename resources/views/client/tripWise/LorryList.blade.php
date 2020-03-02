@extends('client.layout.master')

@section('TripSheetMenu','active')

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
                        @if(!auth()->user()->vehicles->isEmpty())
                            <table  class="table table-bordered table-striped DataTableExport">
                                <thead>
                                    <tr>
                                        <th>Owner Name</th>
                                        <th>Vehicle Number</th>
                                        <th>Vehicle Name</th>
                                        <th>Total Km</th>
                                        <th>Total Diesel Amount</th>
                                        <th>Total Profit</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach(auth()->user()->vehicles as $Vehicle)
                                        <tr>
                                            <td>{{ $Vehicle->ownerName }}</td>
                                            <td>{{ $Vehicle->vehicleNumber }}</td>
                                            <td>{{ $Vehicle->vehicleName }}</td>
                                            <td>{{ $Vehicle->TripKm->sum('totalKm') }}</td>
                                            <td>{{ auth()->user()->getVehicleTotalDiesel($Vehicle->id)->sum('quantity') }}</td>
                                            <th style="color: green;">{{ round(auth()->user()->getVehicleTotalProfitAmount($Vehicle->id)) }}</th>
                                            <td>
                                                <a href="{{ route('client.ViewTripListVehicleWise',$Vehicle->id) }}" class="btn btn-primary btn-sm">View Trips</a>
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

@section('script')
<script type="text/javascript">
    $(document).ready(function() {
        $(".DataTableExport").DataTable({
            "order":[],
            dom: 'lBfrtip',
            lengthMenu: [ [10, 20, 50, -1], [10, 20, 50, "All"] ],
            pageLength: 10,
            responsive: false,
            columnDefs: [{ type: 'date-dd-mmm-yyyy', targets: 0 }],
            buttons: [
                   {
                      extend: 'excelHtml5',
                      filename: '{{ auth()->user()->name }}',
                      title:'{{ auth()->user()->transportName }}',
                  },
                  {
                      extend: 'pdfHtml5',
                      filename: '{{ auth()->user()->name }}',
                      title:'{{ auth()->user()->transportName }}',
                  },
                  {
                      extend: 'print',
                      title:'{{ auth()->user()->transportName }}',
                  }
            ]
        });
        $('.dt-buttons a').addClass('btn btn-info btn-sm');
    });
</script>

@endsection