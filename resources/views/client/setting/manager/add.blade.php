@extends('client.layout.master')

@section('content')


    <div class="row">
        <div class="col-xs-12">
            <div class="box box-info">
                <div class="box-header">
                    <h4>
                        <center>Add Manager</center>
                    </h4>
                    <a href="{{ route('client.ViewManagers') }}" class="btn btn-info pull-right">View Manager</a>
                </div>
                <div class="box-body">
                    <form class="form-horizontal" method="post" action="{{ route('client.SaveManager') }}">
                        {{ csrf_field() }}
                        <div class="box-body">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                        <div class="col-sm-12">
                                            <label>Name</label>
                                            <input type="text" class="form-control" value="{{ old('name') }}" placeholder="Manager Name" name="name">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                        <div class="col-sm-12">
                                            <label>Email</label>
                                            <input type="email" class="form-control" value="{{ old('email') }}" placeholder="Enter Email" name="email">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group{{ $errors->has('mobile') ? ' has-error' : '' }}">
                                        <div class="col-sm-12">
                                            <label>Mobile</label>
                                            <input type="text" minlength="10" maxlength="10" class="form-control" value="{{ old('mobile') }}" placeholder="Manager Mobile" name="mobile">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group{{ $errors->has('manager_vehicle_id') ? ' has-error' : '' }}">
                                        <div class="col-sm-12">
                                            <label>Vehicle</label>
                                            <select name="manager_vehicle_id[]" class="form-control select2" multiple>
                                                @foreach(Auth::user()->vehicles as $vehicle)
                                                    <option value="{{ $vehicle->id }}" {{ !empty(old('manager_vehicle_id'))?in_array($vehicle->id,old('manager_vehicle_id'))?'selected':'':'' }}>{{ $vehicle->vehicleNumber }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                        <div class="col-sm-12">
                                            <label>Password</label>
                                            <input type="password" class="form-control" placeholder="Enter Password" name="password">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                                        <div class="col-sm-12">
                                            <label>Confirm Password</label>
                                            <input type="password" class="form-control" placeholder="Enter Password" name="password_confirmation">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <br>
                            <div align="center">
                                <button type="submit" class="btn btn-info">Add Manager</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


@endsection