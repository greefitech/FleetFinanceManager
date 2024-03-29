@extends('client.layout.master')

@section('MasterMenu','active')

@push('BreadCrumbMenu')
   <li>Master</li>
   <li class="active"><a href="{{ action('ClientController\CustomerController@index') }}">Customer</a></li>
   <li>Create</li>
@endpush

@section('content')


    <div class="row">
        <div class="col-xs-12">

            @component('client.layout.component.panel-head',['MenuTitle'=>'Customers Create','Title'=>'Customers List','color'=>env('TABPANELCOLOR')])
                @slot('Button')
                <a href="{{ action('ClientController\CustomerController@index') }}" class="btn btn-info pull-right">View Customer</a>
                @endslot


          
                    <form class="form-horizontal" method="post" action="{{ action('ClientController\CustomerController@store') }}">
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
                                    <div class="form-group{{ $errors->has('mobile') ? ' has-error' : '' }}">
                                        <div class="col-sm-12">
                                            <label>Mobile <span style="color:red">*</span></label>
                                            <input type="text" id="number-only" class="form-control" onkeypress="return isNumber(event)" oninput="maxLengthCheck(this)" maxlength = "10" value="{{ old('mobile') }}" placeholder="Enter Mobile Number" name="mobile">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group{{ $errors->has('address') ? ' has-error' : '' }}">
                                        <div class="col-sm-12">
                                            <label>Address <span style="color:red">*</span></label>
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
                @endcomponent
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