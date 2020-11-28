@extends('client.layout.master')

@section('VendorPaymentMenu','active')

@push('BreadCrumbMenu')
   <li>Vendor Payment</li>
   <li>Balance</li>
@endpush

@section('content')

    <div class="row">
        <div class="col-xs-12">

            @component('client.layout.component.panel-head',['MenuTitle'=>'Vendor','Title'=>'Vendor Balance List','color'=>env('TABPANELCOLOR')])

                  <div class="table-responsive">
                    <table  class="table table-bordered table-striped table-hover DataTable">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Address</th>
                                <th>Balance</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        	@foreach(auth()->user()->vendors as $vendor)
                                @if(($amount = vendorUnpaidExpenseList(auth()->user()->id,$vendor->id)) !=0)
                                	<tr>
                                		<td>{{ $vendor->name }}</td>
                                		<td>{{ $vendor->address }}</td>
                                		<td>{{ $amount }}</td>
                                		<td><a href="{{ action('ClientController\vendorPayment\VendorPaymentController@show',$vendor->id) }}" class="btn btn-info btn-sm">Pay</a></td>
                                	</tr>
                                @endif 
                        	@endforeach
                        </tbody>
                    </table>
                    
                </div>

            @endcomponent

        </div>
    </div>
@endsection

@section('script')


@endsection

