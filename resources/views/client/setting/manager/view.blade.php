@extends('client.layout.master')

@section('SettingMenu','active')


@push('BreadCrumbMenu')
   <li>Settinf</li>
   <li class="active">Manager</li>
@endpush

@section('content')

    <div class="row">
        <div class="col-xs-12">

            @component('client.layout.component.panel-head',['MenuTitle'=>'Manager','Title'=>'Manager','color'=>env('TABPANELCOLOR')])
                @slot('Button')
                    <a href="{{ route('client.AddManager') }}" class="btn btn-info btn-sm"><i class="fa fa-plus"></i>Manager</a>
                @endslot


                <div class="box-body">
                    <div class="table-responsive">
                        @if(!auth()->user()->managers->isEmpty())
                            <table  class="table table-bordered table-striped DataTable">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Mobile</th>
                                        <th>Email</th>
                                        <th>Vehicle Number</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach(auth()->user()->managers as $Manager)
                                        <tr>
                                            <td>{{ $Manager->name }}</td>
                                            <td>{{ $Manager->mobile }}</td>
                                            <td>{{ $Manager->email }}</td>
                                            <td>{{ implode(',',App\Vehicle::whereIn('id',$Manager->ManagerLorries())->get()->pluck('vehicleNumber')->toArray()) }}</td>
                                            <td>
                                                <form action="" method="POST">
                                                    {{ csrf_field() }}
                                                    <input type="hidden" name="_method" value="DELETE">
                                                    <a href="{{ route('client.EditManager',$Manager->id) }}" class="btn"><i class="fa fa-pencil text-aqua"></i></a>
{{--                                                    <button href="" onclick="return confirm('Are you sure?')" class="btn"><i class="fa fa-trash-o"></i></button>--}}
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <blockquote><p>No Manager till now added!!</p></blockquote>
                        @endif
                    </div>
                </div>
        
            @endcomponent

        </div>
    </div>

@endsection