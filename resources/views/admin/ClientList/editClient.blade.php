@extends('admin.layout.master')

@section('content')

    <div class="row">
        <div class="col-md-4 col-sm-6 col-xs-12"></div>
        <div class="col-md-4 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-orange"><i class="ion ion-ios-gear-outline"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Total Vehicle Credit</span>
                    <span class="info-box-number"><center><span style="color: green;font-size: 30px">{{ $Client->vehicleCredit }}</span></center></span>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-sm-6 col-xs-12"></div>
    </div>

    <div class="row">
        <div class="col-xs-12">
            <div class="box box-info">
                <div class="box-header">
                    <h4>
                        <center>Edit Client</center>
                    </h4>
                    <a href="{{ route('admin.ClientList') }}" class="btn btn-info pull-right btn-sm">View Client List</a>
                </div>
                <div class="box-body">
                    <form class="form-horizontal" action="{{route('admin.UpdateClientDetails',$Client->id)}}" method="POST">
                        {{ csrf_field() }}
                        <div class="box-body">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                        <div class="col-sm-12">
                                            <label>Name</label>
                                            <input type="text" class="form-control" value="{{ $Client->name }}" placeholder="Enter Your Name" name="name"  id="entry-name" required="">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                        <div class="col-sm-12">
                                            <label>E-mail</label>
                                            <input type="text" class="form-control" value="{{ $Client->email }}" placeholder="Enter Your Name" name="email"  id="entry-email" required="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group{{ $errors->has('transportName') ? ' has-error' : '' }}">
                                        <div class="col-sm-12">
                                            <label>Transport Name</label>
                                            <input type="text" class="form-control" value="{{ $Client->transportName }}" placeholder="Enter Your Name" name="transportName"  id="entry-transportName" required="">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group{{ $errors->has('mobile') ? ' has-error' : '' }}">
                                        <div class="col-sm-12">
                                            <label>Mobile</label>
                                            <input type="text" class="form-control" value="{{ $Client->mobile }}" placeholder="Enter Your Name" name="mobile"  id="entry-mobile" required="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group{{ $errors->has('address') ? ' has-error' : '' }}">
                                        <div class="col-sm-12">
                                            <label>Address</label>
                                            <textarea class="form-control" placeholder="Enter Your Name" name="address"  id="entry-address" required="">{{ $Client->address }}</textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label>Trip Sheet</label>
                                            <select name="memosheet" class="form-control">
                                                @foreach(TripSheet() as $key=>$Trip)
                                                    <option value="{{ $Trip[0] }}" {{ ($Trip[0] == $Client->memosheet)?'selected':'' }}>{{ $Trip[1] }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @if(auth()->user()->id == 1)
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                            <div class="col-sm-12">
                                                <label>New Password</label>
                                                <input type="password" class="form-control" placeholder="Enter New Password" name="password">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                                            <div class="col-sm-12">
                                                <label>Confirm Password</label>
                                                <input type="password" class="form-control" placeholder="Enter Confirm Password" name="password_confirmation">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group{{ $errors->has('mail_notification') ? ' has-error' : '' }}">
                                        <div class="col-sm-12">
                                            <label>Mail Notification</label><br>
                                            <div class="radio">
                                                <label><input type="radio" id="1" name="mail_notification" value="1" {{ $Client->mail_notification == '1' ? 'checked' : ''}}>
                                                Enable</label>
                                                <label><input type="radio" id="0" name="mail_notification" value="0" {{$Client->mail_notification  == 0? 'checked' : ''}}>
                                                Disable</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group{{ $errors->has('client_status') ? ' has-error' : '' }}">
                                        <div class="col-sm-12">
                                            <label>Client Status</label><br>
                                            <div class="radio">
                                                <label><input type="radio" id="1" name="client_status" value="1" {{$Client->client_status ==1 ? 'checked' : ''}}>
                                                Enable</label>
                                                <label><input type="radio" id="0" name="client_status" value="0" {{$Client->client_status ==0 ? 'checked' : ''}}>
                                                Disable</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div align="center">
                                <button type="submit" class="btn btn-success">Update Client</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


@endsection