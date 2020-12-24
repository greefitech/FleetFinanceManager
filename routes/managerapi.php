<?php 


Route::post('login', 'ManagerApi\Master\LoginController@login');
/*Auth*/
Route::group(['middleware' => 'auth:managerapi'], function() {
	Route::post('/logout', 'ManagerApi\Master\LoginController@logout');

	Route::get('demo', 'ManagerApi\Master\LoginController@demo');

	Route::group(['prefix' => 'master'], function() {
        Route::resource('/customer', 'ManagerApi\Master\CustomerController');
        Route::resource('/vehicle', 'ManagerApi\Master\VehicleController');
        Route::resource('/driver', 'ManagerApi\Master\StaffController');
        Route::resource('/account', 'ManagerApi\Master\AccountController');
        Route::resource('/expense-type', 'ManagerApi\Master\ExpenseTypeController');
    });

});