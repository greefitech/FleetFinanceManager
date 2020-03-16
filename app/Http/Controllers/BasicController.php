<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Client;
use App\Vehicle;

use App\Mail\SendDocumentNotification;
use App\Jobs\SendClientMonthlyIncomeExpense;
use Mail;

class BasicController extends Controller
{
    public function ClientMonthlyIncomeExpenseMail() {
        if(env('APP_ENV') =='localmohan'){
    		$client = Client::findorfail(3);
    		SendClientMonthlyIncomeExpense::dispatch($client)->delay(now()->addSecond(10));
        }


        if(env('APP_ENV') =='production'){
    		$clients = Client::where('mail_notification',1)->get();
    		foreach ($clients as $key => $client) {
    			SendClientMonthlyIncomeExpense::dispatch($client)->delay(now()->addSecond(10));
    		}
        }
		dd('done');
    }


    public function ClientDocumentExpireMail() {

        if(env('APP_ENV') =='localmohan'){
            $data['client'] = Client::findorfail(3);
            $data['clientVehicles'] = Vehicle::where([['clientid',$data['client']->id],['vehicle_status',1],['document_types.mail_notification',1]])->join('documents','documents.vehicleId','vehicles.id')->join('document_types','document_types.id','documents.documentType')->get();
            $email = new SendDocumentNotification($data);
            Mail::to($data['client']->email)->send($email);
        }


    	// foreach ($clientVehicles as $clientVehicleKey => $clientVehicle) {
    	// 	// return $clientVehicle;
    	// 	// return  DateDifference($clientVehicle->duedate);
    	// 	// return (DateDifference($clientVehicle->duedate)<=$clientVehicle->notifyBefore)?'red':'green';
    	// 	if(DateDifference($clientVehicle->duedate) <= $clientVehicle->notifyBefore){
    	// 		echo $clientVehicle->vehicleNumber.' - '.$clientVehicle->documentType.'  -  '.$clientVehicle->amount.'  -  '.$clientVehicle->duedate.'<br>';
    	// 	}
    	// }
           

        if(env('APP_ENV') =='production'){
            $clients =  Client::where('mail_notification',1)->get();
            foreach ($clients as $key => $client) {
                $data['client'] = $client;
                $data['clientVehicles'] = Vehicle::where([['clientid',$client->id],['vehicle_status',1],['document_types.mail_notification',1]])->join('documents','documents.vehicleId','vehicles.id')->join('document_types','document_types.id','documents.documentType')->get();
                $email = new SendDocumentNotification($data);
                Mail::to($client->email)->send($email);
            }
        }
        dd('done');
    }



}
