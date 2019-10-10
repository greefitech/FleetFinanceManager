@extends('client.layout.master')

@section('content')

    <div class="row">
        <div class="col-xs-12">
            <div class="box box-info">
                <div class="box-header">
                    <h4>
                        <center>Memo</center>
                    </h4>
                </div>
                <div class="box-body">
                    <form class="form-horizontal" method="post" action="{{ route('client.SaveMemo') }}">
                        {{ csrf_field() }}
                        <div class="box-body">
                            <!-- Trip Start -->
                                <div class="row">
                                    <div class="col-sm-3">
                                        <div class="form-group{{ $errors->has('vehicleId') ? ' has-error' : '' }}">
                                            <div class="col-sm-12">
                                                <label>Vehicle / வண்டி எண் </label>
                                                <select class="form-control select2 VehicleChange GetLastKm" name="vehicleId">
                                                    <option value="">Select Vehicle</option>
                                                    @foreach(Auth::user()->vehicles as $vehicle)
                                                        <option value="{{ $vehicle->id }}" {{ ($vehicle->id == old('vehicleId')) ?'selected':'' }}>{{ $vehicle->vehicleNumber }} - {{ $vehicle->ownerName }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group{{ $errors->has('dateFrom') ? ' has-error' : '' }}">
                                            <div class="col-sm-12">
                                                <label>Date / தேதி </label>
                                                <input type="date" class="form-control DateChanges dateFrom" value="{{ old('dateFrom') }}" placeholder="Enter Date" name="dateFrom">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group{{ $errors->has('dateTo') ? ' has-error' : '' }}">
                                            <div class="col-sm-12">
                                                <label>Date / தேதி </label>
                                                <input type="date" class="form-control DateChanges dateTo" value="{{ old('dateTo') }}" placeholder="Enter Date To" name="dateTo">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group{{ $errors->has('advance') ? ' has-error' : '' }}">
                                            <div class="col-sm-12">
                                                <label>Advance / அட்வான்ஸ்</label>
                                                <input type="numbere" min="0" class="form-control" value="{{ old('advance') }}" placeholder="Enter Advance" name="advance" id="advance">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-3">
                                        <div class="form-group{{ $errors->has('startKm') ? ' has-error' : '' }}">
                                            <div class="col-sm-12">
                                                <label>Starting KM / ஆரம்ப கிமீ</label>
                                                <input type="text" id="entry-startkm" class="form-control CalculateKm"  value="{{ old('startKm') }}" placeholder="Enter Starting KM" name="startKm" >
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group{{ $errors->has('endKm') ? ' has-error' : '' }}">
                                            <div class="col-sm-12">
                                                <label>Ending KM / முடிவு கிமீ</label>
                                                <input type="text" id="entry-endkm" class="form-control CalculateKm" value="{{ old('endKm') }}" placeholder="Enter Ending KM" name="endKm">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group{{ $errors->has('totalKm') ? ' has-error' : '' }}">
                                            <div class="col-sm-12">
                                                <label>Total KM / ஓடிய கிமீ</label>
                                                <input type="text" id="entry-totalkm" class="form-control" value="{{ old('totalKm') }}" placeholder="Enter Total KM" name="totalKm" readonly="">
                                                <span id="ErrorTotal"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group{{ $errors->has('staff.0') ? ' has-error' : '' }}">
                                            <div class="col-sm-12">
                                                <label>First Driver / டிரைவர் பெயர் 1</label>
                                                <select name="staff[]" class="form-control select2 Driverchange" id="entry-staff1">
                                                    <option value="">Select Staff</option>
                                                    @foreach(Auth::user()->staffs as $staff)
                                                        <option value="{{ $staff->id }}" {{ ($staff->id==old('staff')[0])?'selected':'' }}>{{ $staff->name }} | {{ $staff->mobile1 }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>Second Driver / டிரைவர் பெயர் 2</label>
                                                <select name="staff[]" class="form-control select2" id="entry-staff2">
                                                    <option value="">Select Staff</option>
                                                    @foreach(Auth::user()->staffs as $staff)
                                                        <option value="{{ $staff->id }}"{{ ($staff->id==old('staff')[1])?'selected':'' }}>{{ $staff->name }} | {{ $staff->mobile1 }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>Select Cleaner / கிளீனர் பெயர்</label>
                                                <select name="staff[]" class="form-control select2" id="entry-staff3">
                                                    <option value="">Select Staff</option>
                                                    @foreach(Auth::user()->staffs as $staff)
                                                        <option value="{{ $staff->id }}"{{ ($staff->id==old('staff')[2])?'selected':'' }}>{{ $staff->name }} | {{ $staff->mobile1 }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <!-- Trip End -->

                            <!-- Entry Data Start -->
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="panel-group">
                                        <div class="panel panel-info">
                                            <div class="panel-heading">
                                                <span style="font-weight: bold;">Entry Data
                                                    <button type="button" class="btn btn-success btn-sm pull-right AddEntryInput" style="margin-top:-5px;"><i class="fa fa-plus"></i></button>
                                                </span>
                                            </div>
                                            <div class="panel-body table-responsive">

                                                <table  class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th>Date / தேதி</th>
                                                            <th>Customer</th>
                                                            <th>Source / புறப்படுமிடம்</th>
                                                            <th>Destination / சேருமிடம்</th>
                                                            <th>Load / லோடு</th>
                                                            <th>Ton/டன்</th>
                                                            <th>Account Type</th>
                                                            <th>Bill Amount</th>
                                                            <th>Advance / வரவு</th>
                                                            <th>Commission / கமிஷன்</th>
                                                            <th>Driver Padi (%)</th>
                                                            <th>Cleaner Padi (%)</th>
                                                            <th>Driver Padi</th>
                                                            <th>Cleaner Padi</th>
                                                            <th>Export / ஏற்றுமதிக்கூலி</th>
                                                            <th>Import / இறக்குமதிக்கூலி</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="EntryTableData">
                                                        @if(!empty(old('EntryData')))
                                                            @foreach(old('EntryData')['dateFrom'] as $EntryKey=>$Entry)
                                                                <tr>
                                                                    <td class="{{ $errors->has('EntryData.dateFrom.'.$EntryKey) ? ' has-error' : '' }}">
                                                                        <input type="date" class="form-control DateValue" value="{{ old('EntryData')['dateFrom'][$EntryKey] }}" placeholder="Enter Date" name="EntryData[dateFrom][]" style="width:15em">
                                                                    </td>
                                                                    <td class="{{ $errors->has('EntryData.customerId.'.$EntryKey) ? ' has-error' : '' }}">
                                                                        <select name="EntryData[customerId][]" class="form-control select2" style="width:15em">
                                                                            <option value="">Select Customer</option>
                                                                            @foreach(auth()->user()->customers as $customer)
                                                                                <option value="{{ $customer->id }}" {{ ($customer->id==old('EntryData')['customerId'][$EntryKey])?'selected':'' }}>{{ $customer->name }} | {{ $customer->mobile }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </td>
                                                                    <td class="{{ $errors->has('EntryData.locationFrom.'.$EntryKey) ? ' has-error' : '' }}">
                                                                        <input type="text" class="form-control" placeholder="Enter Location" value="{{ old('EntryData')['locationFrom'][$EntryKey] }}" name="EntryData[locationFrom][]" style="width:15em">
                                                                    </td>
                                                                    <td class="{{ $errors->has('EntryData.locationTo.'.$EntryKey) ? ' has-error' : '' }}">
                                                                        <input type="text" class="form-control" placeholder="Enter Location" value="{{ old('EntryData')['locationTo'][$EntryKey] }}" name="EntryData[locationTo][]" style="width:15em">
                                                                    </td>
                                                                    <td class="{{ $errors->has('EntryData.loadType.'.$EntryKey) ? ' has-error' : '' }}">
                                                                        <input type="text" class="form-control" placeholder="Enter Load type" value="{{ old('EntryData')['loadType'][$EntryKey] }}" name="EntryData[loadType][]" style="width:15em">
                                                                    </td>
                                                                    <td class="{{ $errors->has('EntryData.ton.'.$EntryKey) ? ' has-error' : '' }}">
                                                                        <input type="number" min="0" step="0.01" class="form-control" value="{{ old('EntryData')['ton'][$EntryKey] }}" placeholder="Enter Ton" name="EntryData[ton][]" style="width:10em">
                                                                    </td>
                                                                    <td class="{{ $errors->has('EntryData.account_id.'.$EntryKey) ? ' has-error' : '' }}">
                                                                        <select name="EntryData[account_id][]" class="form-control" style="width:10em">
                                                                            <option value="1">Cash</option>
                                                                            @foreach(Auth::user()->Accounts as $Account)
                                                                                <option value="{{ $Account->id }}" {{ ($Account->id == old('EntryData')['account_id'][$EntryKey])? 'selected':''}} >{{ $Account->account }} - {{ $Account->HolderName }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </td>
                                                                    <td class="{{ $errors->has('EntryData.billAmount.'.$EntryKey) ? ' has-error' : '' }}">
                                                                        <input type="number" min="0"  class="form-control BillAmountValue" placeholder="Enter Bill Amount" value="{{ old('EntryData')['billAmount'][$EntryKey] }}" name="EntryData[billAmount][]" style="width:10em">
                                                                    </td>
                                                                    <td class="{{ $errors->has('EntryData.advance.'.$EntryKey) ? ' has-error' : '' }}">
                                                                        <input type="number" min="0" class="form-control AdvanceAmountTotal" placeholder="Enter Advance" value="{{ old('EntryData')['advance'][$EntryKey] }}" name="EntryData[advance][]" style="width:10em">
                                                                    </td>
                                                                    <td class="{{ $errors->has('EntryData.comission.'.$EntryKey) ? ' has-error' : '' }}">
                                                                        <input type="number" min="0" class="form-control ComissionValue" placeholder="Enter Comission" value="{{ old('EntryData')['comission'][$EntryKey] }}" name="EntryData[comission][]" style="width:10em">
                                                                        <input type="radio" class="commission_status_class" name="EntryData[commission_status][{{$EntryKey}}]" value="1" {{ (old('EntryData')['commission_status'][$EntryKey] == 1)?'checked':'' }}><label>Paid</label>
                                                                        <input type="radio" class="commission_status_class" name="EntryData[commission_status][{{$EntryKey}}]" value="0" {{ (old('EntryData')['commission_status'][$EntryKey] == 0)?'checked':'' }}><label>Not Paid</label>
                                                                    </td>
                                                                    <td class="{{ $errors->has('EntryData.driverPadi.'.$EntryKey) ? ' has-error' : '' }}">
                                                                        <input type="number" min="0" max="100" step="0.01" class="form-control DriverPadiPercentage" placeholder="Enter driver paadi" value="{{ old('EntryData')['driverPadi'][$EntryKey] }}" name="EntryData[driverPadi][]" style="width:10em">
                                                                    </td>
                                                                    <td class="{{ $errors->has('EntryData.cleanerPadi.'.$EntryKey) ? ' has-error' : '' }}">
                                                                        <input type="number" min="0" max="100" step="0.01" class="form-control CleanerPadiPercentage"  placeholder="Enter cleaner paadi" value="{{ old('EntryData')['cleanerPadi'][$EntryKey] }}" name="EntryData[cleanerPadi][]" style="width:10em">
                                                                    </td>
                                                                    <td class="{{ $errors->has('EntryData.driverPadiAmount.'.$EntryKey) ? ' has-error' : '' }}">
                                                                        <input type="number" min="0" step="0.01"  class="form-control DriverPadiAmountValue" placeholder="Enter driver paadi amount" value="{{ old('EntryData')['driverPadiAmount'][$EntryKey] }}" name="EntryData[driverPadiAmount][]" style="width:10em" readonly>
                                                                    </td>
                                                                    <td class="{{ $errors->has('EntryData.cleanerPadiAmount.'.$EntryKey) ? ' has-error' : '' }}">
                                                                        <input type="number" min="0" step="0.01" class="form-control CleanerPadiAmountValue" placeholder="Enter cleaner paadi amount" value="{{ old('EntryData')['cleanerPadiAmount'][$EntryKey] }}" name="EntryData[cleanerPadiAmount][]" style="width:10em" readonly>
                                                                    </td>

                                                                    <td class="{{ $errors->has('EntryData.loadingMamool.'.$EntryKey) ? ' has-error' : '' }}">
                                                                        <input type="number" min="0" class="form-control loadingMamoolValue" placeholder="Enter Loading" value="{{ old('EntryData')['loadingMamool'][$EntryKey] }}" name="EntryData[loadingMamool][]" style="width:10em">
                                                                        <input type="radio" class="loading_mamool_status_class" name="EntryData[loading_mamool_status][{{$EntryKey}}]" value="1" {{ (old('EntryData')['loading_mamool_status'][$EntryKey] == 1)?'checked':'' }}><label>Paid</label>
                                                                        <input type="radio" class="loading_mamool_status_class" name="EntryData[loading_mamool_status][{{$EntryKey}}]" value="0" {{ (old('EntryData')['loading_mamool_status'][$EntryKey] == 0)?'checked':'' }}><label>Not Paid</label>
                                                                    </td>
                                                                    <td class="{{ $errors->has('EntryData.unLoadingMamool.'.$EntryKey) ? ' has-error' : '' }}">
                                                                        <input type="number" min="0" class="form-control unLoadingMamoolValue" placeholder="Enter Unloading" value="{{ old('EntryData')['unLoadingMamool'][$EntryKey] }}" name="EntryData[unLoadingMamool][]" style="width:10em">
                                                                        <input type="radio" class="unloading_mamool_status_class" name="EntryData[unloading_mamool_status][{{$EntryKey}}]" value="1" {{ (old('EntryData')['unloading_mamool_status'][$EntryKey] == 1)?'checked':'' }}><label>Paid</label>
                                                                        <input type="radio" class="unloading_mamool_status_class" name="EntryData[unloading_mamool_status][{{$EntryKey}}]" value="0" {{ (old('EntryData')['unloading_mamool_status'][$EntryKey] == 0)?'checked':'' }}><label>Not Paid</label>
                                                                    </td>
                                                                    <td><i style="color: red;" class="fa fa-close RemoveEntryDataInput"></i></td>
                                                                </tr>
                                                            @endforeach
                                                        @endif
                                                    </tbody>
                                                    <tr>
                                                        <th colspan="7">Total</th>
                                                        <th id="BillAmountTotalAmount"></th>
                                                        <th id="AdvanceAmountTotalAmount"></th>
                                                        <th id="ComissionTotalAmount"></th>
                                                        <th></th>
                                                        <th></th>
                                                        <th id="DriverPadiTotalAmount"></th>
                                                        <th id="CleanerPadiTotalAmount"></th>
                                                        <th id="loadingTotalAmount"></th>
                                                        <th id="UnloadingTotalAmount"></th>
                                                        <th></th>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Entry Data Stop -->


                            <!-- Diesel Data Start -->
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="panel-group">
                                        <div class="panel panel-primary">
                                            <div class="panel-heading">
                                                <span style="font-weight: bold;">டீசல்
                                                    <button type="button" class="btn btn-success btn-sm pull-right AddDiseleInput" style="margin-top:-5px;"><i class="fa fa-plus"></i></button>
                                                </span>
                                            </div>
                                            <div class="panel-body table-responsive">
                                                <table  class="table table-bordered">
                                                    <thead>
                                                    <tr>
                                                        <th>Date / தேதி</th>
                                                        <th>Location / இடம்</th>
                                                        <th>Bunk / Description</th>
                                                        <th>Litre / லிட்டர்</th>
                                                        <th>Total Cost / விலை</th>
                                                        <th>Account Type</th>
                                                        <th>Payment Status</th>
                                                        <th>Action</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody class="DieselTableData">
                                                        @if(!empty(old('DieselData')))
                                                            @foreach(old('DieselData')['date'] as $DiselKey=>$Dis)
                                                                <tr>
                                                                    <td class="{{ $errors->has('DieselData.date.'.$DiselKey) ? ' has-error' : '' }}">
                                                                        <input type="date" class="form-control DateValue" placeholder="Enter date" value="{{ old('DieselData')['date'][$DiselKey] }}" name="DieselData[date][]">
                                                                    </td>
                                                                    <td class="{{ $errors->has('DieselData.location.'.$DiselKey) ? ' has-error' : '' }}">
                                                                        <input type="text" class="form-control" placeholder="Enter Location" value="{{ old('DieselData')['location'][$DiselKey] }}" name="DieselData[location][]">
                                                                    </td>
                                                                    <td class="{{ $errors->has('DieselData.discription.'.$DiselKey) ? ' has-error' : '' }}">
                                                                        <input type="text" class="form-control" placeholder="Enter Description" value="{{ old('DieselData')['discription'][$DiselKey] }}" name="DieselData[discription][]">
                                                                    </td>
                                                                    <td class="{{ $errors->has('DieselData.quantity.'.$DiselKey) ? ' has-error' : '' }}">
                                                                        <input type="number" min="0" step="0.01" class="form-control DieselDataQuantityValue" value="{{ old('DieselData')['quantity'][$DiselKey] }}" placeholder="Enter Quantity" name="DieselData[quantity][]">
                                                                    </td>
                                                                    <td class="{{ $errors->has('DieselData.amount.'.$DiselKey) ? ' has-error' : '' }}">
                                                                        <input type="text" class="form-control DieselDataAmountValue" placeholder="Enter Amount" value="{{ old('DieselData')['amount'][$DiselKey] }}" name="DieselData[amount][]">
                                                                    </td>
                                                                    <td class="{{ $errors->has('DieselData.account_id.'.$DiselKey) ? ' has-error' : '' }}">
                                                                        <select name="DieselData[account_id][]" class="form-control select2">
                                                                            <option value="1">Cash</option>
                                                                            @foreach(Auth::user()->Accounts as $Account)
                                                                                <option value="{{ $Account->id }}" {{ ($Account->id == old('DieselData')['account_id'][$DiselKey])? 'selected':''}} >{{ $Account->account }} - {{ $Account->HolderName }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </td>
                                                                    <td class="{{ $errors->has('DieselData.status.'.$DiselKey) ? ' has-error' : '' }}">
                                                                        <select class="form-control" name="DieselData[status][]">
                                                                            <option value="1" {{ (old('DieselData')['status'][$DiselKey]==1)?'selected':'' }}>Paid</option>
                                                                            <option value="0" {{ (old('DieselData')['status'][$DiselKey]==0)?'selected':'' }}>Not Paid</option>
                                                                        </select>
                                                                    </td>
                                                                    <td><i style="color: red;" class="fa fa-close RemoveDieselInput"></i></td>
                                                                </tr>
                                                            @endforeach
                                                        @endif
                                                    </tbody>
                                                    <tr>
                                                        <th colspan="3">Total</th>
                                                        <th id="DieselLitreTotalSpentAmount"></th>
                                                        <th id="DieselCostTotalSpentAmount"></th>
                                                        <th></th>
                                                        <th></th>
                                                        <th></th>
                                                        <th></th>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Diesel Data Stop -->


                            <!-- RTO PC Start -->
                            <div class="row">
                                <!-- RTO Start -->
                                <div class="col-sm-6">
                                    <div class="panel-group">
                                        <div class="panel panel-info">
                                            <div class="panel-heading">
                                                <div class="row">
                                                    <div class="col-sm-3">
                                                        <h5 style="font-weight: bold;">RTO</h5>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <select class="form-control RTOMasterDatas">
                                                            <option value="">Master Data</option>
                                                            @foreach($RTOMasters as $RTOMaster)
                                                                @if($RTOMaster->type == 'rto')
                                                                    <option value="{{ $RTOMaster->id }}">{{ $RTOMaster->place }}</option>
                                                                @endif
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <button type="button" class="btn btn-primary btn-sm pull-right AddRTOInput" style="margin-top:-5px;"><i class="fa fa-plus"></i></button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="panel-body table-responsive">
                                                <table  class="table table-bordered">
                                                    <thead>
                                                    <tr>
                                                        <th>Location / இடம்</th>
                                                        <th>Cost / ரூ.</th>
                                                        <th>Action</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody class="RTOTableData">
                                                        @if(!empty(old('RTOData')))
                                                            @foreach(old('RTOData')['location'] as $RTOKey=>$PcD)
                                                                <tr>
                                                                    <td class="{{ $errors->has('RTOData.location.'.$RTOKey) ? ' has-error' : '' }}">
                                                                        <input type="text" class="form-control" style="width: 15em" placeholder="Enter Location" value="{{ old('RTOData')['location'][$RTOKey] }}" name="RTOData[location][]">
                                                                    </td>
                                                                    <td class="{{ $errors->has('RTOData.amount.'.$RTOKey) ? ' has-error' : '' }}">
                                                                        <input type="text" class="form-control RTODataAmountValue" style="width: 15em" placeholder="Enter Amount" value="{{ old('RTOData')['amount'][$RTOKey] }}" name="RTOData[amount][]">
                                                                    </td>
                                                                    <td class="RemoveRToInput" style="font-size: 18px;"><i style="color: red;" class="fa fa-close fa-10x"></i></td>
                                                                </tr>
                                                            @endforeach
                                                        @endif
                                                    </tbody>
                                                    <tr>
                                                        <th>Total</th>
                                                        <th id="RTOTotalSpentAmount"></th>
                                                        <th></th>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- RTO End -->

                                <!-- PC End -->
                                <div class="col-sm-6">
                                    <div class="panel-group">
                                        <div class="panel panel-success">
                                            <div class="panel-heading">

                                                <div class="row">
                                                    <div class="col-sm-3">
                                                        <h5 style="font-weight: bold;">PC</h5>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <select class="form-control PCMasterDatas">
                                                            <option value="">Master Data</option>
                                                            @foreach($RTOMasters as $RTOMaster)
                                                                @if($RTOMaster->type == 'pc')
                                                                    <option value="{{ $RTOMaster->id }}">{{ $RTOMaster->place }}</option>
                                                                @endif
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <button type="button" class="btn btn-success btn-sm pull-right AddPCInput" style="margin-top:-5px;"><i class="fa fa-plus"></i></button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="panel-body table-responsive">
                                                <table  class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th>Location / இடம்</th>
                                                            <th>Cost / ரூ.</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="PCTableData">
                                                        @if(!empty(old('PCData')))
                                                            @foreach(old('PCData')['location'] as $PCKey=>$PcD)
                                                                <tr>
                                                                    <td class="{{ $errors->has('PCData.location.'.$PCKey) ? ' has-error' : '' }}">
                                                                        <input type="text" class="form-control" style="width: 15em" value="{{ old('PCData')['location'][$PCKey] }}" placeholder="Enter Location" name="PCData[location][]">
                                                                    </td>
                                                                    <td class="{{ $errors->has('PCData.amount.'.$PCKey) ? ' has-error' : '' }}">
                                                                        <input type="number" min="0" style="width: 15em" class="form-control PCAmountValue" value="{{ old('PCData')['amount'][$PCKey] }}" placeholder="Enter Amount" name="PCData[amount][]">
                                                                    </td>
                                                                    <td><i style="color: red;" class="fa fa-close RemovePcInput"></i></td>
                                                                </tr>
                                                            @endforeach
                                                        @endif
                                                    </tbody>
                                                    <tr>
                                                        <th>Total</th>
                                                        <th id="PCTotalSpentAmount"></th>
                                                        <th></th>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- PC End -->
                            </div>
                            <!-- RTO PC Stop -->



                            <!-- Expense Data Start -->
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="panel-group">
                                        <div class="panel panel-primary">
                                            <div class="panel-heading">
                                                <span style="font-weight: bold;">Extra Expenses
                                                    <button type="button" class="btn btn-success btn-sm pull-right AddExtraExpenseInput" style="margin-top:-5px;"><i class="fa fa-plus"></i></button>
                                                </span>
                                            </div>
                                            <div class="panel-body table-responsive">
                                                <table  class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th>Expenses Type</th>
                                                            <th>Quantity</th>
                                                            <th>Location</th>
                                                            <th>Cost / ரூ.</th>
                                                            <th>Note</th>
                                                            <th>Account</th>
                                                            <th>Status</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="ExtraExpenseTableData">
                                                        @if(!empty(old('ExtraExpense')))
                                                            @foreach(old('ExtraExpense')['expense_type'] as $ExpenseKey=>$PcD)
                                                                <tr>
                                                                    <td class="{{ $errors->has('ExtraExpense.expense_type.'.$ExpenseKey) ? ' has-error' : '' }}">
                                                                        <select name="ExtraExpense[expense_type][]" class="form-control">
                                                                            <option value="">Select Expense</option>
                                                                            @foreach(GetExpenseTypes() as $ExpenseType)
                                                                                <option value="{{ $ExpenseType->id }}" {{ ($ExpenseType->id == old('ExtraExpense')['expense_type'][$ExpenseKey])?'selected':'' }}>{{ $ExpenseType->expenseType }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </td>
                                                                    <td class="{{ $errors->has('ExtraExpense.quantity.'.$ExpenseKey) ? ' has-error' : '' }}">
                                                                        <input type="number" min="0" class="form-control" name="ExtraExpense[quantity][]" value="{{ old('ExtraExpense')['quantity'][$ExpenseKey] }}">
                                                                    </td>
                                                                    <td class="{{ $errors->has('ExtraExpense.location.'.$ExpenseKey) ? ' has-error' : '' }}">
                                                                        <input type="text" class="form-control" name="ExtraExpense[location][]" value="{{ old('ExtraExpense')['location'][$ExpenseKey] }}">
                                                                    </td>
                                                                    <td class="{{ $errors->has('ExtraExpense.amount.'.$ExpenseKey) ? ' has-error' : '' }}">
                                                                        <input type="number" min="0" class="form-control ExtraExpenseAmountValue" name="ExtraExpense[amount][]" value="{{ old('ExtraExpense')['amount'][$ExpenseKey] }}">
                                                                    </td>
                                                                    <td class="{{ $errors->has('ExtraExpense.discription.'.$ExpenseKey) ? ' has-error' : '' }}">
                                                                        <input type="text" class="form-control" name="ExtraExpense[discription][]" value="{{ old('ExtraExpense')['discription'][$ExpenseKey] }}">
                                                                    </td>
                                                                    <td class="{{ $errors->has('ExtraExpense.account_id.'.$ExpenseKey) ? ' has-error' : '' }}">
                                                                        <select name="ExtraExpense[account_id][]" class="form-control">
                                                                            <option value="1">Cash</option>
                                                                            @foreach(Auth::user()->Accounts as $Account)
                                                                                <option value="{{ $Account->id }}" {{ ($Account->id == old('ExtraExpense')['account_id'][$ExpenseKey])? 'selected':''}} >{{ $Account->account }} - {{ $Account->HolderName }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </td>
                                                                    <td class="{{ $errors->has('ExtraExpense.status.'.$ExpenseKey) ? ' has-error' : '' }}">
                                                                        <select class="form-control" name="ExtraExpense[status][]">
                                                                            <option value="1" {{ (old('ExtraExpense')['status'][$ExpenseKey]==1)?'selected':'' }}>Paid</option>
                                                                            <option value="0" {{ (old('ExtraExpense')['status'][$ExpenseKey]==0)?'selected':'' }}>Not Paid</option>
                                                                        </select>
                                                                    </td>
                                                                    <td><i style="color: red;" class="fa fa-close RemoveExtraExpenseInput"></i></td>
                                                                </tr>
                                                            @endforeach
                                                        @endif
                                                    </tbody>
                                                    <tr>
                                                        <th colspan="3">Total</th>
                                                        <th id="ExtraExpenseTotalSpentAmount"></th>
                                                        <th></th>
                                                        <th></th>
                                                        <th></th>
                                                        <th></th>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Expense Data Stop -->


                            <!-- Paalam / Tolls Data Start -->
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="panel-group">
                                        <div class="panel panel-warning">
                                            <div class="panel-heading"><span style="font-weight: bold;">Paalam / Tollgate
                                                <button type="button" class="btn btn-primary btn-sm pull-right AddPalamTollInput" style="margin-top:-5px;"><i class="fa fa-plus"></i></button>
                                                </span></div>
                                            <div class="panel-body table-responsive">
                                                <table  class="table table-bordered">
                                                    <thead>
                                                    <tr>
                                                        <th>Location</th>
                                                        <th>Cost / ரூ.</th>
                                                        <th>Account</th>
                                                        <th>Action</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody class="PaalamTollTableData">
                                                    @if(!empty(old('PaalamToll')))
                                                        @foreach(old('PaalamToll')['location'] as $PaalamTollKey=>$PAlam)
                                                            <tr>
                                                                <td class="{{ $errors->has('PaalamToll.location.'.$PaalamTollKey) ? ' has-error' : '' }}">
                                                                    <input type="text" class="form-control" name="PaalamToll[location][]" value="{{ old('PaalamToll')['location'][$PaalamTollKey] }}">
                                                                </td>
                                                                <td class="{{ $errors->has('PaalamToll.amount.'.$PaalamTollKey) ? ' has-error' : '' }}">
                                                                    <input type="number" min="0" class="form-control PaalamTollAmountValue" name="PaalamToll[amount][]" value="{{ old('PaalamToll')['amount'][$PaalamTollKey] }}">
                                                                </td>
                                                                <td class="{{ $errors->has('PaalamToll.account_id.'.$PaalamTollKey) ? ' has-error' : '' }}">
                                                                    <select name="PaalamToll[account_id][]" class="form-control">
                                                                        <option value="1">Cash</option>
                                                                        @foreach(Auth::user()->Accounts as $Account)
                                                                            <option value="{{ $Account->id }}" {{ ($Account->id == old('PaalamToll')['account_id'][$PaalamTollKey])? 'selected':''}} >{{ $Account->account }} - {{ $Account->HolderName }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </td>
                                                                <td><i style="color: red;" class="fa fa-close RemovePaalamTollInput"></i></td>
                                                            </tr>
                                                            @endforeach
                                                        @endif
                                                    </tbody>
                                                    <tr>
                                                        <th>Total</th>
                                                        <th id="PaalamTollTotalSpentAmount"></th>
                                                        <th></th>
                                                        <th></th>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Paalam / Tolls Data Stop -->


                            <!-- Paalam / Tolls Data Start -->
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="panel-group">
                                        <div class="panel panel-info">
                                            <div class="panel-heading"><span style="font-weight: bold;">Driver Advance
                                                <button type="button" class="btn btn-primary btn-sm pull-right AddDriverAdvanceAmountInput" style="margin-top:-5px;"><i class="fa fa-plus"></i></button>
                                                </span></div>
                                            <div class="panel-body table-responsive">
                                                <table  class="table table-bordered">
                                                    <thead>
                                                    <tr>
                                                        <th>Date</th>
                                                        <th>Amount / ரூ.</th>
                                                        <th>Account</th>
                                                        <th>Action</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody class="DriverAdvanceTableData">
                                                    @if(!empty(old('DriverAdvance')))
                                                        @foreach(old('DriverAdvance')['date'] as $DriverAdvanceKey=>$Driver)
                                                            <tr>
                                                                <td class="{{ $errors->has('DriverAdvance.date.'.$DriverAdvanceKey) ? ' has-error' : '' }}">
                                                                    <input type="date" class="form-control DateValue" name="DriverAdvance[date][]" value="{{ old('DriverAdvance')['date'][$DriverAdvanceKey] }}">
                                                                </td>
                                                                <td class="{{ $errors->has('DriverAdvance.amount.'.$DriverAdvanceKey) ? ' has-error' : '' }}">
                                                                    <input type="number" min="0" class="form-control DriverAdvanceAmountValue" name="DriverAdvance[amount][]" value="{{ old('DriverAdvance')['amount'][$DriverAdvanceKey] }}">
                                                                </td>
                                                                <td class="{{ $errors->has('DriverAdvance.account_id.'.$DriverAdvanceKey) ? ' has-error' : '' }}">
                                                                    <select name="DriverAdvance[account_id][]" class="form-control">
                                                                        <option value="1">Cash</option>
                                                                        @foreach(Auth::user()->Accounts as $Account)
                                                                            <option value="{{ $Account->id }}" {{ ($Account->id == old('DriverAdvance')['account_id'][$DriverAdvanceKey])? 'selected':''}} >{{ $Account->account }} - {{ $Account->HolderName }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </td>
                                                                <td><i style="color: red;" class="fa fa-close RemoveDriverAdvanceInput"></i></td>
                                                            </tr>
                                                        @endforeach
                                                    @endif

                                                    </tbody>
                                                    <tr>
                                                        <th>Total</th>
                                                        <th id="DriverAdvanceTotalAmount"></th>
                                                        <th></th>
                                                        <th></th>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Paalam / Tolls Data Stop -->

                            <br>
                            <div align="center">
                                <button type="submit" class="btn btn-info submit">Add Memo</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4">
                    <div class="panel-group">
                        <div class="panel panel-default">
                            <div class="panel-heading">Calculation</div>
                            <div class="panel-body">
                                <table  class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Total / மொத்தம்	</th>
                                            <th>Cost / ரூ.</th>
                                        </tr>
                                    </thead>
                                    <thead>
                                        <tr>
                                            <th>Diesel / டீசல்</th>
                                            <td style="text-align: center;font-weight: bold;" class="CalculeteTotalExpenseAmount" id="TotalDieselCalculationAmount"></td>
                                        </tr>
                                        <tr>
                                            <th>Commission / கமிஷன்	</th>
                                            <td style="text-align: center;font-weight: bold;" class="CalculeteTotalExpenseAmount" id="TotalComissionCalculationAmount"></td>
                                        </tr>
                                        <tr>
                                            <th>Export / ஏற்றுமதிக்கூலி</th>
                                            <td style="text-align: center;font-weight: bold;" class="CalculeteTotalExpenseAmount" id="TotalExportCalculationAmount"></td>
                                        </tr>
                                        <tr>
                                            <th>Import / இறக்குமதிக்கூலி</th>
                                            <td style="text-align: center;font-weight: bold;" class="CalculeteTotalExpenseAmount" id="TotalImportCalculationAmount"></td>
                                        </tr>
                                        <tr>
                                            <th>Driver Rate / டிரைவர்படி</th>
                                            <td style="text-align: center;font-weight: bold;" class="CalculeteTotalExpenseAmount" id="TotalDriverPadiCalculationAmount"></td>
                                        </tr>
                                        <tr>
                                            <th>Cleaner Rate / கிளீனர் படி</th>
                                            <td style="text-align: center;font-weight: bold;" class="CalculeteTotalExpenseAmount" id="TotalCleanerPadiCalculationAmount"></td>
                                        </tr>
                                        <tr>
                                            <th>RTO செலவு</th>
                                            <td style="text-align: center;font-weight: bold;" class="CalculeteTotalExpenseAmount" id="TotalRTOCalculationAmount"></td>
                                        </tr>
                                        <tr>
                                            <th>PC செலவு</th>
                                            <td style="text-align: center;font-weight: bold;" class="CalculeteTotalExpenseAmount" id="TotalPCCalculationAmount"></td>
                                        </tr>
                                        <tr>
                                            <th>Expenses / இதறசெலவுகள்</th>
                                            <td style="text-align: center;font-weight: bold;" class="CalculeteTotalExpenseAmount" id="TotalExpenseCalculationAmount"></td>
                                        </tr>
                                        <tr>
                                            <th>Bridge / பாலம்</th>
                                            <td style="text-align: center;font-weight: bold;" class="CalculeteTotalExpenseAmount" id="TotalPaalamCalculationAmount"></td>
                                        </tr>
                                        <tr>
                                            <th>Total Spent / மொத்த செலவு</th>
                                            <td style="text-align: center;font-weight: bold;color: red;" id="TotalTotalSpentCalculationAmount"></td>
                                        </tr>
                                        <tr>
                                            <th>Total Income / மொத்த வரவு</th>
                                            <td style="text-align: center;font-weight: bold;color: blue;" id="TotalTotalIncomeCalculationAmount"></td>
                                        </tr>
                                        <tr>
                                            <th>Balance / மீதி இருப்பு</th>
                                            <td style="text-align: center;font-weight: bold;color: green;" id="TotalBalanceCalculationAmount"></td>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

@endsection


@section('script')
    <style>
        td input[type="text"], td select, td input[type="number"] {
            width:10em;
        }
    </style>

    <script>
        $('tbody').sortable();
        var EntryI = {{ isset($EntryKey)?++$EntryKey:0}};

        $(document).ready(function() {
            $('body').on('click','.submit',function () {
                $(".EntryTableData tr").each(function () {
                    $($(this).find('.unloading_mamool_status_class')).attr('name','EntryData[unloading_mamool_status]['+$(this).index()+']');
                    $($(this).find('.unloading_mamool_status_class')).attr('required',true);
                    $($(this).find('.loading_mamool_status_class')).attr('name','EntryData[loading_mamool_status]['+$(this).index()+']');
                    $($(this).find('.loading_mamool_status_class')).attr('required',true);
                    $($(this).find('.commission_status_class')).attr('name','EntryData[commission_status]['+$(this).index()+']');
                    $($(this).find('.commission_status_class')).attr('required',true);
                });
            });

            $('body').on('change keyup','.DateChanges',function (e) {
                e.preventDefault();
                $(".DateValue").attr({
                    "min" : $('.dateFrom').val(),
                    "max" : $('.dateTo').val()
                });
            });

            $('body').on('change','.RTOMasterDatas',function () {
                if($(this).val() != ''){
                    $.ajax({
                        type: "get",
                        url: '/client/entry/memo/RTOMasterData',
                        data:{rtoid:$(this).val()},
                        success: function(data) {
                            if(data !='error'){
                                $('.RTOTableData').append(data);
                            }
                        }
                    });
                }
            });     

            $('body').on('change','.PCMasterDatas',function () {
                if($(this).val() != ''){
                    $.ajax({
                        type: "get",
                        url: '/client/entry/memo/RTOMasterData',
                        data:{rtoid:$(this).val()},
                        success: function(data) {
                            if(data !='error'){
                                $('.PCTableData').append(data);
                            }
                        }
                    });
                }
            });

            $('.VehicleChange').on('change',function(){
                var VehicleId = $('.VehicleChange').val();
                 $.ajax({
                        type: "get",
                        url: '/client/getendingkm',
                        data:{VehicleId:VehicleId},
                        success: function(data) {
                            console.log(data);
                            $('#entry-startkm').val(data.endKm);
                        }
                    });
            })





        });
    </script>

    <script src="{{ url('/js/memo.js') }}"></script>
    <script src="{{ url('/js/rtomaster.js') }}"></script>
@endsection
