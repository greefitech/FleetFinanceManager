@extends('client.layout.master')

@section('content')


    <div class="row">
        <div class="col-xs-12">
            <div class="box box-info">
                <div class="box-header">
                    <h4>
                        <center>Edit Entry</center>
                    </h4>
                </div>
                <div class="box-body">
                    <form class="form-horizontal" method="post" action="{{ route('client.UpdateEntry',$Entry->id) }}">
                        {{ csrf_field() }}
                        <div class="box-body">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group{{ $errors->has('tripId') ? ' has-error' : '' }}">
                                        <div class="col-sm-12">
                                            <label>Trip</label>
                                            <select name="tripId" class="form-control"  id="entry-trip">
                                                <option value="">Select Trip</option>
                                                @foreach(Auth::user()->NotCompletedTrips as $Trip)
                                                    <option value="{{ $Trip->id }}" {{ ($Trip->id == $Entry->tripId)?'selected':'' }}>{{ $Trip->vehicle->vehicleNumber }} - {{ $Trip->tripName }} - {{ $Trip->dateFrom }}</option>
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
                                            <label>Date</label>
                                            <input type="date" class="form-control" value="{{ $Entry->dateFrom }}" placeholder="Enter Date" name="dateFrom"  id="entry-dateFrom">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group{{ $errors->has('vehicleId') ? ' has-error' : '' }}">
                                        <div class="col-sm-12">
                                            <label>Vehicle</label>
                                            <select name="vehicleId" class="form-control" id="entry-vehicle">
                                                <option value="">Select Vehicle</option>
                                                @foreach(Auth::user()->vehicles as $vehicle)
                                                    <option value="{{ $vehicle->id }}" {{ ($vehicle->id==$Entry->vehicleId)?'selected':'' }}>{{ $vehicle->vehicleNumber }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group{{ $errors->has('customerId') ? ' has-error' : '' }}">
                                        <div class="col-sm-12">
                                            <label>Customer</label>
                                            <select name="customerId" class="form-control">
                                                <option value="">Select Customer</option>
{{--                                                <option value="">ADD NEW CUSTOMER</option>--}}
                                                @foreach(Auth::user()->customers as $customer)
                                                    <option value="{{ $customer->id }}" {{ ($customer->id==$Entry->customerId)?'selected':'' }}>{{ $customer->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>




                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group{{ $errors->has('staff.0') ? ' has-error' : '' }}">
                                        <div class="col-sm-12">
                                            <label>Staff 1</label>
                                            <select name="staff[]" class="form-control" id="entry-staff1">
                                                <option value="">Select Staff</option>
                                                @foreach(Auth::user()->staffs as $staff)
                                                    <option value="{{ $staff->id }}" <?php if($staff->id == $Trip->staff1){ echo 'selected';}?>>{{ $staff->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label>Staff 2</label>
                                            <select name="staff[]" class="form-control" id="entry-staff2">
                                                <option value="">Select Staff</option>
                                                @foreach(Auth::user()->staffs as $staff)
                                                    <option value="{{ $staff->id }}" <?php if($staff->id == $Trip->staff2){ echo 'selected';}?>>{{ $staff->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label>Staff 3</label>
                                            <select name="staff[]" class="form-control" id="entry-staff3">
                                                <option value="">Select Staff</option>
                                                @foreach(Auth::user()->staffs as $staff)
                                                    <option value="{{ $staff->id }}" <?php if($staff->id == $Trip->staff3){ echo 'selected';}?>>{{ $staff->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group{{ $errors->has('locationFrom') ? ' has-error' : '' }}">
                                        <div class="col-sm-12">
                                            <label>Location From</label>
                                            <input type="text" class="form-control" value="{{ $Entry->locationFrom }}" placeholder="Enter Location From" name="locationFrom">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group{{ $errors->has('locationTo') ? ' has-error' : '' }}">
                                        <div class="col-sm-12">
                                            <label>Location To</label>
                                            <input type="text" class="form-control" value="{{ $Entry->locationTo }}" placeholder="Enter Location To" name="locationTo">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-8">
                                    <div class="form-group{{ $errors->has('loadType') ? ' has-error' : '' }}">
                                        <div class="col-sm-12">
                                            <label>Load Type</label>
                                            <input type="text" class="form-control" value="{{ $Entry->loadType }}" placeholder="Enter Load Type" name="loadType">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group{{ $errors->has('ton') ? ' has-error' : '' }}">
                                        <div class="col-sm-12">
                                            <label>Tons</label>
                                            <input type="number" class="form-control" step="0.01" value="{{ $Entry->ton }}" placeholder="Enter Location To" name="ton">
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
                                                    <option value="{{ $Account->id }}" {{ ($Account->id==$Entry->account_id)?'selected':'' }}>{{ $Account->account }} - {{ !empty($Account->HolderName)? $Account->HolderName:'' }}</option>
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
                                            <label>Bill Amount</label>
                                            <input type="number" class="form-control calculateEntryValue CalculateComission" min="0" value="{{ $Entry->billAmount }}" placeholder="Enter Bill Amount" name="billAmount"  id="entry-billAmount">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group{{ $errors->has('advance') ? ' has-error' : '' }}">
                                        <div class="col-sm-12">
                                            <label>Advance</label>
                                            <input type="number" class="form-control calculateEntryValue" min="0" value="{{ $Entry->advance }}" placeholder="Enter Advance" name="advance"  id="entry-advance">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group{{ $errors->has('driverPadi') ? ' has-error' : '' }}">
                                        <div class="col-sm-12">
                                            <label>Driver Padi (%)</label>
                                            <input type="number" step="0.01" class="form-control" step="0.01" value="{{ $Entry->driverPadi }}" placeholder="Enter Driver Padi" name="driverPadi" id="entry-driverPadi">
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group{{ $errors->has('cleanerPadi') ? ' has-error' : '' }}">
                                        <div class="col-sm-12">
                                            <label>Cleaner Padi (%)</label>
                                            <input type="number" step="0.01" class="form-control" min="0" value="{{ $Entry->cleanerPadi }}" placeholder="Enter Cleaner Padi" name="cleanerPadi" id="entry-cleanerPadi">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group{{ $errors->has('comissionPercentage') ? ' has-error' : '' }}">
                                        <div class="col-sm-12">
                                            <label>Comission Per(%)</label>
                                            <input type="number" class="form-control CalculateComission" min="0" max="100" placeholder="Enter Comission %" name="comissionPercentage" id="entry-comission-percentage">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group{{ $errors->has('comission') ? ' has-error' : '' }}">
                                        <div class="col-sm-12">
                                            <label>Comission</label>
                                            <input type="number" class="form-control calculateEntryValue" step="0.01" value="{{ $Entry->comission }}" placeholder="Enter Comission" name="comission" id="entry-comission">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group{{ $errors->has('loadingMamool') ? ' has-error' : '' }}">
                                        <div class="col-sm-12">
                                            <label>ஏற்றுக்கூலி</label>
                                            <input type="number" class="form-control calculateEntryValue" min="0" value="{{ $Entry->loadingMamool }}" placeholder="Enter ஏற்றுக்கூலி" name="loadingMamool" id="entry-loadingMamool">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group{{ $errors->has('unLoadingMamool') ? ' has-error' : '' }}">
                                        <div class="col-sm-12">
                                            <label>இறக்குக்கூலி</label>
                                            <input type="number" class="form-control calculateEntryValue" min="0" value="{{ $Entry->unLoadingMamool }}" placeholder="Enter இறக்குக்கூலி" name="unLoadingMamool" id="entry-unLoadingMamool">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group{{ $errors->has('balance') ? ' has-error' : '' }}">
                                        <div class="col-sm-12">
                                            <label>Balance</label>
                                            <input type="text" class="form-control" value="{{ $Entry->balance }}" id="entry_balance" name="balance" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div align="center">
                                <button type="submit" class="btn btn-info">Update Entry</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


@endsection