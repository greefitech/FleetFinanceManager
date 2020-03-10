Welcome {{ $details['transportName'] }},
<br><br>

@php
	$vehicles = App\Vehicle::where([['clientid',$details['id']]])->get()
@endphp

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
				<td>{{ CalculateProfitAmountTotalVehicleWise($vehicle->id,02,2020,$details['id']) }}</td>
				<td>{{ CalculateNonTripExpenseAmountTotalVehicleWise($vehicle->id,02,2020,$details['id']) }}</td>
			</tr>
		@endforeach
		<tr>
			<th>Total</th>
			<th>{{ CalculateProfitAmountTotalClientWise(02,2020,$details['id']) }}</th>
			<th>{{ CalculateNonTripExpenseAmountTotalClientWise(02,2020,$details['id']) }}</th>
		</tr>

	</tbody>
</table>


<p><i>This email is auto generated from <a href="https://myvehicle.biz" target="_blank">MyVehicle Inc.</a></i></p>