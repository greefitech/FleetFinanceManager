Welcome {{ $details['transportName'] }},
<br><br>

@php
	$vehicles = App\Vehicle::where([['clientid',$details['id']]])->get();
	$month = config('mohan.income_expense_send_mail_month');
	$year = config('mohan.income_expense_send_mail_year');
@endphp
<p style="color: green;">Monthly Profit Expense {{ date("F", mktime(0, 0, 0, $month,10)) }} - {{ $year }}</p>

<table border="1">
	<thead>
		<tr>
			<th>Vehicle Number</th>
			<th>Profit</th>
			<th>Non-Trip Expense</th>
		</tr>
	</thead>
	<tbody>
		@foreach($vehicles as $vehicle)
			<tr>
				<td>{{ $vehicle->vehicleNumber }}</td>
				<td>{{ CalculateProfitAmountTotalVehicleWise($vehicle->id,$month,$year,$details['id']) }}</td>
				<td>{{ CalculateNonTripExpenseAmountTotalVehicleWise($vehicle->id,$month,$year,$details['id']) }}</td>
			</tr>
		@endforeach
		<tr>
			<th>Total</th>
			<th>{{ CalculateProfitAmountTotalClientWise($month,$year,$details['id']) }}</th>
			<th>{{ CalculateNonTripExpenseAmountTotalClientWise($month,$year,$details['id']) }}</th>
		</tr>

	</tbody>
</table>


<p><i>This email is auto generated from <a href="https://myvehicle.biz" target="_blank">MyVehicle Inc.</a></i></p>