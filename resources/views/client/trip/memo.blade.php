@extends('client.layout.master')

@section('EntryMenu','active')

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
 
                    @if(isset($TripTemp))
                        {{ Form::model($TripTemp, ['url' => action('ClientController\MemoController@updateMemo',$TripTemp->id), 'method' => 'put','class'=>'form-horizontal']) }}
                    @else
                        {!! Form::open(['url' => route('client.SaveMemo'),'method' => 'post','class'=>'form-horizontal']) !!}
                    @endif
    
                        <div class="box-body">
                            <!-- Trip Start -->
                                <div class="row">
                                    <div class="col-sm-3">
                                        <div class="form-group{{ $errors->has('vehicleId') ? ' has-error' : '' }}">
                                            <div class="col-sm-12">
                                                <label>Vehicle / வண்டி எண் <span style="color:red">*</span></label>
                                                {!! Form::select('vehicleId', Auth::user()->vehicles->pluck('vehicleNumber','id'),null, ['class' => 'form-control select2 VehicleChange GetLastKm','placeholder'=>'Select Vehicle']) !!}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group{{ $errors->has('dateFrom') ? ' has-error' : '' }}">
                                            <div class="col-sm-12">
                                                <label>Date / தேதி <span style="color:red">*</span></label>
                                                {!! Form::date('dateFrom', null, ['class' => 'form-control DateChanges dateFrom','max'=>date('Y-m-d')]) !!}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group{{ $errors->has('dateTo') ? ' has-error' : '' }}">
                                            <div class="col-sm-12">
                                                <label>Date / தேதி <span style="color:red">*</span></label>
                                                {!! Form::date('dateTo', null, ['class' => 'form-control DateChanges dateTo','max'=>date('Y-m-d')]) !!}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group{{ $errors->has('advance') ? ' has-error' : '' }}">
                                            <div class="col-sm-12">
                                                <label>Advance / அட்வான்ஸ்</label>
                                                {!! Form::number('advance', null, ['class' => 'form-control','id'=>'advance','min'=>0,'placeholder'=>'Advance']) !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-3">
                                        <div class="form-group{{ $errors->has('startKm') ? ' has-error' : '' }}">
                                            <div class="col-sm-12">
                                                <label>Starting KM / ஆரம்ப கிமீ <span style="color:red">*</span></label>
                                                {!! Form::number('startKm', null, ['class' => 'form-control CalculateKm','min'=>0,'placeholder'=>'Starting KM','id'=>'entry-startkm']) !!}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group{{ $errors->has('endKm') ? ' has-error' : '' }}">
                                            <div class="col-sm-12">
                                                <label>Ending KM / முடிவு கிமீ <span style="color:red">*</span></label>
                                                {!! Form::number('endKm', null, ['class' => 'form-control CalculateKm','min'=>0,'placeholder'=>'Ending KM','id'=>'entry-endkm']) !!}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group{{ $errors->has('totalKm') ? ' has-error' : '' }}">
                                            <div class="col-sm-12">
                                                <label>Total KM / ஓடிய கிமீ</label>
                                                {!! Form::text('totalKm', null, ['class' => 'form-control','min'=>0,'placeholder'=>'Total KM','id'=>'entry-totalkm','readonly']) !!}
                                                <span id="ErrorTotal"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                @if(isset($TripTemp) && empty(old('staff')))
                                    <div class="row">
                                         <div class="col-sm-3">
                                            <div class="form-group{{ $errors->has('staff.0') ? ' has-error' : '' }}">
                                                <div class="col-sm-12">
                                                    <label>First Driver / டிரைவர் 1 <span style="color:red">*</span></label>
                                                    <select name="staff[]" class="form-control select2 Driverchange" id="entry-staff1">
                                                        <option value="">Select Staff</option>
                                                        @foreach(Auth::user()->staffs as $staff)
                                                            <option value="{{ $staff->id }}" {{ ($staff->id == $TripTemp->staff1)?'selected':'' }}>{{ $staff->name }} | {{ $staff->mobile1 }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <div class="col-sm-12">
                                                    <label>Second Driver / டிரைவர் 2</label>
                                                    <select name="staff[]" class="form-control select2" id="entry-staff2">
                                                        <option value="">Select Staff</option>
                                                        @foreach(Auth::user()->staffs as $staff)
                                                            <option value="{{ $staff->id }}"{{ ($staff->id == $TripTemp->staff2)?'selected':'' }}>{{ $staff->name }} | {{ $staff->mobile1 }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <div class="col-sm-12">
                                                    <label>Select Cleaner / கிளீனர்</label>
                                                    <select name="staff[]" class="form-control select2" id="entry-staff3">
                                                        <option value="">Select Staff</option>
                                                        @foreach(Auth::user()->staffs as $staff)
                                                            <option value="{{ $staff->id }}"{{ ($staff->id == $TripTemp->staff3)?'selected':'' }}>{{ $staff->name }} | {{ $staff->mobile1 }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <div class="row">
                                         <div class="col-sm-3">
                                            <div class="form-group{{ $errors->has('staff.0') ? ' has-error' : '' }}">
                                                <div class="col-sm-12">
                                                    <label>First Driver / டிரைவர் 1 <span style="color:red">*</span></label>
                                                    <select name="staff[]" class="form-control select2 Driverchange" id="entry-staff1">
                                                        <option value="">Select Staff</option>
                                                        @foreach(Auth::user()->staffs as $staff)
                                                            <option value="{{ $staff->id }}" {{ ($staff->id == @old('staff')[0])?'selected':'' }}>{{ $staff->name }} | {{ $staff->mobile1 }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <div class="col-sm-12">
                                                    <label>Second Driver / டிரைவர் 2</label>
                                                    <select name="staff[]" class="form-control select2" id="entry-staff2">
                                                        <option value="">Select Staff</option>
                                                        @foreach(Auth::user()->staffs as $staff)
                                                            <option value="{{ $staff->id }}"{{ ($staff->id == @old('staff')[1])?'selected':'' }}>{{ $staff->name }} | {{ $staff->mobile1 }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <div class="col-sm-12">
                                                    <label>Select Cleaner / கிளீனர்</label>
                                                    <select name="staff[]" class="form-control select2" id="entry-staff3">
                                                        <option value="">Select Staff</option>
                                                        @foreach(Auth::user()->staffs as $staff)
                                                            <option value="{{ $staff->id }}"{{ ($staff->id == @old('staff')[2])?'selected':'' }}>{{ $staff->name }} | {{ $staff->mobile1 }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
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

                                                 @if(isset($TripTemp) && empty(old('EntryData')))
                                                    @if(unserialize($TripTemp->diesel))
                                                        @php
                                                            $entryEditDatas = unserialize($TripTemp->entry);
                                                        @endphp
                                                    @endif
                                                @else
                                                    @php
                                                        $entryEditDatas = old('EntryData');
                                                    @endphp
                                                @endif



                                                <table  class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th>Date / தேதி <span style="color:red">*</span></th>
                                                            <th>Customer <span style="color:red">*</span></th>
                                                            <th>Source / புறப்படுமிடம் <span style="color:red">*</span></th>
                                                            <th>Destination / சேருமிடம் <span style="color:red">*</span></th>
                                                            <th>Load / லோடு <span style="color:red">*</span></th>
                                                            <th>Ton/டன் <span style="color:red">*</span></th>
                                                            <th>Account Type</th>
                                                            <th>Bill Amount <span style="color:red">*</span></th>
                                                            <th>Advance / வரவு</th>
                                                            <th>Commission / கமிஷன்</th>
                                                            <th>Driver Padi (%) <span style="color:red">*</span></th>
                                                            <th>Cleaner Padi (%) <span style="color:red">*</span></th>
                                                            <th>Driver Padi</th>
                                                            <th>Cleaner Padi</th>
                                                            <th>Export / ஏற்றுமதிக்கூலி</th>
                                                            <th>Import / இறக்குமதிக்கூலி</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="EntryTableData">
                                                        @if(!empty($entryEditDatas))
                                                            @foreach($entryEditDatas['dateFrom'] as $EntryKey=>$Entry)
                                                                <tr>
                                                                    <td class="{{ $errors->has('EntryData.dateFrom.'.$EntryKey) ? ' has-error' : '' }}">
                                                                        <input type="date" class="form-control DateValue" value="{{ $entryEditDatas['dateFrom'][$EntryKey] }}" placeholder="Enter Date" name="EntryData[dateFrom][]" style="width:15em">
                                                                    </td>
                                                                    <td class="{{ $errors->has('EntryData.customerId.'.$EntryKey) ? ' has-error' : '' }}">
                                                                        <select name="EntryData[customerId][]" class="form-control select2" style="width:15em">
                                                                            <option value="">Select Customer</option>
                                                                            @foreach(auth()->user()->customers as $customer)
                                                                                <option value="{{ $customer->id }}" {{ ($customer->id==$entryEditDatas['customerId'][$EntryKey])?'selected':'' }}>{{ $customer->name }} | {{ $customer->mobile }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </td>
                                                                    <td class="{{ $errors->has('EntryData.locationFrom.'.$EntryKey) ? ' has-error' : '' }}">
                                                                        <input type="text" class="form-control" placeholder="Enter Location" value="{{ $entryEditDatas['locationFrom'][$EntryKey] }}" name="EntryData[locationFrom][]" style="width:15em">
                                                                    </td>
                                                                    <td class="{{ $errors->has('EntryData.locationTo.'.$EntryKey) ? ' has-error' : '' }}">
                                                                        <input type="text" class="form-control" placeholder="Enter Location" value="{{ $entryEditDatas['locationTo'][$EntryKey] }}" name="EntryData[locationTo][]" style="width:15em">
                                                                    </td>
                                                                    <td class="{{ $errors->has('EntryData.loadType.'.$EntryKey) ? ' has-error' : '' }}">
                                                                        <input type="text" class="form-control" placeholder="Enter Load type" value="{{ $entryEditDatas['loadType'][$EntryKey] }}" name="EntryData[loadType][]" style="width:15em">
                                                                    </td>
                                                                    <td class="{{ $errors->has('EntryData.ton.'.$EntryKey) ? ' has-error' : '' }}">
                                                                        <input type="number" min="0" step="0.01" class="form-control" value="{{ $entryEditDatas['ton'][$EntryKey] }}" placeholder="Enter Ton" name="EntryData[ton][]" style="width:10em">
                                                                    </td>
                                                                    <td class="{{ $errors->has('EntryData.account_id.'.$EntryKey) ? ' has-error' : '' }}">
                                                                        <select name="EntryData[account_id][]" class="form-control" style="width:10em">
                                                                            <option value="1">Cash</option>
                                                                            @foreach(Auth::user()->Accounts as $Account)
                                                                                <option value="{{ $Account->id }}" {{ ($Account->id == $entryEditDatas['account_id'][$EntryKey])? 'selected':''}} >{{ $Account->account }} - {{ $Account->HolderName }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </td>
                                                                    <td class="{{ $errors->has('EntryData.billAmount.'.$EntryKey) ? ' has-error' : '' }}">
                                                                        <input type="number" min="0"  class="form-control BillAmountValue" placeholder="Enter Bill Amount" value="{{ $entryEditDatas['billAmount'][$EntryKey] }}" name="EntryData[billAmount][]" style="width:10em">
                                                                    </td>
                                                                    <td class="{{ $errors->has('EntryData.advance.'.$EntryKey) ? ' has-error' : '' }}">
                                                                        <input type="number" min="0" class="form-control AdvanceAmountTotal" placeholder="Enter Advance" value="{{ $entryEditDatas['advance'][$EntryKey] }}" name="EntryData[advance][]" style="width:10em">
                                                                    </td>
                                                                    <td class="{{ $errors->has('EntryData.comission.'.$EntryKey) ? ' has-error' : '' }}">
                                                                        <input type="number" min="0" class="form-control ComissionValue" placeholder="Enter Comission" value="{{ $entryEditDatas['comission'][$EntryKey] }}" name="EntryData[comission][]" style="width:10em">
                                                                        <input type="radio" class="commission_status_class" name="EntryData[commission_status][{{$EntryKey}}]" value="1" {{ ($entryEditDatas['commission_status'][$EntryKey] == 1)?'checked':'' }}><label>Paid</label>
                                                                        <input type="radio" class="commission_status_class" name="EntryData[commission_status][{{$EntryKey}}]" value="0" {{ ($entryEditDatas['commission_status'][$EntryKey] == 0)?'checked':'' }}><label>Not Paid</label>
                                                                    </td>
                                                                    <td class="{{ $errors->has('EntryData.driverPadi.'.$EntryKey) ? ' has-error' : '' }}">
                                                                        <input type="number" min="0" max="100" step="0.01" class="form-control DriverPadiPercentage" placeholder="Enter driver paadi" value="{{ $entryEditDatas['driverPadi'][$EntryKey] }}" name="EntryData[driverPadi][]" style="width:10em">
                                                                    </td>
                                                                    <td class="{{ $errors->has('EntryData.cleanerPadi.'.$EntryKey) ? ' has-error' : '' }}">
                                                                        <input type="number" min="0" max="100" step="0.01" class="form-control CleanerPadiPercentage"  placeholder="Enter cleaner paadi" value="{{ $entryEditDatas['cleanerPadi'][$EntryKey] }}" name="EntryData[cleanerPadi][]" style="width:10em">
                                                                    </td>
                                                                    <td class="{{ $errors->has('EntryData.driverPadiAmount.'.$EntryKey) ? ' has-error' : '' }}">
                                                                        <input type="number" min="0" step="0.01"  class="form-control DriverPadiAmountValue" placeholder="Enter driver paadi amount" value="{{ $entryEditDatas['driverPadiAmount'][$EntryKey] }}" name="EntryData[driverPadiAmount][]" style="width:10em" readonly>
                                                                    </td>
                                                                    <td class="{{ $errors->has('EntryData.cleanerPadiAmount.'.$EntryKey) ? ' has-error' : '' }}">
                                                                        <input type="number" min="0" step="0.01" class="form-control CleanerPadiAmountValue" placeholder="Enter cleaner paadi amount" value="{{ $entryEditDatas['cleanerPadiAmount'][$EntryKey] }}" name="EntryData[cleanerPadiAmount][]" style="width:10em" readonly>
                                                                    </td>

                                                                    <td class="{{ $errors->has('EntryData.loadingMamool.'.$EntryKey) ? ' has-error' : '' }}">
                                                                        <input type="number" min="0" class="form-control loadingMamoolValue" placeholder="Enter Loading" value="{{ $entryEditDatas['loadingMamool'][$EntryKey] }}" name="EntryData[loadingMamool][]" style="width:10em">
                                                                        <input type="radio" class="loading_mamool_status_class" name="EntryData[loading_mamool_status][{{$EntryKey}}]" value="1" {{ ($entryEditDatas['loading_mamool_status'][$EntryKey] == 1)?'checked':'' }}><label>Paid</label>
                                                                        <input type="radio" class="loading_mamool_status_class" name="EntryData[loading_mamool_status][{{$EntryKey}}]" value="0" {{ ($entryEditDatas['loading_mamool_status'][$EntryKey] == 0)?'checked':'' }}><label>Not Paid</label>
                                                                    </td>
                                                                    <td class="{{ $errors->has('EntryData.unLoadingMamool.'.$EntryKey) ? ' has-error' : '' }}">
                                                                        <input type="number" min="0" class="form-control unLoadingMamoolValue" placeholder="Enter Unloading" value="{{ $entryEditDatas['unLoadingMamool'][$EntryKey] }}" name="EntryData[unLoadingMamool][]" style="width:10em">
                                                                        <input type="radio" class="unloading_mamool_status_class" name="EntryData[unloading_mamool_status][{{$EntryKey}}]" value="1" {{ ($entryEditDatas['unloading_mamool_status'][$EntryKey] == 1)?'checked':'' }}><label>Paid</label>
                                                                        <input type="radio" class="unloading_mamool_status_class" name="EntryData[unloading_mamool_status][{{$EntryKey}}]" value="0" {{ ($entryEditDatas['unloading_mamool_status'][$EntryKey] == 0)?'checked':'' }}><label>Not Paid</label>
                                                                    </td>
                                                                    <td class="RemoveEntryDataInput" style="font-size: 13px;"><i style="color: red;" class="fa fa-close"></i></td>
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
                                                 @if(isset($TripTemp) && empty(old('DieselData')))
                                                    @if(unserialize($TripTemp->diesel))
                                                        @php
                                                            $diselEditDatas = unserialize($TripTemp->diesel);
                                                        @endphp
                                                    @endif
                                                @else
                                                    @php
                                                        $diselEditDatas = old('DieselData');
                                                    @endphp
                                                @endif

                                                <table  class="table table-bordered">
                                                    <thead>
                                                    <tr>
                                                        <th>Date / தேதி <span style="color:red">*</span></th>
                                                        <th>Location / இடம்</th>
                                                        <th>Bunk / Description</th>
                                                        <th>Litre / லிட்டர் <span style="color:red">*</span></th>
                                                        <th>Total Cost / விலை <span style="color:red">*</span></th>
                                                        <th>Account Type</th>
                                                        <th>Payment Status</th>
                                                        <th>Action</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody class="DieselTableData">
                                                        @if(!empty($diselEditDatas))
                                                            @foreach($diselEditDatas['date'] as $DiselKey=>$Dis)
                                                                <tr>
                                                                    <td class="{{ $errors->has('DieselData.date.'.$DiselKey) ? ' has-error' : '' }}">
                                                                        <input type="date" class="form-control DateValue" placeholder="Enter date" value="{{ $diselEditDatas['date'][$DiselKey] }}" name="DieselData[date][]">
                                                                    </td>
                                                                    <td class="{{ $errors->has('DieselData.location.'.$DiselKey) ? ' has-error' : '' }}">
                                                                        <input type="text" class="form-control" placeholder="Enter Location" value="{{ $diselEditDatas['location'][$DiselKey] }}" name="DieselData[location][]">
                                                                    </td>
                                                                    <td class="{{ $errors->has('DieselData.discription.'.$DiselKey) ? ' has-error' : '' }}">
                                                                        <input type="text" class="form-control" placeholder="Enter Description" value="{{ $diselEditDatas['discription'][$DiselKey] }}" name="DieselData[discription][]">
                                                                    </td>
                                                                    <td class="{{ $errors->has('DieselData.quantity.'.$DiselKey) ? ' has-error' : '' }}">
                                                                        <input type="number" min="0" step="0.01" class="form-control DieselDataQuantityValue" value="{{ $diselEditDatas['quantity'][$DiselKey] }}" placeholder="Enter Quantity" name="DieselData[quantity][]">
                                                                    </td>
                                                                    <td class="{{ $errors->has('DieselData.amount.'.$DiselKey) ? ' has-error' : '' }}">
                                                                        <input type="number" class="form-control DieselDataAmountValue" placeholder="Enter Amount" value="{{ $diselEditDatas['amount'][$DiselKey] }}" name="DieselData[amount][]">
                                                                    </td>
                                                                    <td class="{{ $errors->has('DieselData.account_id.'.$DiselKey) ? ' has-error' : '' }}">
                                                                        <select name="DieselData[account_id][]" class="form-control select2">
                                                                            <option value="1">Cash</option>
                                                                            @foreach(Auth::user()->Accounts as $Account)
                                                                                <option value="{{ $Account->id }}" {{ ($Account->id == $diselEditDatas['account_id'][$DiselKey])? 'selected':''}} >{{ $Account->account }} - {{ $Account->HolderName }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </td>
                                                                    <td class="{{ $errors->has('DieselData.status.'.$DiselKey) ? ' has-error' : '' }}">
                                                                        <select class="form-control" name="DieselData[status][]">
                                                                            <option value="1" {{ ($diselEditDatas['status'][$DiselKey]==1)?'selected':'' }}>Paid</option>
                                                                            <option value="0" {{ (old('DieselData')['status'][$DiselKey]==0)?'selected':'' }}>Not Paid</option>
                                                                        </select>
                                                                    </td>
                                                                    <td class="RemoveDieselInput" style="font-size: 13px;"><i style="color: red;" class="fa fa-close"></i></td>
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

                                                @if(isset($TripTemp) && empty(old('RTOData')))
                                                    @if(unserialize($TripTemp->rto))
                                                        @php
                                                            $rtoEditDatas = unserialize($TripTemp->rto);
                                                        @endphp
                                                    @endif
                                                @else
                                                    @php
                                                        $rtoEditDatas = old('RTOData');
                                                    @endphp
                                                @endif


                                                <table  class="table table-bordered">
                                                    <thead>
                                                    <tr>
                                                        <th>Location / இடம் <span style="color:red">*</span></th>
                                                        <th>Cost / ரூ. <span style="color:red">*</span></th>
                                                        <th>Action</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody class="RTOTableData">
                                                        @if(!empty($rtoEditDatas))
                                                            @foreach($rtoEditDatas['location'] as $RTOKey=>$PcD)
                                                                <tr>
                                                                    <td class="{{ $errors->has('RTOData.location.'.$RTOKey) ? ' has-error' : '' }}">
                                                                        <input type="text" class="form-control" style="width: 15em" placeholder="Enter Location" value="{{ $rtoEditDatas['location'][$RTOKey] }}" name="RTOData[location][]">
                                                                    </td>
                                                                    <td class="{{ $errors->has('RTOData.amount.'.$RTOKey) ? ' has-error' : '' }}">
                                                                        <input type="number" class="form-control RTODataAmountValue" style="width: 15em" placeholder="Enter Amount" value="{{ $rtoEditDatas['amount'][$RTOKey] }}" name="RTOData[amount][]">
                                                                    </td>
                                                                    <td class="RemoveRToInput" style="font-size: 13px;"><i style="color: red;" class="fa fa-close fa-10x"></i></td>
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

                                                @if(isset($TripTemp) && empty(old('PCData')))
                                                    @if(unserialize($TripTemp->pc))
                                                        @php
                                                            $pcEditDatas = unserialize($TripTemp->pc);
                                                        @endphp
                                                    @endif
                                                @else
                                                    @php
                                                        $pcEditDatas = old('PCData');
                                                    @endphp
                                                @endif


                                                <table  class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th>Location / இடம் <span style="color:red">*</span></th>
                                                            <th>Cost / ரூ. <span style="color:red">*</span> <span style="color:red">*</span></th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="PCTableData">
                                                        @if(!empty($pcEditDatas))
                                                            @foreach($pcEditDatas['location'] as $PCKey=>$PcD)
                                                                <tr>
                                                                    <td class="{{ $errors->has('PCData.location.'.$PCKey) ? ' has-error' : '' }}">
                                                                        <input type="text" class="form-control" style="width: 15em" value="{{ $pcEditDatas['location'][$PCKey] }}" placeholder="Enter Location" name="PCData[location][]">
                                                                    </td>
                                                                    <td class="{{ $errors->has('PCData.amount.'.$PCKey) ? ' has-error' : '' }}">
                                                                        <input type="number" min="0" style="width: 15em" class="form-control PCAmountValue" value="{{ $pcEditDatas['amount'][$PCKey] }}" placeholder="Enter Amount" name="PCData[amount][]">
                                                                    </td>
                                                                    <td class="RemovePcInput" style="font-size: 13px;"><i style="color: red;" class="fa fa-close"></i></td>
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

                                                @if(isset($TripTemp) && empty(old('ExtraExpense')))
                                                    @if(unserialize($TripTemp->extraExpense))
                                                        @php
                                                            $extraExpenseEditDatas = unserialize($TripTemp->extraExpense);
                                                        @endphp
                                                    @endif
                                                @else
                                                    @php
                                                        $extraExpenseEditDatas = old('ExtraExpense');
                                                    @endphp
                                                @endif


                                                <table  class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th>Expenses Type <span style="color:red">*</span></th>
                                                            <th>Quantity</th>
                                                            <th>Location</th>
                                                            <th>Cost / ரூ. <span style="color:red">*</span></th>
                                                            <th>Note</th>
                                                            <th>Account</th>
                                                            <th>Status</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="ExtraExpenseTableData">
                                                        @if(!empty($extraExpenseEditDatas))
                                                            @foreach($extraExpenseEditDatas['expense_type'] as $ExpenseKey=>$PcD)
                                                                <tr>
                                                                    <td class="{{ $errors->has('ExtraExpense.expense_type.'.$ExpenseKey) ? ' has-error' : '' }}">
                                                                        <select name="ExtraExpense[expense_type][]" class="form-control">
                                                                            <option value="">Select Expense</option>
                                                                            @foreach(GetExpenseTypes() as $ExpenseType)
                                                                                <option value="{{ $ExpenseType->id }}" {{ ($ExpenseType->id == $extraExpenseEditDatas['expense_type'][$ExpenseKey])?'selected':'' }}>{{ $ExpenseType->expenseType }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </td>
                                                                    <td class="{{ $errors->has('ExtraExpense.quantity.'.$ExpenseKey) ? ' has-error' : '' }}">
                                                                        <input type="number" min="0" class="form-control" name="ExtraExpense[quantity][]" value="{{ $extraExpenseEditDatas['quantity'][$ExpenseKey] }}">
                                                                    </td>
                                                                    <td class="{{ $errors->has('ExtraExpense.location.'.$ExpenseKey) ? ' has-error' : '' }}">
                                                                        <input type="text" class="form-control" name="ExtraExpense[location][]" value="{{ $extraExpenseEditDatas['location'][$ExpenseKey] }}">
                                                                    </td>
                                                                    <td class="{{ $errors->has('ExtraExpense.amount.'.$ExpenseKey) ? ' has-error' : '' }}">
                                                                        <input type="number" min="0" class="form-control ExtraExpenseAmountValue" name="ExtraExpense[amount][]" value="{{ $extraExpenseEditDatas['amount'][$ExpenseKey] }}">
                                                                    </td>
                                                                    <td class="{{ $errors->has('ExtraExpense.discription.'.$ExpenseKey) ? ' has-error' : '' }}">
                                                                        <input type="text" class="form-control" name="ExtraExpense[discription][]" value="{{ $extraExpenseEditDatas['discription'][$ExpenseKey] }}">
                                                                    </td>
                                                                    <td class="{{ $errors->has('ExtraExpense.account_id.'.$ExpenseKey) ? ' has-error' : '' }}">
                                                                        <select name="ExtraExpense[account_id][]" class="form-control">
                                                                            <option value="1">Cash</option>
                                                                            @foreach(Auth::user()->Accounts as $Account)
                                                                                <option value="{{ $Account->id }}" {{ ($Account->id == $extraExpenseEditDatas['account_id'][$ExpenseKey])? 'selected':''}} >{{ $Account->account }} - {{ $Account->HolderName }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </td>
                                                                    <td class="{{ $errors->has('ExtraExpense.status.'.$ExpenseKey) ? ' has-error' : '' }}">
                                                                        <select class="form-control" name="ExtraExpense[status][]">
                                                                            <option value="1" {{ ($extraExpenseEditDatas['status'][$ExpenseKey]==1)?'selected':'' }}>Paid</option>
                                                                            <option value="0" {{ (old('ExtraExpense')['status'][$ExpenseKey]==0)?'selected':'' }}>Not Paid</option>
                                                                        </select>
                                                                    </td>
                                                                    <td class="RemoveExtraExpenseInput" style="font-size: 13px;"><i style="color: red;" class="fa fa-close"></i></td>
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

                                                @if(isset($TripTemp) && empty(old('PaalamToll')))
                                                    @if(unserialize($TripTemp->tollgate))
                                                        @php
                                                            $tollPalamEditDatas = unserialize($TripTemp->tollgate);
                                                        @endphp
                                                    @endif
                                                @else
                                                    @php
                                                        $tollPalamEditDatas = old('PaalamToll');
                                                    @endphp
                                                @endif


                                                <table  class="table table-bordered">
                                                    <thead>
                                                    <tr>
                                                        <th>Location</th>
                                                        <th>Cost / ரூ. <span style="color:red">*</span></th>
                                                        <th>Account</th>
                                                        <th>Action</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody class="PaalamTollTableData">
                                                    @if(!empty($tollPalamEditDatas))
                                                        @foreach($tollPalamEditDatas['location'] as $PaalamTollKey=>$PAlam)
                                                            <tr>
                                                                <td class="{{ $errors->has('PaalamToll.location.'.$PaalamTollKey) ? ' has-error' : '' }}">
                                                                    <input type="text" class="form-control" name="PaalamToll[location][]" value="{{ $tollPalamEditDatas['location'][$PaalamTollKey] }}">
                                                                </td>
                                                                <td class="{{ $errors->has('PaalamToll.amount.'.$PaalamTollKey) ? ' has-error' : '' }}">
                                                                    <input type="number" min="0" class="form-control PaalamTollAmountValue" name="PaalamToll[amount][]" value="{{ $tollPalamEditDatas['amount'][$PaalamTollKey] }}">
                                                                </td>
                                                                <td class="{{ $errors->has('PaalamToll.account_id.'.$PaalamTollKey) ? ' has-error' : '' }}">
                                                                    <select name="PaalamToll[account_id][]" class="form-control">
                                                                        <option value="1">Cash</option>
                                                                        @foreach(Auth::user()->Accounts as $Account)
                                                                            <option value="{{ $Account->id }}" {{ ($Account->id == $tollPalamEditDatas['account_id'][$PaalamTollKey])? 'selected':''}} >{{ $Account->account }} - {{ $Account->HolderName }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </td>
                                                                <td class="RemovePaalamTollInput"  style="font-size: 13px;"><i style="color: red;" class="fa fa-close"></i></td>
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

                                                @if(isset($TripTemp) && empty(old('DriverAdvance')))
                                                    @if(unserialize($TripTemp->driverAdvance))
                                                        @php
                                                            $driverAdvanceEditDatas = unserialize($TripTemp->driverAdvance);
                                                        @endphp
                                                    @endif
                                                @else
                                                    @php
                                                        $driverAdvanceEditDatas = old('DriverAdvance');
                                                    @endphp
                                                @endif


                                                <table  class="table table-bordered">
                                                    <thead>
                                                    <tr>
                                                        <th>Date <span style="color:red">*</span></th>
                                                        <th>Amount / ரூ. <span style="color:red">*</span></th>
                                                        <th>Account</th>
                                                        <th>Action</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody class="DriverAdvanceTableData">
                                                    @if(!empty($driverAdvanceEditDatas))
                                                        @foreach($driverAdvanceEditDatas['date'] as $DriverAdvanceKey=>$Driver)
                                                            <tr>
                                                                <td class="{{ $errors->has('DriverAdvance.date.'.$DriverAdvanceKey) ? ' has-error' : '' }}">
                                                                    <input type="date" class="form-control DateValue" name="DriverAdvance[date][]" value="{{ $driverAdvanceEditDatas['date'][$DriverAdvanceKey] }}">
                                                                </td>
                                                                <td class="{{ $errors->has('DriverAdvance.amount.'.$DriverAdvanceKey) ? ' has-error' : '' }}">
                                                                    <input type="number" min="0" class="form-control DriverAdvanceAmountValue" name="DriverAdvance[amount][]" value="{{ $driverAdvanceEditDatas['amount'][$DriverAdvanceKey] }}">
                                                                </td>
                                                                <td class="{{ $errors->has('DriverAdvance.account_id.'.$DriverAdvanceKey) ? ' has-error' : '' }}">
                                                                    <select name="DriverAdvance[account_id][]" class="form-control">
                                                                        <option value="1">Cash</option>
                                                                        @foreach(Auth::user()->Accounts as $Account)
                                                                            <option value="{{ $Account->id }}" {{ ($Account->id == $driverAdvanceEditDatas['account_id'][$DriverAdvanceKey])? 'selected':''}} >{{ $Account->account }} - {{ $Account->HolderName }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </td>
                                                                <td class="RemoveDriverAdvanceInput" style="font-size: 13px;"><i style="color: red;" class="fa fa-close"></i></td>
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
                                <button type="submit" name="btnSubmit" value="save_memo" class="btn btn-success submit" >Submit Memo</button>
                                <button type="submit" name="btnSubmit" value="add_partially_memo" class="btn btn-danger submit">Save Partially Memo</button>
                            </div>
                        </div>
                    {!! Form::close() !!}
                </div>
            </div>

            <!-- Calculation box start-->
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
            <!-- Calculation box end -->
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
        $('body').addClass('sidebar-collapse');

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
                getDataAlreadyPresent();
            });

            $('body').on('change','.RTOMasterDatas',function () {
                if($(this).val() != ''){
                    $.ajax({
                        type: "get",
                        url: '/client/entry/memo/RTOMasterData',
                        data:{rtoid:$(this).val(),type:'RTO'},
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
                        data:{rtoid:$(this).val(),type:'PC'},
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
                        $('#entry-startkm').val(data.endKm);
                    }
                });
                getDataAlreadyPresent();
            });
        });

        function getDataAlreadyPresent() {
            var VehicleId = $('.VehicleChange').val();
            var dateFrom = $('.dateFrom').val();
            var dateTo = $('.dateTo').val();
            setTimeout(function(){
                $.ajax({
                    type: "get",
                    url: '{{ action("ClientController\MemoController@checkEntryAlreadyPresent") }}',
                    data:{VehicleId:VehicleId,dateFrom:dateFrom,dateTo:dateTo},
                    success: function(data) {
                        if (data.status =='present') {
                            swal("Check This Entry Date is already added", {buttons: false,timer: 10000,});
                        }
                    }
                });
             },3000);
        }
    </script>

    <script src="{{ url('/js/memo.js') }}"></script>
    <script src="{{ url('/js/rtomaster.js') }}"></script>
    
@endsection
