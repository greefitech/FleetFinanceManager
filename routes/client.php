<?php

Route::get('/home', function () {
    $users[] = Auth::user();
    $users[] = Auth::guard()->user();
    $users[] = Auth::guard('client')->user();
    return view('client.home');
})->name('home');

//CUSTOMER
Route::get('/customers', 'ClientController\CustomerController@View')->name('ViewCustomers');
Route::get('/customer/add', 'ClientController\CustomerController@Add')->name('AddCustomer');
Route::post('/customer/add', 'ClientController\CustomerController@Save')->name('SaveCustomer');
Route::get('/customer/{id}/edit', 'ClientController\CustomerController@edit')->name('EditCustomer');
Route::post('/customer/{id}/update', 'ClientController\CustomerController@update')->name('UpdateCustomer');
Route::delete('/customer/{id}/delete', 'ClientController\CustomerController@delete')->name('DeleteCustomer');


Route::get('/staffs', 'ClientController\StaffController@view')->name('ViewStaffs');
Route::get('/staff/add', 'ClientController\StaffController@add')->name('AddStaff');
Route::post('/staff/add', 'ClientController\StaffController@save')->name('SaveStaff');
Route::get('/staff/{id}/edit', 'ClientController\StaffController@edit')->name('EditStaff');
Route::post('/staff/{id}/udate', 'ClientController\StaffController@update')->name('UpdateStaff');
Route::delete('/staff/{id}/delete', 'ClientController\StaffController@delete')->name('DeleteStaff');


Route::get('/vehicles', 'ClientController\VehicleController@view')->name('ViewVehicles');
Route::get('/vehicle/add', 'ClientController\VehicleController@add')->name('AddVehicle');
Route::post('/vehicle/add', 'ClientController\VehicleController@save')->name('SaveVehicle');
Route::get('/vehicle/{id}/edit', 'ClientController\VehicleController@edit')->name('EditVehicle');
Route::post('/vehicle/{id}/update', 'ClientController\VehicleController@update')->name('UpdateVehicle');
Route::delete('/vehicle/{id}/delete', 'ClientController\VehicleController@delete')->name('DeleteVehicle');


//Account
Route::get('/accounts', 'ClientController\AccountController@view')->name('ViewAccounts');
Route::get('/account/add', 'ClientController\AccountController@add')->name('AddAccount');
Route::post('/account/add', 'ClientController\AccountController@save')->name('SaveAccount');
Route::get('/account/{id}/edit', 'ClientController\AccountController@edit')->name('EditAccount');
Route::post('/account/{id}/update', 'ClientController\AccountController@update')->name('UpdateAccount');
Route::delete('/account/{id}/delete', 'ClientController\AccountController@delete')->name('DeleteAccount');

//Expense Type
Route::get('/expense-types', 'ClientController\ExpenseTypeController@view')->name('ViewExpenseTypes');
Route::get('/expense-type/add', 'ClientController\ExpenseTypeController@add')->name('AddExpenseType');
Route::post('/expense-type/add', 'ClientController\ExpenseTypeController@save')->name('SaveExpenseType');
Route::get('/expense-type/{id}/edit', 'ClientController\ExpenseTypeController@edit')->name('EditExpenseType');
Route::post('/expense-type/{id}/update', 'ClientController\ExpenseTypeController@update')->name('UpdateExpenseType');
Route::delete('/expense-type/{id}/delete', 'ClientController\ExpenseTypeController@delete')->name('DeleteExpenseType');

//TRIP
Route::get('/trip/add', 'ClientController\TripController@add');
Route::post('/trip/add', 'ClientController\TripController@save')->name('SaveTrip');
Route::get('/trip/{id}/edit', 'ClientController\TripController@edit')->name('EditTrip');
Route::post('/trip/{id}/edit', 'ClientController\TripController@update')->name('UpdateTrip');
Route::post('/trip/{id}/status/update', 'ClientController\TripController@UpdateTripStatus')->name('UpdateTripStatus');


//Entry
Route::get('/entry/add', 'ClientController\EntryController@add');
Route::post('/entry/add', 'ClientController\EntryController@save')->name('SaveEntry');
Route::delete('/entry/{id}/delete', 'ClientController\EntryController@delete')->name('DeleteEntry');


//Expense
Route::get('/expense/add', 'ClientController\ExpenseController@add')->name('ViewExpenses');
Route::post('/expense/add', 'ClientController\ExpenseController@save')->name('SaveExpense');
Route::get('/expense/{id}/edit', 'ClientController\ExpenseController@edit')->name('EditExpense');
Route::post('/expense/{id}/update', 'ClientController\ExpenseController@update')->name('UpdateExpense');
Route::delete('/expense/{id}/delete', 'ClientController\ExpenseController@delete')->name('DeleteExpense');

Route::get('/expense-vehicle-list', 'ClientController\ExpenseController@ExpenseVehcleListNonTrip')->name('ExpenseVehcleListNonTrip');
Route::get('/expense/vehicle/{vehicleid}/non-trip-expense', 'ClientController\ExpenseController@NonTripVehicleExpenseList')->name('NonTripVehicleExpenseList');



//TRIP WISE
Route::get('/Vehicle-list', 'ClientController\TripWiseController@ViewVehicleList')->name('ViewVehicleList');
Route::get('/Vehicle-list/{vehicleid}/trip-list', 'ClientController\TripWiseController@ViewTripListVehicleWise')->name('ViewTripListVehicleWise');
Route::get('/Vehicle-trip/{tripid}/entry-list', 'ClientController\TripWiseController@ViewTripEntryList')->name('ViewTripEntryList');
Route::get('/Vehicle-trip/{tripid}/expense-list', 'ClientController\TripWiseController@ViewTripExpenseList')->name('ViewTripExpenseList');