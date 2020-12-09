@extends('client.layout.master')

@push('BreadCrumbMenu')
   <li>Profile</li>
   <li>Update Password</li>
@endpush


@section('content')

 <div class="row">
        <div class="col-xs-12">

            @component('client.layout.component.panel-head',['MenuTitle'=>'Profile','Title'=>'Update Password','color'=>env('TABPANELCOLOR')])
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
                                <button type="submit" class="btn btn-info btn-sm"> <i class="fa fa-save"></i> Update Password</button>
                            </div>
                        </div>
                    </form>
                @endcomponent

            </div>
        </div>
@endsection