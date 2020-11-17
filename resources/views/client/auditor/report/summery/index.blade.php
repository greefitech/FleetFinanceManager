@extends('client.layout.master')

@section('content')

    <div class="row">
        <div class="col-xs-12">
            <div class="box box-info">
                <div class="box-header">
                    <h4>
                        <center>Summery Report</center>
                    </h4>
                </div>
                <div class="box-body">
                    {!! Form::open(['url' => action('ClientController\Auditor\SummeryReportController@DownloadReport'),'method' => 'post','class'=>'form-horizontal']) !!}
                    <div class="box-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group{{ $errors->has('category') ? ' has-error' : '' }}">
                                    <div class="col-sm-6">
                                        {!! Form::label('date_from','Date From') !!}
                                        {!! Form::date('date_from',null,['class'=>'form-control']) !!}
                                    </div>
                                    <div class="col-sm-6">
                                        {!! Form::label('date_to','Date To') !!}
                                        {!! Form::date('date_to',null,['class'=>'form-control']) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group{{ $errors->has('vechile_id') ? ' has-error' : '' }}">
                                    <div class="col-sm-12">
                                        {!! Form::label('vechile_id','Expense Type') !!}
                                        {!! Form::select('vechile_id[]',$Vehicles->pluck('vehicleNumber','id'),null,['class'=>'form-control','multiple']) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div align="center">
                            <button type="submit" class="btn btn-info">Download</button>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>



    <div class="row">
        <div class="col-xs-12">
            <div class="box box-info">
                <div class="box-header">
                    <h4>
                        <center>Full Report</center>
                    </h4>
                </div>
                <div class="box-body">
                    {!! Form::open(['url' => action('ClientController\Auditor\FullReportController@DownloadFullReport'),'method' => 'post','class'=>'form-horizontal']) !!}
                    <div class="box-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group{{ $errors->has('category') ? ' has-error' : '' }}">
                                    <div class="col-sm-6">
                                        {!! Form::label('date_from','Date From') !!}
                                        {!! Form::date('date_from',null,['class'=>'form-control']) !!}
                                    </div>
                                    <div class="col-sm-6">
                                        {!! Form::label('date_to','Date To') !!}
                                        {!! Form::date('date_to',null,['class'=>'form-control']) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group{{ $errors->has('vechile_id') ? ' has-error' : '' }}">
                                    <div class="col-sm-12">
                                        {!! Form::label('vechile_id','Expense Type') !!}
                                        {!! Form::select('vechile_id[]',$Vehicles->pluck('vehicleNumber','id'),null,['class'=>'form-control','multiple']) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div align="center">
                            <button type="submit" class="btn btn-info">Download</button>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
