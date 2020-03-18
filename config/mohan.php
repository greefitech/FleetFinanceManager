<?php 
/*
*----------------------------------------------------
* Config file
*----------------------------------------------------
*/

return [

	/*Website title*/
	'website_title'=>'Fleet Finance',
	'website_logo'=>'/assets/img/greefi.jpg',
	'website_favicon'=>'/assets/img/greefi.jpg',

	'income_expense_send_mail_month'=>\Carbon\Carbon::now()->subMonth()->format('m'),
	'income_expense_send_mail_year'=>\Carbon\Carbon::now()->subMonth()->format('Y'),


	'mail'=>[
		'mail_income_expense_cc'=>array('sarathirangasamy@gmail.com'),
		'mail_income_expense_bcc'=>array('sarathirangasamy@gmail.com','spmohansp@gmail.com'),

		'mail_document_expire_cc'=>array('sarathirangasamy@gmail.com'),
		'mail_document_expire_bcc'=>array('sarathirangasamy@gmail.com','spmohansp@gmail.com'),
	],


	/*Uploads file location*/
	'uploads'=>[
		'vehicle_document'=>'/uploads/vehicle/',
		'staff_document'=>'/uploads/staff/',
	],


];