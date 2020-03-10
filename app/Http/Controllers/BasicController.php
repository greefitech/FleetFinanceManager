<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Client;

class BasicController extends Controller
{
    public function ClientMonthlyIncomeExpenseMail() {
		$client = Client::findorfail(3);

		
		// App\Jobs\SendClientMonthlyIncomeExpense::dispatch($client)->delay(now()->addSecond(10));

		// $clients Client::where('mail_notification',1)->get();
		// foreach ($clients as $key => $client) {
		// 	App\Jobs\SendClientMonthlyIncomeExpense::dispatch($client)->delay(now()->addSecond(10));
		// }
		dd('done');
    }
}
