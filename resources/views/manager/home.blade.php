@extends('manager.layout.master')

@push('BreadCrumbMenu')
   <li>Dashboard</li>
@endpush
@section('content')
   
     <div class="row">
        <div class="col-xs-12">

            @component('manager.layout.component.panel-head',['MenuTitle'=>'Dashboard','Title'=>'Dashboard','color'=>env('TABPANELCOLOR')])
               

              


            @endcomponent

        </div>
    </div>

@endsection