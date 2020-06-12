@extends('client.layout.master')

@section('MasterMenu','active')

@section('content')

    <div class="row">
        <div class="col-xs-12">
            <div class="box box-info">
                <div class="box-header">
                    <h4>
                        <center>Vehicle Service</center>
                    </h4>
                    <a href="{{ action('ClientController\Master\VehicleServiceController@index') }}" class="btn btn-info pull-right"><i class="fa fa-eye"></i> View</a>
                </div>
                <div class="box-body">
                    
                @if(isset($VehicleService))
                    {!! Form::model($VehicleService,['url' => action('ClientController\Master\VehicleServiceController@update',$VehicleService->id),'method' => 'put']) !!}
                @else
                    {!! Form::open(['url' => action('ClientController\Master\VehicleServiceController@store'),'method' => 'post']) !!}
                @endif
                
                <div class="row">
                     <div class="col-sm-4">
                        <div class="form-group">
                            {!! Form::label('title', 'Title') !!}
                            {!! Form::text('title', null, ['class' => 'form-control','placeholder'=>'eg: Oil']) !!}
                        </div>
                    </div>
                </div>


                 <div class="box-footer" align="center">
                    <button type="submit" class="btn btn-info">Save Service</button>
                </div>

                {!! Form::close() !!}

                </div>
            </div>
        </div>
    </div>

@endsection