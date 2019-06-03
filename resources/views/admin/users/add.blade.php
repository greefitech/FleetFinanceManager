@extends('admin.layout.master')


@section('content')

    <div class="row">
        <div class="col-xs-12">
            <div class="box box-info">
                <div class="box-header">
                    <h4>
                        <center>Add Admin</center>
                    </h4>
                    <a href="{{ route('admin.ViewAdminAccount') }}" class="btn btn-info pull-right">View Admin</a>
                </div>

                <div class="box-body">
                    <form class="form-horizontal"  action="{{ route('admin.SaveadminAccount') }}" method="POST">
                        {{ csrf_field() }}
                        <div class="box-body">
                            <div class="container">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                            <div class="col-sm-12">
                                                <label>Name</label>
                                                <input type="text" class="form-control" value="{{ old('name') }}" name="name" id="name">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                            <div class="col-sm-12">
                                                <label>E - Mail</label>
                                                <input type="text" class="form-control" value="{{ old('email') }}" name="email" id="email">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                            <div class="col-sm-12">
                                                <label>Password</label>
                                                <input type="password" class="form-control" value="{{ old('password') }}" name="password" id="password">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group{{ $errors->has('mobile') ? ' has-error' : '' }}">
                                            <div class="col-sm-12">
                                                <label>Mobile Number</label>
                                                <input type="number" class="form-control" value="{{ old('mobile') }}" name="mobile" id="mobile">
                                            </div>
                                        </div>
                                    </div>
                                </div><br>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <button type="submit" class="btn btn-success btn-block">Save</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

