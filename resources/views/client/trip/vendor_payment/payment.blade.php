@extends('client.layout.master')

@section('VendorPaymentMenu','active')

@push('BreadCrumbMenu')
   <li>Vendor Payment</li>
   <li>{{ $vendor->name }}</li>
   <li>Payment</li>
@endpush

@section('content')

    <div class="row">
        <div class="col-xs-12">

            @component('client.layout.component.panel-head',['MenuTitle'=>$vendor->name.' - Vendor','Title'=>'Vendor Balance List','color'=>env('TABPANELCOLOR')])

                   {!! Form::open(['url' => action('ClientController\vendorPayment\VendorPaymentController@store'),'method' => 'post']) !!}
                   {!! Form::text('vendor_id', $vendor->id, ['hidden']) !!}
                    <div class="row">
                        <div class="col-sm-3">
                            <div class="form-group">
                                {!! Form::label('date', 'Date') !!}
                                {!! Form::date('date', null, ['class' => 'form-control']) !!}
                            </div>
                        </div> 
                         <div class="col-sm-5">
                            <div class="form-group">
                                {!! Form::label('account_id', 'Account') !!}
                                {!! Form::select('account_id',[1=>'Cash']+auth()->user()->Accounts->pluck('full_account','id')->toArray(), null, ['class' => 'form-control']) !!}
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="panel panel-info">
                                <div class="panel-heading">Payment</div>
                                <div class="panel-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Date</th>
                                                    <th>Vehicle</th>
                                                    <th>Expense</th>
                                                    <th>Balance Amount</th>
                                                    <th>Paid Amount</th>
                                                    <th>Discount</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($FinalExpenseDatas as $FinalExpenseData)
                                                <tr>
                                                    <td>{{ date("d-m-Y", strtotime($FinalExpenseData->date)) }}</td>
                                                    <td>{{ $FinalExpenseData->vehicles->vehicleNumber }}</td>
                                                    <td>{{ $FinalExpenseData->ExpenseTypes->expenseType }}</td>
                                                    <td>{{ $FinalExpenseData->amount }}</td>
                                                    <td>
                                                       {!! Form::number('expense['.$FinalExpenseData->id.'][amount]', null, ['class' => 'form-control','min'=>0,'max'=>$FinalExpenseData->amount]) !!} 
                                                    </td>
                                                     <td>
                                                       {!! Form::number('expense['.$FinalExpenseData->id.'][discount]', null, ['class' => 'form-control','min'=>0,'max'=>$FinalExpenseData->amount]) !!} 
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="box-footer" align="center">
                        <button type="submit" class="btn btn-info">Pay</button>
                    </div>

                {!! Form::close() !!}

            @endcomponent

        </div>
    </div>

@endsection

@section('script')


@endsection

