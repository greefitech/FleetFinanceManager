@extends('manager.layout.master')

@push('BreadCrumbMenu')
   <li>Master</li>
   <li class="active">Customer</li>
@endpush

@section('content')

   <div class="row">
        <div class="col-xs-12">

            @component('manager.layout.component.panel-head',['MenuTitle'=>'Customers','Title'=>'Customers','color'=>env('TABPANELCOLOR')])
                 @slot('Button')
                 <a href="{{ route('manager.AddCustomer') }}" class="btn btn-info btn-sm"><i class="fa fa-plus"></i> Customer</a>
                @endslot
              
                <div class="table-responsive">
                    @if(!auth()->user()->Customers->isEmpty())
                        <table  class="table table-bordered table-striped DataTable table-hover">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Mobile</th>
                                    <th>Address</th>
                                    <th>Type</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach(auth()->user()->Customers as $Customer)
                                    <tr>
                                        <td>{{ $Customer->name }}</td>
                                        <td>{{ $Customer->mobile }}</td>
                                        <td>{{ $Customer->address }}</td>
                                        <td>{{ $Customer->type }}</td>
                                        <td>
                                            <a href="{{ route('manager.EditCustomer',$Customer->id) }}" class="btn"><i class="fa fa-pencil text-aqua"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <blockquote><p>No Customer till now added!!</p></blockquote>
                    @endif
                </div>

            @endcomponent

        </div>
    </div>

@endsection