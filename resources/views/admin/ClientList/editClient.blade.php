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
                    <a href="{{ route('admin.ClientList') }}" class="btn btn-info pull-right">View Client List</a>
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