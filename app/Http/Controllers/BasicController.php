<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Client;
use App\Vehicle;

use App\Mail\SendDocumentNotification;
use App\Jobs\SendClientMonthlyIncomeExpense;
use App\Jobs\SendClientDocumentNotification;
use App\Jobs\ClientMonthlyIncomeExpenseJobQueue;
use Mail;

class BasicController extends Controller
{

    /*
    *----------------------------------------
    * Send mail for client profit expense
    *----------------------------------------
    *This function is used to send the mail for all clients monthly profit and expense list
    */
    public function ClientMonthlyIncomeExpenseMail() {
        /*Create an job queue and process the email queue*/
        ClientMonthlyIncomeExpenseJobQueue::dispatch(config('mohan.app_status'))->delay(now()->addSecond(10));
		return response()->json(['status'=>'success'], 200);
    }

    /*
    *---------------------------------------------
    * Send mail for document notification
    *---------------------------------------------
    *This function is used to send the document renewal notification to all clents
    */
    public function ClientDocumentExpireMail() {
        /*Dont remove this code its for development checking for single client by mohan*/
        if(env('APP_ENV') =='localmohan'){
            $data['client'] = Client::findorfail(3);
            $data['clientVehicles'] = Vehicle::where([['clientid',$data['client']->id],['status',1],['document_types.mail_notification',1]])->join('documents','documents.vehicleId','vehicles.id')->join('document_types','document_types.id','documents.documentType')->get();
            SendClientDocumentNotification::dispatch( $data)->delay(now()->addSecond(10)); // Send mail 
            // $email = new SendDocumentNotification($data);
            // Mail::to($data['client']->email)->send($email);
        }

        /*Dont remove this code by mohan*/
    	// foreach ($clientVehicles as $clientVehicleKey => $clientVehicle) {
    	// 	// return $clientVehicle;
    	// 	// return  DateDifference($clientVehicle->duedate);
    	// 	// return (DateDifference($clientVehicle->duedate)<=$clientVehicle->notifyBefore)?'red':'green';
    	// 	if(DateDifference($clientVehicle->duedate) <= $clientVehicle->notifyBefore){
    	// 		echo $clientVehicle->vehicleNumber.' - '.$clientVehicle->documentType.'  -  '.$clientVehicle->amount.'  -  '.$clientVehicle->duedate.'<br>';
    	// 	}
    	// }
           
        /*It's production code for sending client email*/
        if(env('APP_ENV') =='production'){
            $clients =  Client::where('mail_notification',1)->get();
            foreach ($clients as $key => $client) {
                $data['client'] = $client;
                $data['clientVehicles'] = Vehicle::where([['clientid',$client->id],['status',1],['document_types.mail_notification',1]])->join('documents','documents.vehicleId','vehicles.id')->join('document_types','document_types.id','documents.documentType')->get();
                SendClientDocumentNotification::dispatch( $data)->delay(now()->addSecond(10));
                // $email = new SendDocumentNotification($data);
                // Mail::to($client->email)->send($email);
            }
        }
        dd('done');
    }


    public function notification(){
        return firebaseOneClientNotification('welcome','welcome to myvehicle','https://lh5.googleusercontent.com/-yrR_NRzA_fg/AAAAAAAAAAI/AAAAAAAAAAA/y_tR_zTs_ag/s44-p-k-no-ns-nd/photo.jpg','d2FYzYspI6E:APA91bHZ4tXZgidIUu0thSV1DcWMswQvi0_b1iTqUdG0gm-gfZ8aJTo9og0yNr-fdgtpEy23TmJTTSZdb0CPSu8Hc-hF2LiqqXsYKqXzHszDkGSWyUxfBXfkUMFB0MjcU3Y7PgnoXKdAd');

        $url = 'https://fcm.googleapis.com/fcm/send';
        $fields = array (
            // 'to' => 'd2FYzYspI6E:APA91bHZ4tXZgidIUu0thSV1DcWMswQvi0_b1iTqUdG0gm-gfZ8aJTo9og0yNr-fdgtpEy23TmJTTSZdb0CPSu8Hc-hF2LiqqXsYKqXzHszDkGSWyUxfBXfkUMFB0MjcU3Y7PgnoXKdAd',
            // 'registration_ids'=>array('d2FYzYspI6E:APA91bHZ4tXZgidIUu0thSV1DcWMswQvi0_b1iTqUdG0gm-gfZ8aJTo9og0yNr-fdgtpEy23TmJTTSZdb0CPSu8Hc-hF2LiqqXsYKqXzHszDkGSWyUxfBXfkUMFB0MjcU3Y7PgnoXKdAd','d2FYzYspI6E:APA91bHZ4tXZgidIUu0thSV1DcWMswQvi0_b1iTqUdG0gm-gfZ8aJTo9og0yNr-fdgtpEy23TmJTTSZdb0CPSu8Hc-hF2LiqqXsYKqXzHszDkGSWyUxfBXfkUMFB0MjcU3Y7PgnoXKdAd'),
            'notification' => array(
                'title' => 'Hai Title',
                'body' => 'welcome mohan Have a nice day',
                'color'=>'#ff3c33',
                "image"=> 'https://lh5.googleusercontent.com/-yrR_NRzA_fg/AAAAAAAAAAI/AAAAAAAAAAA/y_tR_zTs_ag/s44-p-k-no-ns-nd/photo.jpg' ,
            ),
            'priority' =>'high'
        );
        $key = env('FIREBASE_NOTIFICATION_SERVER_KEY');
        $headers = array (
            'Authorization: key='.$key,
            'Content-Type: application/json'
        );
        $ch = curl_init();
        curl_setopt( $ch, CURLOPT_URL, $url );
        curl_setopt( $ch,CURLOPT_POST, true );
        curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
        curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
        curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
        curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($ch);
        curl_close ( $ch );
        return $result;
    }
}
