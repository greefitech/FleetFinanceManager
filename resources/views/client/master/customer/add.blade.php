@extends('client.layout.master')

@section('content')


    <div class="row">
        <div class="col-xs-12">
            <div class="box box-info">
                <div class="box-header">
                    <h4>
                        <center>Add Customer</center>
                    </h4>
                    <a href="{{ action('ClientController\CustomerController@index') }}" class="btn btn-info pull-right">View Customer</a>
                </div>
                <div class="box-body">
                    <form class="form-horizontal" method="post" action="{{ action('ClientController\CustomerController@store') }}">
                        {{ csrf_field() }}
                        <div class="box-body">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                        <div class="col-sm-12">
                                            <label>Name</label>
                                            <input type="text" class="form-control" min="0" value="{{ old('name') }}" placeholder="Enter Name" name="name">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group{{ $errors->has('mobile') ? ' has-error' : '' }}">
                                        <div class="col-sm-12">
                                            <label>Mobile</label>
                                            <input type="number" class="form-control" onkeypress="return isNumber(event)" oninput="maxLengthCheck(this)" maxlength = "10" value="{{ old('mobile') }}" placeholder="Enter Mobile Number" name="mobile">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group{{ $errors->has('address') ? ' has-error' : '' }}">
                                        <div class="col-sm-12">
                                            <label>Address</label>
                                            <textarea name="address" class="form-control">{{ old('address') }}</textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group{{ $errors->has('type') ? ' has-error' : '' }}">
                                        <div class="col-sm-12">
                                            <label>Payment Status</label>
                                            <select class="form-control" name="type">
                                                <option value="broker">Broker</option>
                                                <option value="direct">Direct</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div align="center">
                                <button type="submit" class="btn btn-info">Add Customer</button>
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