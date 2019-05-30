@extends('client.layout.master')

@section('content')

    <div class="row">
        <div class="col-xs-12">
            <div class="box box-info">
                <div class="box-header">
                    <h4>
                        <center>Memo</center>
                    </h4>
                </div>
                <div class="box-body">
                    <form class="form-horizontal" method="post" action="{{ route('client.SaveMemo') }}">
                        {{ csrf_field() }}
                        <div class="box-body">
                            <div class="row">
                                <div class="col-sm-3">
                                    <div class="form-group{{ $errors->has('vehicleId') ? ' has-error' : '' }}">
                                        <div class="col-sm-12">
                                            <label>Vehicle / வண்டி எண் </label>
                                            <select class="form-control" name="vehicleId">
                                                <option value="">Select Vehicle</option>
                                                @foreach(Auth::user()->vehicles as $vehicle)
                                                    <option value="{{ $vehicle->id }}" {{ ($vehicle->id == old('vehicleId')) ?'selected':'' }}>{{ $vehicle->vehicleNumber }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group{{ $errors->has('dateFrom') ? ' has-error' : '' }}">
                                        <div class="col-sm-12">
                                            <label>Date / தேதி </label>
                                            <input type="date" class="form-control" value="{{ old('dateFrom') }}" placeholder="Enter Date" name="dateFrom">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group{{ $errors->has('dateTo') ? ' has-error' : '' }}">
                                        <div class="col-sm-12">
                                            <label>Date / தேதி </label>
                                            <input type="date" class="form-control" value="{{ old('dateTo') }}" placeholder="Enter Date To" name="dateTo">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group{{ $errors->has('advance') ? ' has-error' : '' }}">
                                        <div class="col-sm-12">
                                            <label>Advance / அட்வான்ஸ்</label>
                                            <input type="numbere" min="0" class="form-control" value="{{ old('advance') }}" placeholder="Enter Advance" name="advance">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-3">
                                    <div class="form-group{{ $errors->has('startKm') ? ' has-error' : '' }}">
                                        <div class="col-sm-12">
                                            <label>Starting KM / ஆரம்ப கிமீ</label>
                                            <input type="text" id="entry-startkm" class="form-control CalculateKm" value="{{ old('startKm') }}" placeholder="Enter Starting KM" name="startKm">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group{{ $errors->has('endKm') ? ' has-error' : '' }}">
                                        <div class="col-sm-12">
                                            <label>Ending KM / முடிவு கிமீ</label>
                                            <input type="text" id="entry-endkm" class="form-control CalculateKm" value="{{ old('endKm') }}" placeholder="Enter Ending KM" name="endKm">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group{{ $errors->has('totalKm') ? ' has-error' : '' }}">
                                        <div class="col-sm-12">
                                            <label>Total KM / ஓடிய கிமீ</label>
                                            <input type="text" id="entry-totalkm" class="form-control" value="{{ old('totalKm') }}" placeholder="Enter Total KM" name="totalKm" readonly="">
                                            <span id="ErrorTotal"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group{{ $errors->has('staff.0') ? ' has-error' : '' }}">
                                        <div class="col-sm-12">
                                            <label>First Driver / டிரைவர் பெயர் 1</label>
                                            <select name="staff[]" class="form-control" id="entry-staff1">
                                                <option value="">Select Staff</option>
                                                @foreach(Auth::user()->staffs as $staff)
                                                    <option value="{{ $staff->id }}" <?php if($staff->id==old('staff')[0]){ echo 'selected';}?>>{{ $staff->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label>Second Driver / டிரைவர் பெயர் 2</label>
                                            <select name="staff[]" class="form-control" id="entry-staff2">
                                                <option value="">Select Staff</option>
                                                @foreach(Auth::user()->staffs as $staff)
                                                    <option value="{{ $staff->id }}" <?php if($staff->id==old('staff')[1]){ echo 'selected';}?>>{{ $staff->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label>Select Cleaner / கிளீனர் பெயர்</label>
                                            <select name="staff[]" class="form-control" id="entry-staff3">
                                                <option value="">Select Staff</option>
                                                @foreach(Auth::user()->staffs as $staff)
                                                    <option value="{{ $staff->id }}" <?php if($staff->id==old('staff')[2]){ echo 'selected';}?>>{{ $staff->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Entry Data Start -->
                            <div class="row">
                                <div class="panel-group">
                                    <div class="panel panel-default">
                                        <div class="panel-heading"><span style="font-weight: bold;">Entry Data</span></div>
                                        <div class="panel-body">Panel Content</div>
                                    </div>
                                </div>
                            </div>
                            <!-- Entry Data Stop -->


                            <!-- Diesel Data Start -->
                            <div class="row">
                                <div class="panel-group">
                                    <div class="panel panel-primary">
                                        <div class="panel-heading"><span style="font-weight: bold;">டீசல்</span></div>
                                        <div class="panel-body">Panel Content</div>
                                    </div>
                                </div>
                            </div>
                            <!-- Diesel Data Stop -->





                            <br>
                            <div align="center">
                                <button type="submit" class="btn btn-info">Add Memo</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection