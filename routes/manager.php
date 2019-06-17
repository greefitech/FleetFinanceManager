<?php

Route::get('/home', 'ManagerController\DashboardController@home')->name('home');

//CUSTOMER
Route::get('/customers', 'ManagerController\CustomerController@View')->name('ViewCustomers');
Route::get('/customer/add', 'ManagerController\CustomerController@Add')->name('AddCustomer');
Route::post('/customer/add', 'ManagerController\CustomerController@Save')->name('SaveCustomer');
Route::get('/customer/{id}/edit', 'ManagerController\CustomerController@edit')->name('EditCustomer');
Route::post('/customer/{id}/update', 'ManagerController\CustomerController@update')->name('UpdateCustomer');

//Vehicle
Route::get('/vehicles', 'ManagerController\VehicleController@view')->name('ViewVehicles');
Route::get('/vehicle/add', 'ManagerController\VehicleController@add')->name('AddVehicle');
Route::post('/vehicle/add', 'ManagerController\VehicleController@save')->name('SaveVehicle');
Route::get('/vehicle/{id}/edit', 'ManagerController\VehicleController@edit')->name('EditVehicle');
Route::post('/vehicle/{id}/update', 'ManagerController\VehicleController@update')->name('UpdateVehicle');

//Documents
Route::get('/documents/{vehicleid}/view', 'ManagerController\DocumentController@view')->name('ViewDocuments');
Route::get('/document/{vehicleid}/add', 'ManagerController\DocumentController@add')->name('AddDocument');
Route::post('/document/{vehicleid}/save', 'ManagerController\DocumentController@save')->name('SaveDocument');
Route::get('/document/{documentid}/edit', 'ManagerController\DocumentController@edit')->name('EditDocument');
Route::post('/document/{documentid}/update', 'ManagerController\DocumentController@update')->name('UpdateDocument');
Route::delete('/document/{documentid}/delete', 'ManagerController\DocumentController@delete')->name('DeleteDocument');

//Financial Indicator
Route::get('/financial-indicator/{vehicleid}/add', 'ManagerController\FinancialIndicatorController@add')->name('AddFinancialIndicators');
Route::post('/financial-indicator/{vehicleid}/save', 'ManagerController\FinancialIndicatorController@save')->name('SaveFinancialIndicators');
Route::get('/financial-indicator/{indicatorid}/view', 'ManagerController\FinancialIndicatorController@view')->name('ViewFinancialIndicators');
Route::get('/financial-indicator/{indicatorid}/edit', 'ManagerController\FinancialIndicatorController@edit')->name('EditFinancialIndicators');
Route::post('/financial-indicator/{vehicleid}/{indicatorid}/update', 'ManagerController\FinancialIndicatorController@update')->name('UpdateFinancialIndicators');
