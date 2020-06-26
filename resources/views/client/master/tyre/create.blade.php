@extends('client.layout.master')

@section('MasterMenu')
active menu-open
@endsection

@section('content')

    <div class="row">
        <div class="col-xs-12">
          	@component('layouts.component.box-pannel',['title'=>'Service Details','color'=>env('TABPANELCOLOR')])
				<div class="row">
                    <div class="col-xs-12">
                        <center><h4>Create Tyre</h4></center>
                        <a href="{{ action('ClientController\Master\TyreController@index') }}" class="btn btn-info pull-right">View Tyre</a>
                    </div>
                </div>


                @if(isset($Tyre))
                    {!! Form::model($Tyre,['url' => action('ClientController\Master\TyreController@update',$Tyre->id),'method' => 'put']) !!}
                @else
                    {!! Form::open(['url' => action('ClientController\Master\TyreController@store'),'method' => 'post']) !!}
                @endif


                    <div class="row">
                    	 <div class="col-sm-6">
                            <div class="form-group{{ $errors->has('date') ? ' has-error' : '' }}">
                                <div class="col-sm-12">
                                    <label>Tyre Number</label>
                                    {!! Form::date('date', null, ['class' => 'form-control','placeholder' =>'Tyre Number']) !!}
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group{{ $errors->has('tyre_number') ? ' has-error' : '' }}">
                                <div class="col-sm-12">
                                    <label>Tyre Number</label>
                                    {!! Form::text('tyre_number', null, ['class' => 'form-control','placeholder' =>'Tyre Number']) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group{{ $errors->has('model') ? ' has-error' : '' }}">
                                <div class="col-sm-12">
                                    <label>Model</label>
                                    {!! Form::text('model', null, ['class' => 'form-control','placeholder' =>'Model Number']) !!}
                                </div>
                            </div>
                        </div>
                   
                        <div class="col-sm-6">
                            <div class="form-group{{ $errors->has('manufacture_company') ? ' has-error' : '' }}">
                                <div class="col-sm-12">
                                    <label>Manufacture Company</label>
                                    {!! Form::text('manufacture_company', null, ['class' => 'form-control','placeholder' =>'Manufacture Company']) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group{{ $errors->has('condition') ? ' has-error' : '' }}">
                                <div class="col-sm-12">
                                    <label>Condition</label>
                                    {!! Form::textArea('condition', null, ['class' => 'form-control','placeholder' =>'Tyre Condition','rows'=>3]) !!}
                                </div>
                            </div>
                        </div>
                   
                        <div class="col-sm-6">
                            <div class="form-group{{ $errors->has('original_depth') ? ' has-error' : '' }}">
                                <div class="col-sm-12">
                                    <label>Original Depth</label>
                                    {!! Form::text('original_depth', null, ['class' => 'form-control','placeholder' =>'Original Depth']) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group{{ $errors->has('current_depth') ? ' has-error' : '' }}">
                                <div class="col-sm-12">
                                    <label>Current Depth</label>
                                    {!! Form::text('current_depth', null, ['class' => 'form-control','placeholder' =>'Current Depth']) !!}
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group{{ $errors->has('purchased_from') ? ' has-error' : '' }}">
                                <div class="col-sm-12">
                                    <label>Purchased From</label>
                                    {!! Form::textArea('purchased_from', null, ['class' => 'form-control','placeholder' =>'Purchased Company','rows'=>3]) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                     <div align="center">
                @if(isset($Service))
                    <button type="submit" class="btn btn-info">Update</button>
                @else
                    <button type="submit" class="btn btn-info">Save</button>
                @endif

            {!! Form::close() !!}

            @endcomponent
        </div>
    </div>
@endsection