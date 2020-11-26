@extends('client.layout.master')
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>

@section('NonTripExpenseMenu','active')

@push('BreadCrumbMenu')
   <li>Non-Trip Expense</li>
   <li class="active">Create</li>
@endpush


@section('content')

    <div class="row">
        <div class="col-xs-12">

             @component('client.layout.component.panel-head',['MenuTitle'=>'Non-Trip Expense','Title'=>'Expense Create','color'=>env('TABPANELCOLOR')])
               

                <form class="form-horizontal" method="post" action="{{ action('ClientController\ExpenseController@SaveNonTripExpense') }}" enctype="multipart/form-data">
                    {{ csrf_field() }}
                        <div class="box-body">
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group{{ $errors->has('date') ? ' has-error' : '' }}">
                                        <div class="col-sm-12">
                                            <label>Date</label>
                                            <input type="date" class="form-control" value="{{ old('date') }}" placeholder="Enter Date" name="date" max="{{date('Y-m-d')}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group{{ $errors->has('vehicleId') ? ' has-error' : '' }}">
                                        <div class="col-sm-12">
                                            <label>Vehicle</label>
                                            <select name="vehicleId" class="form-control LastExpense select2 expense-vehicle AutoVehicle" id="entry-vehicle">
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group{{ $errors->has('vendor_id') ? ' has-error' : '' }}">
                                        <div class="col-sm-12">
                                            <label>Vendor</label>
                                            <select name="vendor_id" class="form-control select2" id="entry-vendor">
                                                 <option value="">Select Vendor</option>
                                                @foreach($Vendors as $Vendor)
                                                    <option value="{{ $Vendor->id }}" {{ ($Vendor->id == old('vendor_id')) ? 'selected':'' }}>{{ $Vendor->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group{{ $errors->has('expense_type') ? ' has-error' : '' }}">
                                        <div class="col-sm-12">
                                            <label>Expense</label>
                                            <select name="expense_type" class="form-control expense-type LastExpense select2 AutoExpense" id="entry-type">
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 expense_staff_div">
                                    <div class="form-group{{ $errors->has('staffId') ? ' has-error' : '' }}">
                                        <div class="col-sm-12">
                                            <label>Staff</label>
                                            <select name="staffId" class="form-control" id="expense-staff">
                                                <option value="">Select Staff</option>
                                                @foreach(Auth::user()->staffs as $staff)
                                                    <option value="{{ $staff->id }}" {{ ($staff->id == old('staffId')) ? 'selected':'' }}>{{ $staff->name }} | {{ $staff->mobile1 }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 expense_quantity_div">
                                    <div class="form-group{{ $errors->has('quantity') ? ' has-error' : '' }}">
                                        <div class="col-sm-12">
                                            <label>Quantity</label>
                                            <input type="number" class="form-control" min="0" name="quantity" id="expense-quantity">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                 <div class="col-sm-4">
                                    <div class="form-group{{ $errors->has('total_amount') ? ' has-error' : '' }}">
                                        <div class="col-sm-12">
                                            <label>Total Amount</label>
                                            <input type="number" class="form-control" min="0" name="total_amount" value="{{ old('total_amount') }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group{{ $errors->has('amount') ? ' has-error' : '' }}">
                                        <div class="col-sm-12">
                                            <label>Paid Amount</label>
                                            <input type="number" class="form-control" min="0" name="amount" value="{{ old('amount') }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group{{ $errors->has('location') ? ' has-error' : '' }}">
                                        <div class="col-sm-12">
                                            <label>Location</label>
                                            <input type="text" class="form-control" name="location" value="{{ old('location') }}">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group{{ $errors->has('account_id') ? ' has-error' : '' }}">
                                        <div class="col-sm-12">
                                            <label>Payment Type</label>
                                            <select name="account_id" class="form-control" id="entry-Payment">
                                                <option value="1" {{ (1 == old('account_id')) ? 'selected':'' }}>Cash</option>
                                                @foreach(Auth::user()->Accounts as $Account)
                                                    <option value="{{ $Account->id }}" {{ ($Account->id == old('account_id')) ? 'selected':'' }}>{{ $Account->account }} - {{ $Account->HolderName }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                          
                                <div class="col-sm-4">
                                    <div class="form-group{{ $errors->has('status') ? ' has-error' : '' }}">
                                        <div class="col-sm-12">
                                            <label>Payment Status</label>
                                            <select class="form-control" name="status">
                                                <option value="1">Paid</option>
                                                <option value="0">Not Paid</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group{{ $errors->has('image') ? ' has-error' : '' }}">
                                        <div class="col-sm-12">
                                            <label>Image</label>
                                            <input type="file" class="form-control" name="image">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-4">
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
                                <button type="submit" class="btn btn-info">Add Expense</button>
                            </div>
                        </div>
                    </form>
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="col-sm-12">
                                <div class="c-field u-mb-medium">
                                    <textarea class="form-control" id="expense-LastData" disabled=""></textarea>
                                </div>
                            </div>
                        </div>
                    </div>

            @endcomponent


          
        </div>
    </div>



@endsection



@section('script')

<script type="text/javascript">
$(document).ready(function(){
      $('.AutoExpense').select2({
        placeholder: 'Select Expense Type',
        allowClear: true,
        ajax: {
          url: '{{route("client.AutoExpense")}}',
          dataType: 'json',
          delay: 250,
          processResults: function (data) {
            return {
              results:  $.map(data, function (item) {
                    return {
                        text: item.expenseType,
                        id: item.id
                    }
                })
            };
          },
          cache: true
        }
      });   

    $('.AutoVehicle').select2({
        placeholder: 'Select Vehicle',
        allowClear: true,
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
