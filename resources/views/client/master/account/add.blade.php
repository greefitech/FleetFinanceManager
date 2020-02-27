@extends('client.layout.master')

@section('MasterMenu','active')

@section('content')


    <div class="row">
        <div class="col-xs-12">
            <div class="box box-info">
                <div class="box-header">
                    <h4>
                        <center>Add Account</center>
                    </h4>
                    <a href="{{ route('client.ViewAccounts') }}" class="btn btn-info pull-right">View Accounts</a>
                </div>
                <div class="box-body">
                    <form class="form-horizontal" method="post" action="{{ route('client.SaveAccount') }}">
                        {{ csrf_field() }}
                        <div class="box-body">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group{{ $errors->has('account') ? ' has-error' : '' }}">
                                        <div class="col-sm-12">
                                            <label>Account / Bank Name</label>
                                            <input type="text" class="form-control" min="0" value="{{ old('account') }}" placeholder="Enter Account / Bank Name" name="account">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group{{ $errors->has('HolderName') ? ' has-error' : '' }}">
                                        <div class="col-sm-12">
                                            <label>Account Holder Name</label>
                                            <input type="text" class="form-control" value="{{ old('HolderName') }}" placeholder="Enter Account Holder Name" name="HolderName">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div align="center">
                                <button type="submit" class="btn btn-info">Add Account</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


@endsection