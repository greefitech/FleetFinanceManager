@extends('client.layout.master')

@section('SettingMenu','active')

@section('content')

    <div class="row">
        <div class="col-xs-12">
          	@component('layouts.component.box-pannel',['title'=>'Service Details','color'=>env('TABPANELCOLOR')])
				@slot('button')
                @endslot

                @if(isset($Service))
                    {!! Form::model($Service,['url' => action('ClientController\Setting\ServiceController@update',$Service->id),'method' => 'put']) !!}
                @else
                    {!! Form::open(['url' => action('ClientController\Setting\ServiceController@store'),'method' => 'post']) !!}
                @endif

                    <div class="row">
                        <input type="hidden" name="vehicleId" value="{{ $Vehicle->id }}" class="form-control" >
                        <input type="hidden" name="vehicle_service_id" value="{{ $VehicleService->id }}" class="form-control">
                        <div class="col-sm-3">
                            <div class="form-group">
                                {!! Form::label('date', 'Service Date') !!}
                                {!! Form::date('date', null, ['class' => 'form-control','placeholder' =>'Service Date']) !!}
                            </div>
                        </div>
                         <div class="col-sm-3">
                            <div class="form-group">
                                {!! Form::label('next_service_date', 'Next Service Date') !!}
                                {!! Form::date('next_service_date', null, ['class' => 'form-control','placeholder' =>'Next Service Date']) !!}
                            </div>
                        </div>

                        <div class="col-sm-3">
                            <div class="form-group">
                                {!! Form::label('service_km', 'Service KM') !!}
                                {!! Form::number('service_km', null, ['class' => 'form-control','placeholder' =>'Service Km']) !!}
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                {!! Form::label('next_service_km', 'Next Service KM') !!}
                                {!! Form::number('next_service_km', null, ['class' => 'form-control','placeholder' =>'Next Service KM']) !!}
                            </div>
                        </div>

                        <div class="col-sm-3">
                            <div class="form-group">
                                {!! Form::label('service_station_name', 'Service Station Name') !!}
                                {!! Form::text('service_station_name', null, ['class' => 'form-control','placeholder' =>'Service Station Name']) !!}
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                {!! Form::label('note', 'Note') !!}
                                {!! Form::textArea('note', null, ['class' => 'form-control','placeholder' =>'Note','rows'=>4]) !!}
                            </div>
                        </div>
                    </div>

                    <br>

                    <div align="center">
                        @if(isset($Service))
                            <button type="submit" class="btn btn-info">Update</button>
                        @else
                            <button type="submit" class="btn btn-info">Save</button>
                        @endif
                    </div>

                {!! Form::close() !!}

            @endcomponent
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12">
            @component('layouts.component.box-pannel',['title'=>'Vehicle Service List','color'=>env('TABPANELCOLOR')])
                @slot('button')
                    <div class="row">
                        <div class="col-xs-12">
                            <center><h4>View {{ $Vehicle }} Services</h4></center>
                        </div>
                    </div>
                @endslot
                <meta name="csrf-token" content="{{ csrf_token() }}">
                <table class="table table-hover table-striped table-bordered" id="ServiceListTable">
                    <thead>
                        <tr>
                            <th>Service</th>
                            <th>Service Date</th>
                            <th>Service At</th>
                            <th>Next Service Date</th>
                            <th>Service Km</th>
                            <th>Next Service Km</th>
                            <th>Note</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                </table>

            @endcomponent
        </div>
    </div>

@endsection

@section('script')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>
    <script>
       var Services= $('#ServiceListTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ action('ClientController\Setting\ServiceController@editService',[$VehicleService->id,$Vehicle->id]) }}',
            "columns": [
                {data: 'vehicle_service_id', name: 'vehicle_service_id'},
                {data: 'date', name: 'date'},
                {data: 'service_station_name', name: 'service_station_name'},
                {data: 'next_service_date', name: 'next_service_date'},
                {data: 'service_km', name: 'service_km'},
                {data: 'next_service_km', name: 'next_service_km'},
                {data: 'note', name: 'note'},
                {data: 'action', name: 'action'},
            ]
       });

        $('#ServiceListTable').on('click', '.DeleteData', function (e) { 
            e.preventDefault();
            var url = $(this).attr('href');
            var DeleteMessage = $(this).attr('DeleteMessage');
            swal({
                title: "Are you sure?",
                text: DeleteMessage,
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn-danger",
                confirmButtonText: "Yes, delete it!",
                cancelButtonText: "No, cancel plx!",
                closeOnConfirm: false,
                closeOnCancel: false
            },function(isConfirm) {
                if (isConfirm) {
                    $.ajax(
                        {headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        url: url,
                        type: 'DELETE',
                        dataType: 'json',
                    }).always(function (data) {
                        Services.ajax.reload();
                        swal("Deleted!", data.msg, data.status);
                    });
                } else {
                    swal("Cancelled", "Your Data is safe :)", "error");
                }
            });
        });

    </script>
@endsection
