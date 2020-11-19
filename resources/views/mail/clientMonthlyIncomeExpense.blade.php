Hi <b>{{ $details['transportName'] }}</b>,
<br><br>

@php
	$vehicles = App\Vehicle::where([['clientid',$details['id']]])->get();
	$month = config('mohan.income_expense_send_mail_month');
	$year = config('mohan.income_expense_send_mail_year');		
	// $month = '01';
	// $year = '2020';	
@endphp
<p style="color: green;font-size: 20px;">Monthly Report For {{ date("F", mktime(0, 0, 0, $month,10)) }} - {{ $year }}</p>

<table border="1">
	<thead>
		<tr>
			<th>Vehicle Number</th>
			<th>Trips</th>
			<th>Diesel (₹)</th>
			<th>Income (₹)</th>
			<th>Non-Trip Expense (₹)</th>
			<th>KM</th>
			<th>Profit (₹)</th>
			{{-- <th>Diesel (l)</th> --}}
		</tr>
	</thead>
	<tbody>
		@foreach($vehicles as $vehicle)
			<tr>
				<td>{{ $vehicle->vehicleNumber }}</td>
				<td>{{ vehicleMontlyVehicleWiseTripDetail($vehicle->id,$month,$year,$details['id'])['tripCount'] }}</td>
				<td>{{ vehicleMontlyVehicleWiseTripExpenseDetail($vehicle->id,$month,$year,$details['id'],2)['amount'] }}</td>
				<td>{{ $Income = CalculateProfitAmountTotalVehicleWise($vehicle->id,$month,$year,$details['id']) }}</td>
				<td>{{ $NonTripExpense = CalculateNonTripExpenseAmountTotalVehicleWise($vehicle->id,$month,$year,$details['id']) }}</td>
				<td>{{ vehicleMontlyVehicleWiseTripDetail($vehicle->id,$month,$year,$details['id'])['tripTotalKm'] }}</td>

				<td>{{ number_format(@$Income - @$NonTripExpense)  }}</td>

				{{-- <td>{{ vehicleMontlyVehicleWiseTripExpenseDetail($vehicle->id,$month,$year,$details['id'],2)['quantity'] }}</td> --}}
			</tr>
		@endforeach
		<tr>
			<th>Total</th>
			<td>{{ vehicleMontlyClientWiseTripDetail($month,$year,$details['id'])['tripCount'] }}</td>
			<td>{{ number_format(vehicleMontlyClientWiseTripExpenseDetail($month,$year,$details['id'],2)['amount']) }}</td>
			<th>{{ number_format($TotIncome = CalculateProfitAmountTotalClientWise($month,$year,$details['id'])) }}</th>
			<th>{{ number_format($TotNonTripExpense = CalculateNonTripExpenseAmountTotalClientWise($month,$year,$details['id'])) }}</th>
			<td>{{ vehicleMontlyClientWiseTripDetail($month,$year,$details['id'])['tripTotalKm'] }}</td>

			<th>{{ number_format(@$TotIncome - @$TotNonTripExpense)  }}</th>
			{{-- <td>{{ vehicleMontlyClientWiseTripExpenseDetail($month,$year,$details['id'],2)['quantity'] }}</td> --}}
		</tr>
	</tbody>
</table>

<p><i>This email is auto generated from <a href="https://myvehicle.biz" target="_blank">MyVehicle Inc.</a></i></p>