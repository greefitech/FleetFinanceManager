@extends('client.layout.master')

@section('MasterMenu','active')

@section('content')

    <div class="row">
        <div class="col-xs-12">
            <div class="box box-info">
                <div class="box-header">
                    <h4>
                        <center>Edit Staff</center>
                    </h4>
                    <a href="{{ action('ClientController\StaffController@index') }}" class="btn btn-info pull-right">View Staff</a>
                </div>
                <div class="box-body">
                    <form class="form-horizontal" method="post" action="{{ action('ClientController\StaffController@update',$staff->id) }}">
                        {{ csrf_field() }}
                        <input type="hidden" name="_method" value="PUT">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                        <div class="col-sm-12">
                                            <label>Name</label>
                                            <input type="text" class="form-control" min="0" value="{{ $staff->name }}" placeholder="Enter Name" name="name">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group{{ $errors->has('mobile1') ? ' has-error' : '' }}">
                                        <div class="col-sm-12">
                                            <label>Mobile 1</label>
                                            <input type="number" class="form-control" maxlength="10" minlength="10" onkeypress="return isNumber(event)" value="{{ $staff->mobile1 }}" placeholder="Enter Mobile Number" name="mobile1">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group{{ $errors->has('mobile2') ? ' has-error' : '' }}">
                                        <div class="col-sm-12">
                                            <label>Mobile 2</label>
                                            <input type="number" class="form-control" maxlength="10" minlength="10" onkeypress="return isNumber(event)" value="{{ $staff->mobile2 }}" placeholder="Enter Mobile Number" name="mobile2">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group{{ $errors->has('address') ? ' has-error' : '' }}">
                                        <div class="col-sm-12">
                                            <label>Address</label>
                                            <textarea name="address" class="form-control">{{ $staff->address }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group{{ $errors->has('licenceNumber') ? ' has-error' : '' }}">
                                        <div class="col-sm-12">
                                            <label>Licence Number</label>
                                            <input type="text" class="form-control" value="{{ $staff->licenceNumber }}" placeholder="Enter Licence Number" name="licenceNumber">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group{{ $errors->has('licenceRenewal') ? ' has-error' : '' }}">
                                        <div class="col-sm-12">
                                            <label>Licence Reniwal</label>
                                            <input type="date" class="form-control" value="{{ $staff->licenceRenewal }}" placeholder="Enter Licence Number" name="licenceRenewal">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group{{ $errors->has('type') ? ' has-error' : '' }}">
                                        <div class="col-sm-12">
                                            <label>Type</label>
                                            <select class="form-control" name="type">
                                                <option value="">Select Type</option>
                                                <option value="cleaner" {{ ($staff->type == 'cleaner')?'selected':'' }}>Cleaner</option>
                                                <option value="driver" {{ ($staff->type == 'driver')?'selected':'' }}>Driver</option>
                                                <option value="manager" {{ ($staff->type == 'manager')?'selected':'' }}>Manager</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div align="center">
                                <button type="submit" class="btn btn-info">Update Staff</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


@endsection