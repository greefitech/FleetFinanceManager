<?php 
namespace App\Helper; 
use Request; 

use App\ClientLogActivity as ClientLogActivityModel; 


class ClientLogActivity { 


	public static function CreateLogActivity($subject){ 
		$log = []; 
		$log['subject'] = $subject; 
		$log['url'] = Request::fullUrl(); 
		$log['method'] = Request::method(); 
		$log['ip'] = Request::ip(); 
		$log['agent'] = Request::header('user-agent'); 
		$log['client_id'] = auth()->user()->id; 
		ClientLogActivityModel::create($log); 
	} 


}