@extends('client.layout.master')

@section('MasterMenu','active')

@section('content')


    <div class="row">
        <div class="col-xs-12">
            <div class="box box-info">
                <div class="box-header">
                    <h4>
                        <center>Edit Account</center>
                    </h4>
                </div>
                <div class="box-body">
                    <form class="form-horizontal" method="post" action="{{ route('client.UpdateAccount',$Account->id) }}">
                        {{ csrf_field() }}
                        <div class="box-body">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group{{ $errors->has('account') ? ' has-error' : '' }}">
                                        <div class="col-sm-12">
                                            <label>Account / Bank Name <span style="color:red">*</span></label>
                                            <input type="text" class="form-control" min="0" value="{{ $Account->account }}" placeholder="Enter Account / Bank Name" name="account">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group{{ $errors->has('HolderName') ? ' has-error' : '' }}">
                                        <div class="col-sm-12">
                                            <label>Account Holder Name <span style="color:red">*</span></label>
                                            <input type="text" class="form-control" value="{{ $Account->HolderName }}" placeholder="Enter Account Holder Name" name="HolderName">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div align="center">
                                <button type="submit" class="btn btn-info">Update Account</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


@endsection