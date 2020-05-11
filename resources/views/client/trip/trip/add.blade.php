@extends('client.layout.master')

@section('EntryMenu','active')

@section('content')

    <div class="row">
        <div class="col-xs-12">
            <div class="box box-info">
                <div class="box-header">
                    <h4>
                        <center>Add Trip</center>
                    </h4>
                </div>
                <div class="box-body">
                    <form class="form-horizontal" method="post" action="{{ route('client.SaveTrip') }}">
                        {{ csrf_field() }}
                        <div class="box-body">
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group{{ $errors->has('dateFrom') ? ' has-error' : '' }}">
                                        <div class="col-sm-12">
                                            <label>Date From <span style="color:red">*</span></label>
                                            <input type="date" class="form-control" value="{{ old('dateFrom') }}" placeholder="Enter Date" name="dateFrom">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group{{ $errors->has('dateTo') ? ' has-error' : '' }}">
                                        <div class="col-sm-12">
                                            <label>Date To <span style="color:red">*</span></label>
                                            <input type="date" class="form-control" value="{{ old('dateTo') }}" placeholder="Enter Date To" name="dateTo">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group{{ $errors->has('vehicleId') ? ' has-error' : '' }}">
                                        <div class="col-sm-12">
                                            <label>Vehicle <span style="color:red">*</span></label>
                                          <select name="vehicleId" class="form-control LastExpense select2 expense-vehicle AutoVehicle" id="entry-vehicle">
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group{{ $errors->has('startKm') ? ' has-error' : '' }}">
                                        <div class="col-sm-12">
                                            <label>Starting KM <span style="color:red">*</span></label>
                                            <input type="number" id="entry-startkm" class="form-control CalculateKm" value="{{ old('startKm') }}" placeholder="Enter Starting KM" name="startKm">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group{{ $errors->has('endKm') ? ' has-error' : '' }}">
                                        <div class="col-sm-12">
                                            <label>Ending KM <span style="color:red">*</span></label>
                                            <input type="number" id="entry-endkm" class="form-control CalculateKm" value="{{ old('endKm') }}" placeholder="Enter Ending KM" name="endKm">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group{{ $errors->has('totalKm') ? ' has-error' : '' }}">
                                        <div class="col-sm-12">
                                            <label>Total KM</label>
                                            <input type="number" id="entry-totalkm" class="form-control" value="{{ old('totalKm') }}" placeholder="Enter Total KM" name="totalKm" readonly="">
                                            <span id="ErrorTotal"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group{{ $errors->has('vehicleId') ? ' has-error' : '' }}">
                                        <div class="col-sm-12">
                                            <label>Staff 1 <span style="color:red">*</span></label>
                                            <select class="form-control select2 AutoStaff" name="staff1">
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group{{ $errors->has('vehicleId') ? ' has-error' : '' }}">
                                        <div class="col-sm-12">
                                            <label>Staff 2</label>
                                         <select class="form-control select2 AutoStaff" name="staff2">
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group{{ $errors->has('vehicleId') ? ' has-error' : '' }}">
                                        <div class="col-sm-12">
                                            <label>Staff 3</label>
                                       <select class="form-control select2 AutoStaff" name="staff3">
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group{{ $errors->has('advance') ? ' has-error' : '' }}">
                                        <div class="col-sm-12">
                                            <label>Advance</label>
                                            <input type="number" min="0" class="form-control" value="{{ old('advance') }}" placeholder="Enter Advance" name="advance">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div align="center">
                                <button type="submit" class="btn btn-info">Add Trip</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


@endsection

@section('script')

<script type="text/javascript">
$(document).ready(function(){

    $('.AutoVehicle').select2({
        placeholder: 'Select Vehicle',
        ajax: {
          url: '{{route("client.AutoVehicle")}}',
          dataType: 'json',
          delay: 250,
          processResults: function (data) {
            return {
              results:  $.map(data, function (item) {
                    return {
                        text: item.vehicleNumber,
                        id: item.id
                    }
                })
            };
          },
          cache: true
        }
      });

    $('.AutoStaff').select2({
        placeholder: 'Select Staff',
        ajax: {
          url: '{{route("client.AutoStaff")}}',
          dataType: 'json',
          delay: 250,
          processResults: function (data) {
            return {
              results:  $.map(data, function (item) {
                    return {
                        text: item.name+ ' | ' +item.mobile1,
                        id: item.id
                    }
                })
            };
          },
          cache: true
        }
      });  
  });
</script>

@endsection
