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
Route::post('/customer/{id}/edit', 'ClientController\CustomerController@update')->name('UpdateCustomer');
Route::delete('/customer/{id}/delete', 'ClientController\CustomerController@delete')->name('DeleteCustomer');


Route::get('/staffs', 'ClientController\StaffController@view')->name('ViewStaffs');
Route::get('/staff/add', 'ClientController\StaffController@add')->name('AddStaff');
Route::post('/staff/add', 'ClientController\StaffController@save')->name('SaveStaff');
Route::get('/staff/{id}/edit', 'ClientController\StaffController@edit')->name('EditStaff');
Route::post('/staff/{id}/edit', 'ClientController\StaffController@update')->name('UpdateStaff');
Route::delete('/staff/{id}/delete', 'ClientController\StaffController@delete')->name('DeleteStaff');