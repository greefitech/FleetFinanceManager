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


//TRIP
Route::get('/trip/add', 'ClientController\TripController@add');
Route::post('/trip/add', 'ClientController\TripController@save')->name('SaveTrip');
Route::get('/trip/{id}/edit', 'ClientController\TripController@edit')->name('EditTrip');
Route::post('/trip/{id}/edit', 'ClientController\TripController@update')->name('UpdateTrip');


//Entry
Route::get('/entry/add', 'ClientController\EntryController@add');
Route::post('/entry/add', 'ClientController\EntryController@save')->name('SaveEntry');
Route::delete('/entry/{id}/delete', 'ClientController\EntryController@delete')->name('DeleteEntry');


//TRIP WISE
Route::get('/Vehicle-list', 'ClientController\TripWiseController@ViewVehicleList')->name('ViewVehicleList');
Route::get('/Vehicle-list/{vehicleid}/trip-list', 'ClientController\TripWiseController@ViewTripListVehicleWise')->name('ViewTripListVehicleWise');
Route::get('/Vehicle-trip/{tripid}/entry-list', 'ClientController\TripWiseController@ViewTripEntryList')->name('ViewTripEntryList');
Route::get('/Vehicle-trip/{tripid}/expense-list', 'ClientController\TripWiseController@ViewTripExpenseList')->name('ViewTripExpenseList');