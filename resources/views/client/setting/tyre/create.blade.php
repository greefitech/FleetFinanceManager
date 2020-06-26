@extends('client.layout.master')

@section('setting')
active menu-open
@endsection

@section('content')

    <div class="row">
        <div class="col-xs-12">
          	@component('layouts.component.box-pannel',['title'=>'Service Details','color'=>env('TABPANELCOLOR')])
                <div class="row">
                    <div class="col-xs-12">
                        <center><h4>{{ $Vehicle->vehicleNumber }} Tyre Add</h4></center>
                    </div>
                </div>
            {!! Form::open(['url' => action('ClientController\Setting\TyreController@update',$Vehicle->id),'method' => 'put']) !!}

                <div class="box-body">
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group{{ $errors->has('tyre_id') ? ' has-error' : '' }}">
                                <div class="col-sm-12">
                                    <label>Tyre Number</label>
                                    <select name="tyre_id" id="tyre_id" class="form-control select2">
                                        @foreach(GetNonUsedTyreList(auth()->user()->id) as $key =>$ClientTyreList)
                                            <option value="{{ $ClientTyreList->id }}" {{ ($ClientTyreList->id == old('tyre_id')) ?'selected':'' }}>{{ $ClientTyreList->tyre_number }} | {{ $ClientTyreList->manufacture_company }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group{{ $errors->has('position') ? ' has-error' : '' }}">
                                <div class="col-sm-12">
                                    <label>Position</label>
                                    <select class="form-control select2" name="position">
                                        <option value="">Select Position</option>
                                        @for($i = 1;$i<=$Vehicle->GetVehicleType->wheel/2;$i++)
                                            <option value="r{{ $i }}">Right {{ $i }}</option>
                                        @endfor
                                        @for($i = 1;$i<=$Vehicle->GetVehicleType->wheel/2;$i++)
                                            <option value="l{{ $i }}">Left {{ $i }}</option>
                                        @endfor
                                        <option value="Stepney">Stepney</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group{{ $errors->has('km') ? ' has-error' : '' }}">
                                <div class="col-sm-12">
                                    <label>Current KM</label>
                                    {!! Form::text('km', null, ['class' => 'form-control','placeholder' =>'Tyre KM']) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group{{ $errors->has('current_depth') ? ' has-error' : '' }}">
                                <div class="col-sm-12">
                                    <label>Current Depth</label>
                                    {!! Form::text('current_depth', null, ['class' => 'form-control','placeholder' =>'Current Depth']) !!}
                                </div>
                            </div>
                        </div>

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
                                    {!! Form::textArea('note', null, ['class' => 'form-control','placeholder' =>'Note','rows'=>4]) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div align="center">
                        <button type="submit" class="btn btn-info">Assign Tyre</button>
                    </div>
                </div>
                {!! Form::close() !!}
             
            @endcomponent
        </div>
    </div>

    

@endsection


