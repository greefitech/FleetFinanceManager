@extends('client.layout.master')

@section('content')


    <div class="row">
        <div class="col-xs-12">
            <div class="box box-info">
                <div class="box-header">
                    <h4>
                        <center>Add Trip Advance</center>
                    </h4>
                </div>
                <div class="box-body">
                    <form class="form-horizontal" method="post" action="{{ route('client.SaveTripAdvance') }}">
                        {{ csrf_field() }}
                        <div class="box-body">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group{{ $errors->has('date') ? ' has-error' : '' }}">
                                        <div class="col-sm-12">
                                            <label>Date From</label>
                                            <input type="date" class="form-control" value="{{ old('date') }}" placeholder="Enter Date" name="date">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group{{ $errors->has('tripId') ? ' has-error' : '' }}">
                                        <div class="col-sm-12">
                                            <label>Trip</label>
                                            <select name="tripId" class="form-control select2"  id="entry-trip">
                                                <option value="">Select Trip</option>
                                                @foreach(Auth::user()->NotCompletedTrips as $Trip)
                                                    <option value="{{ $Trip->id }}" {{ ($Trip->id == old('tripId'))?'selected':'' }}>{{ $Trip->vehicle->vehicleNumber }} | {{ $Trip->tripName }} | {{ date("d-m-Y", strtotime($Trip->dateFrom)) }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group{{ $errors->has('amount') ? ' has-error' : '' }}">
                                        <div class="col-sm-12">
                                            <label>Advance</label>
                                            <input type="number" min="0" class="form-control" value="{{ old('amount') }}" placeholder="Enter Amount" name="amount">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group{{ $errors->has('account_id') ? ' has-error' : '' }}">
                                        <div class="col-sm-12">
                                            <label>Payment Type</label>
                                            <select name="account_id" class="form-control" id="entry-Payment">
                                                <option value="1" {{ (1 == old('account_id')) ? 'selected':'' }}>Cash</option>
                                                @foreach(Auth::user()->Accounts as $Account)
                                                    <option value="{{ $Account->id }}" {{ ($Account->id == old('account_id')) ? 'selected':'' }}>{{ $Account->account }} - {{ $Account->HolderName }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div align="center">
                                <button type="submit" class="btn btn-info">Add Trip Advance</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


@endsection