@extends('client.layout.master')

@section('content')


    <div class="row">
        <div class="col-xs-12">
            <div class="box box-info">
                <div class="box-header">
                    <h4>
                        <center>{{ $Vehicle->vehicleNumber }} Tyre Current Status</center>
                    </h4>
                </div>
                <div class="box-body">
                    <form class="form-horizontal" method="post" action="{{ route('client.SaveTyreCurrentStatusVehicle',[$Vehicle->id,$AssignedTyre->id]) }}">
                        {{ csrf_field() }}
                        <div class="box-body">
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group{{ $errors->has('transaction') ? ' has-error' : '' }}">
                                        <div class="col-sm-12">
                                            <label>Transaction</label>
                                            <input type="text" class="form-control" value="{{ old('transaction') }}" placeholder="Enter Transaction" name="transaction">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group{{ $errors->has('km') ? ' has-error' : '' }}">
                                        <div class="col-sm-12">
                                            <label>Current KM</label>
                                            <input type="text" class="form-control" value="{{ old('km') }}" placeholder="Enter Tyre KM" name="km">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group{{ $errors->has('current_depth') ? ' has-error' : '' }}">
                                        <div class="col-sm-12">
                                            <label>Current Depth</label>
                                            <input type="text" class="form-control" value="{{ old('current_depth') }}" placeholder="Enter Current Depth" name="current_depth">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group{{ $errors->has('staffId') ? ' has-error' : '' }}">
                                        <div class="col-sm-12">
                                            <label>Driver</label>
                                            <select name="staffId" class="form-control select2" id="entry-staff1">
                                                <option value="">Select Staff</option>
                                                @foreach(Auth::user()->staffs as $staff)
                                                    <option value="{{ $staff->id }}" {{ ($staff->id==old('staffId'))?'selected':'' }}>{{ $staff->name }} | {{ $staff->mobile1 }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group{{ $errors->has('note') ? ' has-error' : '' }}">
                                        <div class="col-sm-12">
                                            <label>Note</label>
                                            <textarea class="form-control" placeholder="Enter Note" name="note">{{ old('note') }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div align="center">
                                <button type="submit" class="btn btn-info">Tyre Status</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection