<?php

Route::get('/home', 'ManagerController\DashboardController@home')->name('home');

//CUSTOMER
Route::get('/customers', 'ManagerController\CustomerController@View')->name('ViewCustomers');
Route::get('/customer/add', 'ManagerController\CustomerController@Add')->name('AddCustomer');
Route::post('/customer/add', 'ManagerController\CustomerController@Save')->name('SaveCustomer');
Route::get('/customer/{id}/edit', 'ManagerController\CustomerController@edit')->name('EditCustomer');
Route::post('/customer/{id}/update', 'ManagerController\CustomerController@update')->name('UpdateCustomer');
