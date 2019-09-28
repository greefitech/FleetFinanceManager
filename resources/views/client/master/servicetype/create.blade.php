@extends('client.layout.master')

 
@section('content')


 <div class="row">
    <div class="col-xs-12">
        <div class="box box-info">
            <div class="box-header">
                <h4>
                    <center>Service</center>
                </h4>
                <a href="{{ action('ClientController\Master\ServiceTypeController@index') }}" class="btn btn-info pull-right">View Customer</a>
            </div>
            <div class="box-body">

                @if(isset($servicetype))
                    {!! Form::model($servicetype,['action' => ['ClientController\Master\ServiceTypeController@update', $servicetype->id], 'method' => 'patch', 'class' => 'form-horizontal']) !!}
                @else
                    {!! Form::open(['url' => 'client/master/service-type', 'class' => 'form-horizontal']) !!}
                @endif
                    <div class="box-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <div class="col-sm-12">
                                        {!! Form::label('name', 'Name:') !!}
                                        {!! Form::text('name',null, ['class' => 'form-control', 'placeholder' => 'Name']) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <div class="col-sm-12">
                                        {!! Form::label('type', 'Type:') !!}
                                        <div class="radio">
                                            {!! Form::radio('type', 'km', true, ['id' => 'km']) !!}&nbsp;&nbsp;
                                            {!! Form::label('km', 'km') !!}
                                            {!! Form::radio('type', 'date', false, ['id' => 'date']) !!}&nbsp;&nbsp;
                                            {!! Form::label('date', 'date') !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>
                     
                    <!-- Submit Button -->
                        <div align="center">
                            {!! Form::submit('Save Service', ['class' => 'btn btn-info'] ) !!}
                        </div>
                    </div>
                {!! Form::close()  !!}
            </div>
        </div>
    </div>
</div>



@endsection