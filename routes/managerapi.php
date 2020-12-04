<?php 


Route::post('login', 'ManagerApi\Master\LoginController@login');
Route::group(['middleware' => 'auth:managerapi'], function() {
	Route::post('/logout', 'ManagerApi\Master\LoginController@logout');

	Route::get('demo', 'ManagerApi\Master\LoginController@demo');
});