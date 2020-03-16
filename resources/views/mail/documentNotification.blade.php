Welcome {{ $detail['client']['transportName'] }},
<br><br>
<p>&nbsp;&nbsp;&nbsp;&nbsp;Vehicle Document Renewal Notification</p>

<table border="1">
	<thead>
		<tr>
			<th>Vehicle Number</th>
			<th>Document</th>
			<th>Expire Date</th>
			<th>Amount</th>
		</tr>
	</thead>
	<tbody>
		@foreach ($detail['clientVehicles'] as $clientVehicleKey => $clientVehicle)
			<?php $documentExpireDays = DateDifference($clientVehicle->duedate) ?>
    		@if($documentExpireDays <= $clientVehicle->notifyBefore)
	    		<tr>
					<td>{{ $clientVehicle->vehicleNumber }}</td>
					<td>{{ $clientVehicle->documentType }}</td>
					<td style="color:red;">{{ date("d-m-Y", strtotime($clientVehicle->duedate)) }} ( {{ $documentExpireDays  }} {{ ($documentExpireDays>0)?'Days Remaining':'Days Renew Soon!!!' }})</td>
					<td>{{ $clientVehicle->amount }}</td>
				</tr>
    		@endif
    	@endforeach
	</tbody>
</table>


<p><i>This email is auto generated from <a href="https://myvehicle.biz" target="_blank">MyVehicle Inc.</a></i></p>