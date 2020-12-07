<?php

if (! function_exists('firebaseOneClientNotification')) { 
    function firebaseOneClientNotification($title,$message,$image ,$token) { 
        $url = 'https://fcm.googleapis.com/fcm/send';

	   	$fields = array (
	        'to' => $token,
	        'notification' => array(
	            'title' => $title,
	            'body' => $message,
	            'vibrate'   => 1,
	            'sound'     => 1,
	            "icon"=> "ic_launcher",
	            'color'=>'#ff3c33',
	            "image"=> $image ,
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
	    curl_close( $ch );
	    return $result;
    } 
}


if (! function_exists('firebaseMultipleClientNotification')) { 
    function firebaseMultipleClientNotification($title,$message,$image,$token) { 
        $url = 'https://fcm.googleapis.com/fcm/send';
	    
	    $fields = array (
	        'registration_ids' => $token,
	        'notification' => array(
	            'title' => $title,
	            'body' => $message,
	            'vibrate'   => 1,
	            'sound'     => 1,
	            "icon"=> "ic_launcher",
	            'color'=>'#ff3c33',
	            "image"=> $image,
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
	    curl_close( $ch );
	    return $result;
    } 
}