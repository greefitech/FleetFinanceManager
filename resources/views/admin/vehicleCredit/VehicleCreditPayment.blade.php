@extends('admin.layout.master')

@section('content')

    <div class="row">
        <div class="col-md-4 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-green"><i class="ion ion-ios-gear-outline"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Total Amount</span>
                    <span class="info-box-number"><center><span style="color: green;font-size: 30px" class="TotalVehicleCreditTotalAmount"></span></center></span>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-yellow"><i class="ion ion-ios-gear-outline"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Paid Amount</span>
                    <span class="info-box-number"><center><span style="color: green;font-size: 30px" class="TotalVehicleCreditPaidAmount"></span></center></span>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-red"><i class="ion ion-ios-gear-outline"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Remaining Amount</span>
                    <span class="info-box-number"><center><span style="color: green;font-size: 30px" class="TotalVehicleCreditBalanceAmount"></span></center></span>
                </div>
            </div>
        </div>
        <div class="clearfix visible-sm-block"></div>
    </div>

    <div class="row">
        <div class="col-xs-12">
            <div class="box box-info">
                <div class="box-header">
                    <h4>
                        <center>Add Vehicle Credit Payment</center>
                    </h4>
                    <a href="" class="btn btn-info pull-right">View Vehicle Credit</a>
                </div>

                <div class="box-body">
                    <form class="form-horizontal" action="{{route('admin.SaveVehicleCreditPayment') }}" method="POST">
                        {{ csrf_field() }}
                        <div class="box-body">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <div class="col-sm-6{{ $errors->has('client_id') ? ' has-error' : '' }}">
                                            <label>Select Client</label>
                                            <select class="form-control client_id" name="client_id">
                                                <option value="select" selected disabled>Select Client</option>
                                                @foreach($Clients as $Client)
                                                    <option value="{{ $Client->id }}">{{ $Client->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <div class="col-sm-4">
                                            <label>Balance Cost</label>
                                            <input class="form-control TotalBalanceAmount calculateValue" type="number"  Disabled>
                                        </div>
                                        <div class="col-sm-4{{ $errors->has('PaidAmount') ? ' has-error' : '' }}">
                                            <label>Receving Amount</label>
                                            <input class="form-control calculateValue" type="number" name="PaidAmount" min="0" value="{{ old('PaidAmount') }}">
                                        </div>
                                        <div class="col-sm-4">
                                            <label>Discount</label>
                                            <input class="form-control calculateValue" type="number" name="Discount" min="0" value="{{ old('Discount') }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div align="center">
                                <button type="submit" class="btn btn-info AddVehicleCreditPaymentButton">Add Vehicle Credit Payment</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')
    <script src="{{ url('/js/VehicleCreditPayment.js') }}"></script>
@endsection

