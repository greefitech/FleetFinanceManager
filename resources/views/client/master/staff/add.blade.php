@extends('client.layout.master')

@section('MasterMenu','active')

@section('content')

    <div class="row">
        <div class="col-xs-12">
            <div class="box box-info">
                <div class="box-header">
                    <h4>
                        <center>Add Staff</center>
                    </h4>
                    <a href="{{ action('ClientController\StaffController@index') }}" class="btn btn-info pull-right">View Staff</a>
                </div>
                <div class="box-body">
                    <form class="form-horizontal" method="post" action="{{ action('ClientController\StaffController@store') }}">
                        {{ csrf_field() }}
                        <div class="box-body">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                        <div class="col-sm-12">
                                            <label>Name <span style="color:red">*</span></label>
                                            <input type="text" class="form-control" min="0" value="{{ old('name') }}" placeholder="Enter Name" name="name">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group{{ $errors->has('mobile1') ? ' has-error' : '' }}">
                                        <div class="col-sm-12">
                                            <label>Mobile 1 <span style="color:red">*</span></label>
                                            <input type="text" id="number-only" class="form-control" oninput="maxLengthCheck(this)" maxlength = "10" value="{{ old('mobile1') }}" placeholder="Enter Mobile Number" name="mobile1">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group{{ $errors->has('mobile2') ? ' has-error' : '' }}">
                                        <div class="col-sm-12">
                                            <label>Mobile 2</label>
                                            <input type="text" id="number-only" class="form-control" oninput="maxLengthCheck(this)" maxlength = "10" value="{{ old('mobile2') }}" placeholder="Enter Mobile Number" name="mobile2">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group{{ $errors->has('address') ? ' has-error' : '' }}">
                                        <div class="col-sm-12">
                                            <label>Address <span style="color:red">*</span></label>
                                            <textarea name="address" class="form-control">{{ old('address') }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group{{ $errors->has('licenceNumber') ? ' has-error' : '' }}">
                                        <div class="col-sm-12">
                                            <label>Licence Number <span style="color:red">*</span></label>
                                            <input type="text" class="form-control" value="{{ old('licenceNumber') }}" placeholder="Enter Licence Number" name="licenceNumber">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group{{ $errors->has('licenceRenewal') ? ' has-error' : '' }}">
                                        <div class="col-sm-12">
                                            <label>Licence Renewal</label>
                                            <input type="date" class="form-control" min="{{ date('Y-m-d') }}" value="{{ old('licenceRenewal') }}" placeholder="Enter Licence Number" name="licenceRenewal">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group{{ $errors->has('type') ? ' has-error' : '' }}">
                                        <div class="col-sm-12">
                                            <label>Type <span style="color:red">*</span></label>
                                            <select class="form-control" name="type">
                                                <option value="">Select Type</option>
                                                <option value="cleaner" {{ (old('type') == 'cleaner')?'selected':'' }}>Cleaner</option>
                                                <option value="driver" {{ (old('type') == 'driver')?'selected':'' }}>Driver</option>
                                                <option value="manager" {{ (old('type') == 'manager')?'selected':'' }}>Manager</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div align="center">
                                <button type="submit" class="btn btn-info">Add Staff</button>
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
 
  function maxLengthCheck(object)
  {
    if (object.value.length > object.maxLength)
      object.value = object.value.slice(0, object.maxLength)
  }
</script>

@endsection