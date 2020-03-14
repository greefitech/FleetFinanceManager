<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Client;
use App\Vehicle;

use App\Mail\SendDocumentNotification;
use Mail;

class BasicController extends Controller
{
    public function ClientMonthlyIncomeExpenseMail() {
        if(env('APP_ENV') =='localmohan'){
    		$client = Client::findorfail(3);
    		App\Jobs\SendClientMonthlyIncomeExpense::dispatch($client)->delay(now()->addSecond(10));
        }


        if(env('APP_ENV') =='production'){
    		$clients = Client::where('mail_notification',1)->get();
    		foreach ($clients as $key => $client) {
    			App\Jobs\SendClientMonthlyIncomeExpense::dispatch($client)->delay(now()->addSecond(10));
    		}
        }
		dd('done');
    }






}
