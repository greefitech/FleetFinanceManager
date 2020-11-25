@extends('client.layout.master')

@section('MasterMenu','active')

@push('BreadCrumbMenu')
   <li>Master</li>
   <li class="active"><a href="{{ route('client.ViewAccounts') }}">Accounts</a></li>
@endpush

@section('content')

    <div class="row">
        <div class="col-xs-12">

            @component('client.layout.component.panel-head',['MenuTitle'=>'Account','Title'=>'Account List','color'=>env('TABPANELCOLOR')])
                @slot('Button')
                     <a href="{{ route('client.AddAccount') }}" class="btn btn-info btn-sm"><i class="fa fa-plus"></i> Account</a>
                @endslot

                
                <div class="table-responsive">
                    @if(!auth()->user()->Accounts->isEmpty())
                        <table  class="table table-bordered table-striped DataTable table-hover">
                            <thead>
                                <tr>
                                    <th>Account / Bank Name</th>
                                    <th>Holder Name</th>
                                    <th>Credit</th>
                                    <th>Debit</th>
                                    <th>Created By</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach(auth()->user()->Accounts as $Account)
                                    <tr>
                                        <td>{{ $Account->account }}</td>
                                        <td>{{ $Account->HolderName }}</td>
                                        <td style="color: green;">{{ round(VehicleCreditPaymentAccountWise($Account->id)['Credit']) }}
                                        </td>
                                        <td style="color: red;">{{ round(VehicleCreditPaymentAccountWise($Account->id)['Debit']) }}</td>
                                        <td>{{ (!empty($Account->manager))?$Account->manager->name:auth()->user()->name }}</td>
                                        <td>
                                            <a href="{{ route('client.EditAccount',$Account->id) }}" class="btn"><i class="fa fa-pencil text-aqua"></i></a>
                                            <a href="{{ route('client.ViewAccountDetail',$Account->id) }}"><i class="fa fa-eye"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <blockquote><p>No Account till now added!!</p></blockquote>
                    @endif
                </div>


            @endcomponent

        </div>
    </div>

@endsection