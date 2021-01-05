<?php 


Route::post('login', 'ManagerApi\Master\LoginController@login');
/*Auth*/
Route::post('/logout', 'ManagerApi\Master\LoginController@logout');
Route::group(['middleware' => 'auth:managerapi'], function() {
	Route::post('/logout-manager', 'ManagerApi\Master\LoginController@logout');

	// Route::get('demo', 'ManagerApi\Master\LoginController@demo');

	Route::group(['prefix' => 'master'], function() {
        Route::resource('/customer', 'ManagerApi\Master\CustomerController');
        Route::resource('/vehicle', 'ManagerApi\Master\VehicleController');
        Route::resource('/staff', 'ManagerApi\Master\StaffController');
        Route::resource('/account', 'ManagerApi\Master\AccountController');
        Route::resource('/expense-type', 'ManagerApi\Master\ExpenseTypeController');
        Route::resource('/vendor', 'ManagerApi\Master\VendorController');
    });


    Route::group(['prefix' => 'entry'], function() {
        Route::resource('/trip', 'ManagerApi\Entry\TripController');
        Route::resource('/trip-toll', 'ManagerApi\Entry\TollController');
        Route::resource('/trip-driver-advance', 'ManagerApi\Entry\DriverAdvanceController');
        Route::resource('/trip-expense', 'ManagerApi\Entry\ExpenseController');
        Route::resource('/trip-diesel', 'ManagerApi\Entry\DieselController');
    });

});