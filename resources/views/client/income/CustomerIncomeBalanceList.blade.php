@extends('client.layout.master')

@section('content')

    <div class="row">
        <div class="col-xs-12">
            <div class="box box-info">
                <div class="box-header">
                    <h4>
                        <center>{{ $Customer->name }} Balance</center>
                    </h4>
                </div>
                <div class="box-body">
                    <form action="{{ route('client.SaveCustomerIncome',$Customer->id) }}" class="form-horizontal" method="post">
                        {{ csrf_field() }}
                        <div class="box-body">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                        <div class="col-sm-12">
                                            <label>Date</label>
                                            <input type="date" class="form-control" value="{{ old('name') }}" placeholder="Enter Date" name="date">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group{{ $errors->has('account_id') ? ' has-error' : '' }}">
                                        <div class="col-sm-12">
                                            <label>Payment Type</label>
                                            <select name="account_id" class="form-control" id="entry-Payment">
                                                <option value="1" {{ (1 == old('account_id')) ? 'selected':'' }}>Cash</option>
                                                @foreach(Auth::user()->Accounts as $Account)
                                                    <option value="{{ $Account->id }}" {{ ($Account->id == old('account_id')) ? 'selected':'' }}>{{ $Account->account }} - {{ !empty($Account->HolderName)? $Account->HolderName:'' }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="panel-group">
                                        <div class="panel panel-info">
                                            <div class="panel-heading">Payment</div>
                                            <div class="panel-body">
                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th>Vehicle Number</th>
                                                            <th>Trip</th>
                                                            <th>Balance Amount</th>
                                                            <th>Receiving Amount	</th>
                                                            <th>Discount Amount</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($final_data as $key => $final)
                                                            @if($final['balance'] != 0)
                                                                <tr>
                                                                    <td>{{ $final['name'] }}</td>
                                                                    <td>{{ date("d-m-Y", strtotime($final['Entry']['dateFrom'])) }} - {{ $final['Entry']['loadType'] }} ( {{ $final['Entry']['locationFrom'] }} - {{ $final['Entry']['locationTo'] }} )</td>
                                                                    <td>{{ $final['balance'] }}</td>
                                                                    <td><input class="form-control recevingAmountValues" type="number" name="income[{{$key}}][recevingAmount]" min="1" max="{{ $final['balance'] }}"></td>
                                                                    <td><input class="form-control discountAmountValues" type="number" name="income[{{$key}}][discountAmount]" min="1" max="{{ $final['balance'] }}"></td>
                                                                </tr>
                                                            @endif
                                                        @endforeach
                                                        <tr>
                                                            <td></td>
                                                            <td>Total</td>
                                                            <td><b>{{$total}}</b></td>
                                                            <td><input class="form-control" type="number" id="recevingTotal" placeholder="Receving Total" readonly=""></td>
                                                            <td><input class="form-control" type="number" id="discountTotal" placeholder="Discount Total" readonly=""></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div align="center">
                                <button type="submit" class="btn btn-info">Add Income</button>
                            </div>

                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

@endsection