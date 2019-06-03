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

                    <form class="form-horizontal" action="{{route('admin.SaveSettlement') }}" method="POST">
                        {{ csrf_field() }}

                        <div class="box-body">
                            <div class="row">
                                <div class="container">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <div class="col-sm-6">
                                                <label>Total Cost</label>
                                                <?php $sum = 0; ?>
                                                @foreach($Data['Clients'] as $Clients)
                                                    @foreach($Clients->TotalIncome as $TotalIncome)
                                                        @php($sum += $TotalIncome->total_amount)
                                                    @endforeach
                                                @endforeach
                                                <input class="form-control calculateValue" type="number" min="1"  name="credit" id="VehicleCredit" value="{{ $sum }}" Disabled>
                                            </div>

                                            <div class="col-sm-6{{ $errors->has('settled_amount') ? ' has-error' : '' }}">
                                                <label>Settlement Amount</label>
                                                <input class="form-control calculateValue" type="number" name="settled_amount" id="settlement_amount" min="1" max="{{ $sum }}" value="{{ old('settlement_amount') }}" required="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="container">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <button type="submit" class="btn btn-success btn-block">Save</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
