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
Route::get('/customer/{id}/view', 'ClientController\CustomerController@view')->name('ViewCustomer');
Route::post('/customer/add', 'ClientController\CustomerController@Save')->name('SaveCustomer');
Route::get('/customer/{id}/edit', 'ClientController\CustomerController@edit')->name('EditCustomer');
Route::post('/customer/{id}/edit', 'ClientController\CustomerController@update')->name('UpdateCustomer');
Route::delete('/customer/{id}/delete', 'ClientController\CustomerController@delete')->name('DeleteCustomer');