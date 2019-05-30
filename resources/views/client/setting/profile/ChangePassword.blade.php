@extends('client.layout.master')

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-info">
                <div class="box-header">
                    <h4>
                        <center>Profile</center>
                    </h4>
                </div>
                <div class="box-body">
                    <form class="form-horizontal" method="post" action="{{ route('client.UpdatePassword') }}">
                        {{ csrf_field() }}
                        <div class="box-body">
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group{{ $errors->has('old_password') ? ' has-error' : '' }}">
                                        <div class="col-sm-12">
                                            <label>Old Password</label>
                                            <input type="password" class="form-control" placeholder="Enter Old Password" name="old_password">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                        <div class="col-sm-12">
                                            <label>New Password</label>
                                            <input type="password" class="form-control" placeholder="Enter New Password" name="password">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                                        <div class="col-sm-12">
                                            <label>Confirm Password</label>
                                            <input type="password" class="form-control" placeholder="Enter Confirm Password" name="password_confirmation">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div align="center">
                                <button type="submit" class="btn btn-info">Update Password</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection