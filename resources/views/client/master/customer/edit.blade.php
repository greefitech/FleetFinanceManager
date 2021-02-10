@extends('client.layout.master')

@section('MasterMenu','active')

@push('BreadCrumbMenu')
   <li>Master</li>
   <li class="active"><a href="{{ action('ClientController\CustomerController@index') }}">Customer</a></li>
   <li>Edit</li>
@endpush

@section('content')

    <div class="row">
        <div class="col-xs-12">

            @component('client.layout.component.panel-head',['MenuTitle'=>'Customers','Title'=>'Customers Edit','color'=>env('TABPANELCOLOR')])
                @slot('Button')
                <a href="{{ action('ClientController\CustomerController@index') }}" class="btn btn-info pull-right">View Customer</a>
                @endslot

            
                    <form class="form-horizontal" method="post" action="{{ action('ClientController\CustomerController@update', $Customer->id) }}">
                        <input type="hidden" name="_method" value="PUT">
                        {{ csrf_field() }}
                        <div class="box-body">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                        <div class="col-sm-12">
                                            <label>Name <span style="color:red">*</span></label>
                                            <input type="text" class="form-control" min="0" value="{{ $Customer->name }}" placeholder="Enter Name" name="name">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group{{ $errors->has('mobile') ? ' has-error' : '' }}">
                                        <div class="col-sm-12">
                                            <label>Mobile <span style="color:red">*</span></label>
                                            <input type="text" id="number-only" class="form-control" maxlength="10" minlength="10" onkeypress="return isNumber(event)" value="{{ $Customer->mobile }}" placeholder="Enter Mobile Number" name="mobile">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group{{ $errors->has('address') ? ' has-error' : '' }}">
                                        <div class="col-sm-12">
                                            <label>Address <span style="color:red">*</span></label>
                                            <textarea name="address" class="form-control">{{ $Customer->address }}</textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group{{ $errors->has('type') ? ' has-error' : '' }}">
                                        <div class="col-sm-12">
                                            <label>Payment Status</label>
                                            <select class="form-control" name="type">
                                                <option value="broker" {{ ($Customer->type == 'broker')?'selected':'' }}>Broker</option>
                                                <option value="direct" {{ ($Customer->type == 'direct')?'selected':'' }}>Direct</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div align="center">
                                <button type="submit" class="btn btn-info">Update Customer</button>
                            </div>
                        </div>
                    </form>
                @endcomponent
        </div>
    </div>


@endsection
