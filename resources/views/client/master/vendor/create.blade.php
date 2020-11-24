@extends('client.layout.master'
)
@section('MasterMenu','active')

@section('content')

@push('BreadCrumbMenu')
   <li>Master</li>
   <li><a href="{{ action('ClientController\Master\VendorController@index') }}">Vendor</a></li>
   <li class="active">Create</li>
@endpush

<section class="content-header">

    <div class="row">
        <div class="col-xs-12">

            @component('client.layout.component.panel-head',['MenuTitle'=>'Vendor','Title'=>'Create Vendor','color'=>env('TABPANELCOLOR')])
                @slot('Button')
                    <a href="{{ action('ClientController\Master\VendorController@index') }}" class="btn btn-info btn-sm"><i class="fa fa-eye"></i> Vendor</a>
                @endslot


                @if(isset($Vendor))
                    {!! Form::model($Vendor,['url' => action('ClientController\Master\VendorController@update',$Vendor->id),'method' => 'put']) !!}
                @else
                    {!! Form::open(['url' => action('ClientController\Master\VendorController@store'),'method' => 'post']) !!}
                @endif
                    
                    <div class="row">
                        <div class="col-sm-3">
                            <div class="form-group">
                                {!! Form::label('name', 'Name') !!}
                                {!! Form::text('name', null, ['class' => 'form-control','placeholder'=>'Name']) !!}
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                {!! Form::label('gst', 'GST') !!}
                                {!! Form::text('gst', null, ['class' => 'form-control','placeholder'=>'GST']) !!}
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                {!! Form::label('mobile', 'Mobile') !!}
                                {!! Form::text('mobile', null, ['class' => 'form-control','placeholder'=>'Mobile']) !!}
                            </div>
                        </div>
                      
                       
                        <div class="col-sm-3">
                            <div class="form-group">
                                {!! Form::label('address', 'Address') !!}
                                {!! Form::textArea('address',null, ['class' => 'form-control','rows'=>3]) !!}
                            </div>
                        </div>
                      
                    </div>


                     <div class="box-footer" align="center">
                        <button type="submit" class="btn btn-info"><i class="fa fa-floppy-o"></i> Vendor</button>
                    </div>

                {!! Form::close() !!}




            @endcomponent
        </div>
    </div>

@endsection