Hi <b>{{ $details['transportName'] }}</b>,
<br><br>

@php
	$vehicles = App\Vehicle::where([['clientid',$details['id']]])->get();
	$month = config('mohan.income_expense_send_mail_month');
	$year = config('mohan.income_expense_send_mail_year');	
@endphp
<p style="color: green;">Monthly Report For {{ date("F", mktime(0, 0, 0, $month,10)) }} - {{ $year }}</p>

<table border="1">
	<thead>
		<tr>
			<th>Vehicle Number</th>
			<th>Trips</th>
			<th>Profit</th>
			<th>Non-Trip Expense</th>
			<th>KM</th>
			<th>Diesel Total</th>
		</tr>
	</thead>
	<tbody>
		@foreach($vehicles as $vehicle)
			<tr>
				<td>{{ $vehicle->vehicleNumber }}</td>
				<td>{{ vehicleMontlyVehicleWiseTripDetail($vehicle->id,$month,$year,$details['id'])['tripCount'] }}</td>
				<td>{{ CalculateProfitAmountTotalVehicleWise($vehicle->id,$month,$year,$details['id']) }}</td>
				<td>{{ CalculateNonTripExpenseAmountTotalVehicleWise($vehicle->id,$month,$year,$details['id']) }}</td>
				<td>{{ vehicleMontlyVehicleWiseTripDetail($vehicle->id,$month,$year,$details['id'])['tripTotalKm'] }}</td>
				<td>{{ vehicleMontlyVehicleWiseNonTripExpenseDetail($vehicle->id,$month,$year,$details['id'],2)['amount'] }}</td>
			</tr>
		@endforeach
		<tr>
			<th>Total</th>
			<td>{{ vehicleMontlyClientWiseTripDetail($month,$year,$details['id'])['tripCount'] }}</td>
			<th>{{ CalculateProfitAmountTotalClientWise($month,$year,$details['id']) }}</th>
			<th>{{ CalculateNonTripExpenseAmountTotalClientWise($month,$year,$details['id']) }}</th>
			<td>{{ vehicleMontlyClientWiseTripDetail($month,$year,$details['id'])['tripTotalKm'] }}</td>
			<td>{{ vehicleMontlyClientWiseNonTripExpenseDetail($month,$year,$details['id'],2)['amount'] }}</td>
		</tr>

	</tbody>
</table>


<p><i>This email is auto generated from <a href="https://myvehicle.biz" target="_blank">MyVehicle Inc.</a></i></p>