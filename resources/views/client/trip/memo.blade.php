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
                                                <select class="form-control" name="vehicleId">
                                                    <option value="">Select Vehicle</option>
                                                    @foreach(Auth::user()->vehicles as $vehicle)
                                                        <option value="{{ $vehicle->id }}" {{ ($vehicle->id == old('vehicleId')) ?'selected':'' }}>{{ $vehicle->vehicleNumber }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group{{ $errors->has('dateFrom') ? ' has-error' : '' }}">
                                            <div class="col-sm-12">
                                                <label>Date / தேதி </label>
                                                <input type="date" class="form-control" value="{{ old('dateFrom') }}" placeholder="Enter Date" name="dateFrom">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group{{ $errors->has('dateTo') ? ' has-error' : '' }}">
                                            <div class="col-sm-12">
                                                <label>Date / தேதி </label>
                                                <input type="date" class="form-control" value="{{ old('dateTo') }}" placeholder="Enter Date To" name="dateTo">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group{{ $errors->has('advance') ? ' has-error' : '' }}">
                                            <div class="col-sm-12">
                                                <label>Advance / அட்வான்ஸ்</label>
                                                <input type="numbere" min="0" class="form-control" value="{{ old('advance') }}" placeholder="Enter Advance" name="advance">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-3">
                                        <div class="form-group{{ $errors->has('startKm') ? ' has-error' : '' }}">
                                            <div class="col-sm-12">
                                                <label>Starting KM / ஆரம்ப கிமீ</label>
                                                <input type="text" id="entry-startkm" class="form-control CalculateKm" value="{{ old('startKm') }}" placeholder="Enter Starting KM" name="startKm">
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
                                                <select name="staff[]" class="form-control" id="entry-staff1">
                                                    <option value="">Select Staff</option>
                                                    @foreach(Auth::user()->staffs as $staff)
                                                        <option value="{{ $staff->id }}" {{ ($staff->id==old('staff')[0])?'selected':'' }}>{{ $staff->name }}</option>
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
                                                <select name="staff[]" class="form-control" id="entry-staff2">
                                                    <option value="">Select Staff</option>
                                                    @foreach(Auth::user()->staffs as $staff)
                                                        <option value="{{ $staff->id }}"{{ ($staff->id==old('staff')[1])?'selected':'' }}>{{ $staff->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>Select Cleaner / கிளீனர் பெயர்</label>
                                                <select name="staff[]" class="form-control" id="entry-staff3">
                                                    <option value="">Select Staff</option>
                                                    @foreach(Auth::user()->staffs as $staff)
                                                        <option value="{{ $staff->id }}"{{ ($staff->id==old('staff')[2])?'selected':'' }}>{{ $staff->name }}</option>
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
                                            <div class="panel-heading"><span style="font-weight: bold;">Entry Data</span></div>
                                            <div class="panel-body">Panel Content</div>
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
                                            <div class="panel-heading"><span style="font-weight: bold;">டீசல்</span></div>
                                            <div class="panel-body">Panel Content</div>
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
                                                <span style="font-weight: bold;">RTO
                                                    <button type="button" class="btn btn-primary btn-sm pull-right AddRTOInput"><i class="fa fa-plus"></i></button>
                                                </span>
                                            </div>
                                            <div class="panel-body">
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
                                                                        <input type="text" class="form-control" placeholder="Enter Location" value="{{ old('RTOData')['location'][$RTOKey] }}" name="RTOData[location][]">
                                                                    </td>
                                                                    <td class="{{ $errors->has('RTOData.amount.'.$RTOKey) ? ' has-error' : '' }}">
                                                                        <input type="text" class="form-control RTODataAmountValue" placeholder="Enter Amount" value="{{ old('RTOData')['amount'][$RTOKey] }}" name="RTOData[amount][]">
                                                                    </td>
                                                                    <td><i style="color: red;" class="fa fa-close RemoveRToInput"></i></td>
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
                                                <span style="font-weight: bold;">PC
                                                    <button type="button" class="btn btn-success btn-sm pull-right AddPCInput"><i class="fa fa-plus"></i></button>
                                                </span>
                                            </div>
                                            <div class="panel-body">
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
                                                                        <input type="text" class="form-control" value="{{ old('PCData')['location'][$PCKey] }}" placeholder="Enter Location" name="PCData[location][]">
                                                                    </td>
                                                                    <td class="{{ $errors->has('PCData.amount.'.$PCKey) ? ' has-error' : '' }}">
                                                                        <input type="number" min="0" class="form-control PCAmountValue" value="{{ old('PCData')['amount'][$PCKey] }}" placeholder="Enter Amount" name="PCData[amount][]">
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
                                                    <button type="button" class="btn btn-success btn-sm pull-right AddExtraExpenseInput"><i class="fa fa-plus"></i></button>
                                                </span>
                                            </div>
                                            <div class="panel-body">
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
                                            <div class="panel-heading"><span style="font-weight: bold;">Paalam / Tollgate</span></div>
                                            <div class="panel-body">Panel Content</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Paalam / Tolls Data Stop -->

                            <br>
                            <div align="center">
                                <button type="submit" class="btn btn-info">Add Memo</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection


@section('script')

    <script>
        $('tbody').sortable();


        $(document).ready(function() {


        });
    </script>


    <script src="{{ url('/js/memo.js') }}"></script>
@endsection