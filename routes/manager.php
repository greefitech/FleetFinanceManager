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

////Account
//Route::get('/accounts', 'ManagerController\AccountController@view')->name('ViewAccounts');
//Route::get('/account/add', 'ManagerController\AccountController@add')->name('AddAccount');
//Route::post('/account/add', 'ManagerController\AccountController@save')->name('SaveAccount');
//Route::get('/account/{id}/edit', 'ManagerController\AccountController@edit')->name('EditAccount');
//Route::post('/account/{id}/update', 'ManagerController\AccountController@update')->name('UpdateAccount');
//Route::delete('/account/{id}/delete', 'ManagerController\AccountController@delete')->name('DeleteAccount');

//Expense Type
Route::get('/expense-types', 'ManagerController\ExpenseTypeController@view')->name('ViewExpenseTypes');
Route::get('/expense-type/add', 'ManagerController\ExpenseTypeController@add')->name('AddExpenseType');
Route::post('/expense-type/add', 'ManagerController\ExpenseTypeController@save')->name('SaveExpenseType');
Route::get('/expense-type/{id}/edit', 'ManagerController\ExpenseTypeController@edit')->name('EditExpenseType');
Route::post('/expense-type/{id}/update', 'ManagerController\ExpenseTypeController@update')->name('UpdateExpenseType');
Route::delete('/expense-type/{id}/delete', 'ManagerController\ExpenseTypeController@delete')->name('DeleteExpenseType');

//RTO Master
Route::get('/rto-masters', 'ManagerController\RTOMasterController@view')->name('ViewRTOMasters');
Route::get('/rto-master/add', 'ManagerController\RTOMasterController@add')->name('AddRTOMaster');
Route::post('/rto-master/save', 'ManagerController\RTOMasterController@save')->name('SaveRTOMaster');
Route::get('/rto-master/{id}/edit', 'ManagerController\RTOMasterController@edit')->name('EditRTOMaster');
Route::post('/rto-master/{id}/update', 'ManagerController\RTOMasterController@update')->name('UpdateRTOMaster');
Route::delete('/rto-master/{id}/delete', 'ManagerController\RTOMasterController@delete')->name('DeleteRTOMaster');
