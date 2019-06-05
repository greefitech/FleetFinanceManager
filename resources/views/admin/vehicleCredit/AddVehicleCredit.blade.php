@extends('admin.layout.master')

@section('content')

    <div class="row">
        <div class="col-xs-12">
            <div class="box box-info">
                <div class="box-header">
                    <h4>
                        <center>Add Vehicle Credit</center>
                    </h4>
                    <a href="{{ route('admin.ClientList') }}" class="btn btn-info pull-right">View Vehicle Credit</a>
                </div>
                <div class="box-body">
                    <form class="form-horizontal" action="{{route('admin.SaveVehicleCredit') }}" method="POST">
                        {{ csrf_field() }}
                        <div class="box-body">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <div class="col-sm-6 {{ $errors->has('clientid') ? ' has-error' : '' }}">
                                            <label for="">Select Client</label>
                                            <select class="form-control" name="clientid">
                                                <option value="">Select Client</option>
                                                @foreach($Data['Clients'] as $client)
                                                    <option value="{{ $client->id }}">{{ $client->name }} | {{ $client->transportName }} | {{ $client->mobile }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-sm-6 {{ $errors->has('credit') ? ' has-error' : '' }}">
                                            <label>Credit Count</label>
                                            <input class="form-control calculateValue" type="number" min="1"  name="credit" id="VehicleCredit" value="{{ old('credit') }}" required="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <div class="col-sm-4{{ $errors->has('base_price') ? ' has-error' : '' }}">
                                            <label>Base Price</label>
                                            <input class="form-control calculateValue" type="number" min="1" value="{{ env('BASE_PRICE', '100') }}" name="base_price" id="basePrice"  required="">
                                        </div>
                                        <div class="col-sm-4">
                                            <label>Total Amount</label>
                                            <input class="form-control" type="number" min="1" id="totalAmount"  disabled>
                                        </div>
                                        <div class="col-sm-4{{ $errors->has('paid_amount') ? ' has-error' : '' }}">
                                            <label>Paid Amount</label>
                                            <input class="form-control" type="number" min="1"  name="paid_amount">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div align="center">
                                <button type="submit" class="btn btn-info">Add Vehicle Credit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')
    <script>

        $( document ).ready(function() {
            if ($('#VehicleCredit').val() != '') {
                var VehicleCredit = $('#VehicleCredit').val();
                var basePrice = $('#basePrice').val();
                var total = parseInt(basePrice) * parseInt(VehicleCredit);
                $('#totalAmount').val(total);
            }
        });

        $(".calculateValue").on("change paste keyup", function(e) {
            e.preventDefault();
            var VehicleCredit=$('#VehicleCredit').val();
            var basePrice=$('#basePrice').val();
            var total=parseInt(basePrice) * parseInt(VehicleCredit);
            $('#totalAmount').val(total);
        });

    </script>
@endsection