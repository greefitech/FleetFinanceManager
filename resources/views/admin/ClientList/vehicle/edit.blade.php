@extends('admin.layout.master')

@section('ClientList')
    active
@endsection

@section('content')

    <div class="row">
        <div class="col-xs-12">
            @component('layouts.component.box-pannel',['Title'=>'Dashboard','MenuTitle'=>'Dashboard'])
               
            @endcomponent
         </div>
    </div>

@endsection