@extends('client.layout.master')


@section('SettingMenu','active')

@section('content')


    <div class="row">
        <div class="col-xs-12">
            <div class="box box-info">
                <div class="box-header">
                    <h4>
                        <center>{{ $Vehicle->vehicleNumber }} Assign Vehicle Tyre</center>
                    </h4>
                </div>
                <div class="box-body">
                    <form class="form-horizontal" method="post" action="{{ route('client.UpdateVehicleAssignTyre',[$Vehicle->id,$AssignTyre->id]) }}">
                        {{ csrf_field() }}
                        <div class="box-body">
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group{{ $errors->has('tyre_id') ? ' has-error' : '' }}">
                                        <div class="col-sm-12">
                                            <label>Tyre Number</label>
                                            <select name="tyre_id" id="tyre_id" class="form-control select2">
                                                @if(!empty($AssignTyre->tyre_id))
                                                    <option value="{{ $AssignTyre->tyre_id }}">{{ $AssignTyre->Tyre->tyre_number }} | {{ $AssignTyre->Tyre->manufacture_company }}</option>
                                                    <option value="">Remove Tyre</option>
                                                @else
                                                    @foreach(GetNonUsedTyreList(auth()->user()->id) as $key =>$ClientTyreList)
                                                        <option value="{{ $ClientTyreList->id }}">{{ $ClientTyreList->tyre_number }} | {{ $ClientTyreList->manufacture_company }}</option>
                                                    @endforeach
                                                @endif
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
                                                    <option value="r{{ $i }}" {{ ($AssignTyre->position == 'r'.$i)?'selected':'' }}>Right {{ $i }}</option>
                                                @endfor
                                                @for($i = 1;$i<=$Vehicle->GetVehicleType->wheel/2;$i++)
                                                    <option value="l{{ $i }}" {{ ($AssignTyre->position == 'l'.$i)?'selected':'' }}>Left {{ $i }}</option>
                                                @endfor
                                                <option value="stepney" {{ ($AssignTyre->position == 'Stepney')?'selected':'' }}>Stepney</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group{{ $errors->has('km') ? ' has-error' : '' }}">
                                        <div class="col-sm-12">
                                            <label>Current KM</label>
                                            <input type="text" class="form-control" value="{{ old('km') }}" placeholder="Enter Tyre KM" name="km">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group{{ $errors->has('current_depth') ? ' has-error' : '' }}">
                                        <div class="col-sm-12">
                                            <label>Current Depth</label>
                                            <input type="text" class="form-control" value="{{ old('current_depth') }}" placeholder="Enter Current Depth" name="current_depth">
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
                                                    <option value="{{ $staff->id }}">{{ $staff->name }} | {{ $staff->mobile1 }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group{{ $errors->has('note') ? ' has-error' : '' }}">
                                        <div class="col-sm-12">
                                            <label>Note</label>
                                            <textarea class="form-control" placeholder="Enter Note" name="note">{{ old('note') }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div align="center">
                                <button type="submit" class="btn btn-info">Assign Tyre</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection