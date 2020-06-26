<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/client', function (Request $request) {
//     return $request->user();
// });


Route::post('login', 'API\UserController@login');
Route::post('register', 'API\UserController@register');
Route::group(['middleware' => 'auth:api'], function() {
    Route::post('/logout', 'API\UserController@logout');

    Route::get('/dashboard/dashboard-summary', 'API\DashboardController\DashboardController@DashboardIncomeExpenseSummary');
    Route::get('/dashboard/dashboard-summary-vehicle-wise-list', 'API\DashboardController\DashboardController@dashboardVehicleWiseList');
    Route::get('/dashboard/dashboard-summary-last-three-month-chart', 'API\DashboardController\DashboardController@dashboardLastThreeMonthChart');
    Route::get('/profile', 'API\UserController@profile');

    /*---------------------------
          Master Route List
    ---------------------------*/
    Route::group(['prefix' => 'master'], function() {
        Route::resource('/customer', 'API\Master\CustomerController');
	    Route::resource('/staff', 'API\Master\StaffController');
	    Route::resource('/vehicle', 'API\Master\VehicleController');
        Route::get('/vehicle-document-types', 'API\Master\DocumentController@vehicleDocumentTypes');
        Route::resource('/vehicle-document', 'API\Master\DocumentController');
        Route::resource('/vehicle-service', 'API\Master\VehicleServiceController');
    });

//    CUSTOMER

 //    Route::get('/customers', 'API\CustomerController@GetCustomers');
 //    Route::post('/customer/create', 'API\CustomerController@CreateCustomer');
    // Route::get('/customer/{id}/edit', 'API\CustomerController@EditCustomers');
    // Route::post('/customer/{id}/update', 'API\CustomerController@UpdateCustomers');
    // Route::delete('/customer/{id}/delete', 'API\CustomerController@DeleteCustomers');

//  STAFF
 //    Route::post('/staff/create', 'API\StaffController@CreateStaff');
    // Route::get('/staffs', 'API\StaffController@GetStaffs');
    // Route::get('/staff/{id}/edit', 'API\StaffController@EditStaff');
    // Route::post('/staff/{id}/update', 'API\StaffController@UpdateStaff');
    // Route::delete('/staff/{id}/delete', 'API\StaffController@DeleteStaff');


//  VEHICLE
 //    Route::get('/vehicle/types', 'API\VehicleController@VehicleType');
    // Route::post('/vehicle/create', 'API\VehicleController@CreateVehicle');
    // Route::get('/vehicles', 'API\VehicleController@GetVehicles');
    // Route::get('/vehicle/{id}/edit', 'API\VehicleController@EditVehicle');
    // Route::post('/vehicle/{id}/update', 'API\VehicleController@UpdateVehicle');

    //  VEHICLE Document

//	ACCOUNT
    Route::post('/account/create', 'API\AccountController@CreateAccount');
    Route::get('/accounts', 'API\AccountController@GetAccounts');
    Route::get('/account/{id}/edit', 'API\AccountController@EditAccount');
    Route::post('/account/{id}/update', 'API\AccountController@UpdateAccount');


//    EXPENSE TYPE
    Route::post('/expenseType/create', 'API\ExpenseTypeController@CreateExpenseType');
    Route::get('/expenseTypes', 'API\ExpenseTypeController@GetExpenseType');
    Route::get('/expenseType/{id}/edit', 'API\ExpenseTypeController@EditExpenseType');
    Route::post('/expenseType/{id}/update', 'API\ExpenseTypeController@UpdateExpenseType');
    Route::delete('/expenseType/{id}/delete', 'API\ExpenseTypeController@DeleteExpenseType');

//    TRIP
    Route::post('/trip/create', 'API\TripController@CreateTrip');
    Route::get('/trips', 'API\TripController@GetTrips');
    Route::get('/trip/{id}/edit', 'API\TripController@EditTrip');
    Route::post('/trip/{id}/update', 'API\TripController@UpdateTrip');

//    ENTRY
    Route::post('/entry/create', 'API\EntryController@CreateEntry');

    /*---------------------------
        Setting Routes list
    ---------------------------*/
    Route::group(['prefix' => 'setting'], function() {
        Route::resource('/vehicle-service', 'API\Setting\ServiceController');
        Route::get('/services/VehicleWise/{ServiceTypeId}/{VehicleId}', 'API\Setting\ServiceController@vehicleServiceData');
    });

    Route::group(['prefix' => 'tyre'], function() {
        Route::resource('/tyre-service', 'API\Setting\TyreController');
    });


});

