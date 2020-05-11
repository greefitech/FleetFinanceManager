@extends('client.layout.master')

@section('EntryMenu','active')

@section('content')

    <div class="row">
        <div class="col-xs-12">
            <div class="box box-info">
                <div class="box-header">
                    <h4>
                        <center>Add Halt</center>
                    </h4>
                </div>
                <div class="box-body">
                    <form class="form-horizontal" method="post" action="{{ route('client.SaveHalt') }}">
                        {{ csrf_field() }}
                        <div class="box-body">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group{{ $errors->has('tripId') ? ' has-error' : '' }}">
                                        <div class="col-sm-12">
                                            <label>Trip <span style="color:red">*</span></label>
                                            <select name="tripId" class="form-control select2"  id="entry-trip">
                                                <option value="">Select Trip</option>
                                                @foreach(Auth::user()->NotCompletedTrips as $Trip)
                                                    <option value="{{ $Trip->id }}" {{ ($Trip->id == old('tripId'))?'selected':'' }}>{{ $Trip->vehicle->vehicleNumber }} - {{ $Trip->tripName }} - {{ $Trip->dateFrom }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group{{ $errors->has('date') ? ' has-error' : '' }}">
                                        <div class="col-sm-12">
                                            <label>Date <span style="color:red">*</span></label>
                                            <input type="date" class="form-control" value="{{ old('date') }}" placeholder="Enter Date" name="date" id="entry-dateFrom">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group{{ $errors->has('vehicleId') ? ' has-error' : '' }}">
                                        <div class="col-sm-12">
                                            <label>Vehicle <span style="color:red">*</span></label>
                                            <select name="vehicleId" class="form-control LastExpense select2 expense-vehicle AutoVehicle" id="entry-vehicle">
                                            </select>
                                        </div>
                                    </div>
                                </div>


                                <div class="col-sm-4">
                                    <div class="form-group{{ $errors->has('location') ? ' has-error' : '' }}">
                                        <div class="col-sm-12">
                                            <label>Location <span style="color:red">*</span></label>
                                            <input class="form-control" type="text" value="{{ old('location') }}" name="location">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group{{ $errors->has('reason') ? ' has-error' : '' }}">
                                        <div class="col-sm-12">
                                            <label>Reason</label>
                                            <input class="form-control" type="text" value="{{ old('reason') }}" name="reason">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">

                                <div class="col-sm-6">
                                    <div class="form-group{{ $errors->has('discription') ? ' has-error' : '' }}">
                                        <div class="col-sm-12">
                                            <label>Description</label>
                                            <textarea class="form-control" name="discription">{{ old('discription') }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <br>
                            <div align="center">
                                <button type="submit" class="btn btn-info">Add Halt</button>
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
  });
</script>

@endsection
