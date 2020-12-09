@extends('client.layout.master')


@push('BreadCrumbMenu')
   <li>Profile</li>
@endpush

@section('content')

 <div class="row">
        <div class="col-xs-12">

            @component('client.layout.component.panel-head',['MenuTitle'=>'Profile','Title'=>'Profile Detail','color'=>env('TABPANELCOLOR')])
                @slot('Button')
                    <a href="{{ route('client.ChangePassword') }}" class="btn btn-primary btn-sm">Change Password</a>
                @endslot


                    <form class="form-horizontal" method="post" action="{{ route('client.UpdateProfile') }}" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="box-body">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group{{ $errors->has('name') ? 'has-error' : '' }}">
                                        <div class="col-sm-12">
                                            <label>Name</label>
                                            <input type="text" class="form-control" value="{{ auth()->user()->name }}" placeholder="Enter Name" name="name">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group{{ $errors->has('email') ? 'has-error' : '' }}">
                                        <div class="col-sm-12">
                                            <label>Email</label>
                                            <input type="email" class="form-control" value="{{ auth()->user()->email }}" placeholder="Enter Email" disabled>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group{{ $errors->has('mobile') ? 'has-error' : '' }}">
                                        <div class="col-sm-12">
                                            <label>Mobile</label>
                                            <input type="text" minlength="10" maxlength="10" value="{{ auth()->user()->mobile }}" class="form-control" placeholder="Enter Mobile" name="mobile">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group{{ $errors->has('transportName') ? 'has-error' : '' }}">
                                        <div class="col-sm-12">
                                            <label>Transport Name</label>
                                            <input type="text" value="{{ auth()->user()->transportName }}" class="form-control" placeholder="Enter Transport Name" name="transportName">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group{{ $errors->has('address') ? 'has-error' : '' }}">
                                        <div class="col-sm-12">
                                            <label>Address</label>
                                            <textarea class="form-control" placeholder="Enter Address" name="address" required>{{ auth()->user()->address }}</textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label>Profile Image</label>
                                            <input type="file" name="profile_image">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div align="center">
                                <button type="submit" class="btn btn-info btn-sm"><i class="fa fa-save"></i> Update Profile</button>
                            </div>
                        </div>
                @endcomponent

            </div>
        </div>
        
@endsection