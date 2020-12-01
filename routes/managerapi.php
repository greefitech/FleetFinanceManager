<?php 

Route::post('login', 'ManagerApi\Master\LoginController@login');
Route::group(['middleware' => 'auth:api'], function() {

Route::get('demo', 'ManagerApi\Master\LoginController@demo');
});