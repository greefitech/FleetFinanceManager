@extends('client.layout.master')

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-info">
                <div class="box-header">
                    <h4>
                        <center>Profile</center>
                        <a href="{{ route('client.ChangePassword') }}" class="btn btn-primary pull-right">Change Password</a>
                    </h4>
                </div>
                <div class="box-body">
                    <form class="form-horizontal" method="post" action="{{ route('client.UpdateProfile') }}">
                        {{ csrf_field() }}
                        <div class="box-body">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                        <div class="col-sm-12">
                                            <label>Name</label>
                                            <input type="text" class="form-control" value="{{ auth()->user()->name }}" placeholder="Enter Name" name="name">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                        <div class="col-sm-12">
                                            <label>Email</label>
                                            <input type="email" class="form-control" value="{{ auth()->user()->email }}" placeholder="Enter Email" disabled>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group{{ $errors->has('mobile') ? ' has-error' : '' }}">
                                        <div class="col-sm-12">
                                            <label>Mobile</label>
                                            <input type="text" minlength="10" maxlength="10" value="{{ auth()->user()->mobile }}" class="form-control" placeholder="Enter Mobile" name="mobile">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group{{ $errors->has('transportName') ? ' has-error' : '' }}">
                                        <div class="col-sm-12">
                                            <label>Transport Name</label>
                                            <input type="text" value="{{ auth()->user()->transportName }}" class="form-control" placeholder="Enter Transport Name" name="transportName">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group{{ $errors->has('address') ? ' has-error' : '' }}">
                                        <div class="col-sm-12">
                                            <label>Address</label>
                                            <textarea class="form-control" placeholder="Enter Address" name="address" required>{{ auth()->user()->address }}</textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group{{ $errors->has('gst') ? ' has-error' : '' }}">
                                        <div class="col-sm-12">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div align="center">
                                <button type="submit" class="btn btn-info">Update Profile</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection