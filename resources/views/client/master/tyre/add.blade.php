@extends('client.layout.master')

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-info">
                <div class="box-header">
                    <h4>
                        <center>Add Tyre</center>
                    </h4>
                    <a href="{{ route('client.ViewTyres') }}" class="btn btn-info pull-right">View Tyre</a>
                </div>
                <div class="box-body">
                    <form class="form-horizontal" method="post" action="{{ route('client.SaveTyre') }}">
                        {{ csrf_field() }}
                        <div class="box-body">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group{{ $errors->has('tyre_number') ? ' has-error' : '' }}">
                                        <div class="col-sm-12">
                                            <label>Tyre Number</label>
                                            <input type="text" class="form-control" value="{{ old('tyre_number') }}" placeholder="Enter Tyre Number" name="tyre_number">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group{{ $errors->has('model') ? ' has-error' : '' }}">
                                        <div class="col-sm-12">
                                            <label>Model</label>
                                            <input type="text" class="form-control" value="{{ old('model') }}" placeholder="Enter Model Number" name="model">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group{{ $errors->has('manufacture_company') ? ' has-error' : '' }}">
                                        <div class="col-sm-12">
                                            <label>Manufacture Company</label>
                                            <input type="text" class="form-control" value="{{ old('manufacture_company') }}" placeholder="Enter Manufacture Company" name="manufacture_company">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group{{ $errors->has('condition') ? ' has-error' : '' }}">
                                        <div class="col-sm-12">
                                            <label>Condition</label>
                                            <textarea name="condition" class="form-control" placeholder="Tyre Condition">{{ old('condition') }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group{{ $errors->has('original_depth') ? ' has-error' : '' }}">
                                        <div class="col-sm-12">
                                            <label>Original Depth</label>
                                            <input type="text" class="form-control" value="{{ old('original_depth') }}" placeholder="Enter Original Depth" name="original_depth">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group{{ $errors->has('current_depth') ? ' has-error' : '' }}">
                                        <div class="col-sm-12">
                                            <label>Current Depth</label>
                                            <input type="text" class="form-control" value="{{ old('current_depth') }}" placeholder="Enter Current Depth" name="current_depth">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group{{ $errors->has('purchased_from') ? ' has-error' : '' }}">
                                        <div class="col-sm-12">
                                            <label>Purchased From</label>
                                            <textarea name="purchased_from" class="form-control" placeholder="purchased company">{{ old('purchased_from') }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div align="center">
                                <button type="submit" class="btn btn-info">Add Tyre</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


@endsection