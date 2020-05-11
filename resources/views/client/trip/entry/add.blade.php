 <span style="color:red">*</span>@extends('client.layout.master')

@section('EntryMenu','active')

@section('content')

    <div class="row">
        <div class="col-xs-12">
            <div class="box box-info">
                <div class="box-header">
                    <h4>
                        <center>Add Entry</center>
                    </h4>
                </div>
                <div class="box-body">
                    <form class="form-horizontal" method="post" action="{{ route('client.SaveEntry') }}">
                        {{ csrf_field() }}
                        <div class="box-body">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group{{ $errors->has('tripId') ? ' has-error' : '' }}">
                                        <div class="col-sm-12">
                                            <label>Trip <span style="color:red">*</span></label>
                                            <select name="tripId" class="form-control select2"  id="entry-trip">
                                                <option value="">Select Trip</option>
                                                @foreach(Auth::user()->NotCompletedTrips as $Trip)
                                                    <option value="{{ $Trip->id }}" {{ ($Trip->id == old('tripId'))?'selected':'' }}>{{ $Trip->vehicle->vehicleNumber }} | {{ $Trip->tripName }} | {{ date("d-m-Y", strtotime($Trip->dateFrom)) }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group{{ $errors->has('dateFrom') ? ' has-error' : '' }}">
                                        <div class="col-sm-12">
                                            <label>Date <span style="color:red">*</span></label>
                                            <input type="date" class="form-control" value="{{ old('dateFrom') }}" placeholder="Enter Date" name="dateFrom"  id="entry-dateFrom">
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
                                <div class="col-sm-4">
                                    <div class="form-group{{ $errors->has('customerId') ? ' has-error' : '' }}">
                                        <div class="col-sm-12">
                                            <label>Customer</label>
                                            <select name="customerId" class="form-control select2 AutoCustomer">
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group{{ $errors->has('staff.0') ? ' has-error' : '' }}">
                                        <div class="col-sm-12">
                                            <label>Staff 1 <span style="color:red">*</span></label>
                                            <select name="staff[]" class="form-control select2 AutoStaff" id="entry-staff1">
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label>Staff 2</label>
                                            <select name="staff[]" class="form-control select2 AutoStaff" id="entry-staff2">
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label>Staff 3</label>
                                            <select name="staff[]" class="form-control select2 AutoStaff" id="entry-staff3">
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group{{ $errors->has('locationFrom') ? ' has-error' : '' }}">
                                        <div class="col-sm-12">
                                            <label>Location From <span style="color:red">*</span></label>
                                            <input type="text" class="form-control" value="{{ old('locationFrom') }}" placeholder="Enter Location From" name="locationFrom">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group{{ $errors->has('locationTo') ? ' has-error' : '' }}">
                                        <div class="col-sm-12">
                                            <label>Location To <span style="color:red">*</span></label>
                                            <input type="text" class="form-control" value="{{ old('locationTo') }}" placeholder="Enter Location To" name="locationTo">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-8">
                                    <div class="form-group{{ $errors->has('loadType') ? ' has-error' : '' }}">
                                        <div class="col-sm-12">
                                            <label>Load Type <span style="color:red">*</span></label>
                                            <input type="text" class="form-control" value="{{ old('loadType') }}" placeholder="Enter Load Type" name="loadType">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group{{ $errors->has('ton') ? ' has-error' : '' }}">
                                        <div class="col-sm-12">
                                            <label>Tons <span style="color:red">*</span></label>
                                            <input type="number" class="form-control" step="0.01" value="{{ old('ton') }}" placeholder="Enter Location To" name="ton">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group{{ $errors->has('account_id') ? ' has-error' : '' }}">
                                        <div class="col-sm-12">
                                            <label>Payment Type</label>
                                            <select name="account_id" class="form-control">
                                                <option value="1">Cash</option>
                                                @foreach(Auth::user()->Accounts as $Account)
                                                    <option value="{{ $Account->id }}" {{ ($Account->id==old('account_id'))?'selected':'' }}>{{ $Account->account }} - {{ !empty($Account->HolderName)? $Account->HolderName:'' }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group{{ $errors->has('billAmount') ? ' has-error' : '' }}">
                                        <div class="col-sm-12">
                                            <label>Bill Amount <span style="color:red">*</span></label>
                                            <input type="number" class="form-control calculateEntryValue CalculateComission" min="0" value="{{ old('billAmount') }}" placeholder="Enter Bill Amount" name="billAmount"  id="entry-billAmount">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group{{ $errors->has('advance') ? ' has-error' : '' }}">
                                        <div class="col-sm-12">
                                            <label>Advance</label>
                                            <input type="number" class="form-control calculateEntryValue" min="0" value="{{ old('advance') }}" placeholder="Enter Advance" name="advance"  id="entry-advance">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group{{ $errors->has('driverPadi') ? ' has-error' : '' }}">
                                        <div class="col-sm-12">
                                            <label>Driver Padi (%) <span style="color:red">*</span></label>
                                            <input type="number" step="0.01" class="form-control" step="0.01" value="{{ old('driverPadi') }}" placeholder="Enter Driver Padi" name="driverPadi" id="entry-driverPadi">
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group{{ $errors->has('cleanerPadi') ? ' has-error' : '' }}">
                                        <div class="col-sm-12">
                                            <label>Cleaner Padi (%) <span style="color:red">*</span></label>
                                            <input type="number" step="0.01" class="form-control" min="0" value="{{ old('cleanerPadi') }}" placeholder="Enter Cleaner Padi" name="cleanerPadi" id="entry-cleanerPadi">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group{{ $errors->has('comissionPercentage') ? ' has-error' : '' }}">
                                        <div class="col-sm-12">
                                            <label>Comission Per(%)</label>
                                            <input type="number" class="form-control CalculateComission" min="0" max="100" value="{{ old('comissionPercentage') }}" placeholder="Enter Comission %" name="comissionPercentage" id="entry-comission-percentage">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group{{ $errors->has('comission') ? ' has-error' : '' }}">
                                        <div class="col-sm-12">
                                            <label>Comission
                                                <input type="radio" name="commission_status" value="1" checked><label>Paid</label>
                                                <input type="radio" name="commission_status" value="0"><label>Not Paid</label>
                                            </label>
                                            <input type="number" class="form-control calculateEntryValue" step="0.01" value="{{ old('comission') }}" placeholder="Enter Comission" name="comission" id="entry-comission">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group{{ $errors->has('loadingMamool') ? ' has-error' : '' }}">
                                        <div class="col-sm-12">
                                            <label>ஏற்றுக்கூலி
                                                <input type="radio" name="loading_mamool_status" value="1" checked><label>Paid</label>
                                                <input type="radio" name="loading_mamool_status" value="0"><label>Not Paid</label>
                                            </label>
                                            <input type="number" class="form-control calculateEntryValue" min="0" value="{{ old('loadingMamool') }}" placeholder="Enter ஏற்றுக்கூலி" name="loadingMamool" id="entry-loadingMamool">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group{{ $errors->has('unLoadingMamool') ? ' has-error' : '' }}">
                                        <div class="col-sm-12">
                                            <label>இறக்குக்கூலி
                                                <input type="radio" name="unloading_mamool_status" value="1" checked><label>Paid</label>
                                                <input type="radio" name="unloading_mamool_status" value="0"><label>Not Paid</label>
                                            </label>
                                            <input type="number" class="form-control calculateEntryValue" min="0" value="{{ old('unLoadingMamool') }}" placeholder="Enter இறக்குக்கூலி" name="unLoadingMamool" id="entry-unLoadingMamool">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group{{ $errors->has('balance') ? ' has-error' : '' }}">
                                        <div class="col-sm-12">
                                            <label>Balance</label>
                                            <input type="text" class="form-control" value="{{ old('balance') }}" id="entry_balance" name="balance" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div align="center">
                                <button type="submit" class="btn btn-info">Add Entry</button>
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

    $('.AutoCustomer').select2({
        placeholder: 'Select Customer',
        ajax: {
          url: '{{route("client.AutoCustomer")}}',
          dataType: 'json',
          delay: 250,
          processResults: function (data) {
            return {
              results:  $.map(data, function (item) {
                    return {
                        text: item.name+ ' | ' +item.mobile,
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
