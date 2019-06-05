<?php

//Route::get('/home', function () {
//    $users[] = Auth::user();
//    $users[] = Auth::guard()->user();
//    $users[] = Auth::guard('admin')->user();
//
//    //dd($users);
//
//    return view('admin.home');
//})->name('home');




Route::get('/home', 'AdminControllers\DashBoardControllers@home')->name('home');

Route::get('/dashboard/admin/list', 'AdminControllers\DashBoardControllers@TotalAdminWise')->name('DashboardAdminList');

Route::get('/dashboard/admin/{id}/client-list', 'AdminControllers\DashBoardControllers@AdminClientWise')->name('AdminClientWise');

// VEHICLE MODEL TYPE
Route::get('/vehicleType', 'AdminControllers\vehicleTypeController@view')->name('ViewVehicleType');
Route::get('/vehicleType/add', 'AdminControllers\vehicleTypeController@add')->name('AddVehicleType');
Route::post('/vehicleType/save', 'AdminControllers\vehicleTypeController@save')->name('SaveVehicleType');
Route::get('/vehicleType/{id}/edit', 'AdminControllers\vehicleTypeController@edit')->name('vehicleTypeEdit');
Route::post('/vehicleType/{id}/update', 'AdminControllers\vehicleTypeController@update')->name('UpdateVehicleType');
Route::get('/vehicleType/{id}/delete', 'AdminControllers\vehicleTypeController@delete')->name('DeleteVehicleType');


// EXPENSE TYPE
Route::get('/expenseType', 'AdminControllers\ExpenseTypeController@view')->name('ViewExpenseType');
Route::get('/expenseType/add', 'AdminControllers\ExpenseTypeController@add')->name('AddExpenseType');
Route::post('/expenseType/add', 'AdminControllers\ExpenseTypeController@save')->name('SaveExpenseType');
Route::get('/expenseType/{id}/edit', 'AdminControllers\ExpenseTypeController@edit')->name('EditExpenseType');
Route::post('/expenseType/{id}/update', 'AdminControllers\ExpenseTypeController@update')->name('updateExpenseType');
Route::get('/expenseType/{id}/delete', 'AdminControllers\ExpenseTypeController@delete')->name('deleteExpenseType');

// DOCUMENT TYPE
Route::get('/documentType', 'AdminControllers\DocumentTypeController@view')->name('ViewDocumentType');
Route::get('/documentType/add', 'AdminControllers\DocumentTypeController@add')->name('AddDocumentType');
Route::post('/documentType/add', 'AdminControllers\DocumentTypeController@save')->name('SaveDocumentType');
Route::get('/documentType/{id}/edit', 'AdminControllers\DocumentTypeController@edit')->name('EditDocumentType');
Route::post('/documentType/{id}/update', 'AdminControllers\DocumentTypeController@update')->name('UpdateDocumentType');
Route::get('/documentType/{id}/delete', 'AdminControllers\DocumentTypeController@delete')->name('DeleteDocumentType');



// CLIENT
Route::get('/ClientList', 'AdminControllers\ClientControllers@ClientList')->name('ClientList');
Route::get('/Clients/VehicleList/{id}', 'AdminControllers\ClientControllers@VehicleLists');
Route::get('/Clients/Vehicle/{id}/delete', 'AdminControllers\ClientControllers@deleteVehicle')->name('deleteVehicle');
Route::get('/Clients/{id}/delete', 'AdminControllers\ClientControllers@deleteCustomer')->name('deleteCustomer');

Route::get('/Clients/{id}/editClient', 'AdminControllers\ClientControllers@EditClient');
Route::post('/Clients/{id}/UpdateClient', 'AdminControllers\ClientControllers@UpdateClientDeteils')->name('UpdateClientDeteils');


// Vehicle Credit
Route::get('/VehicleCredit', 'AdminControllers\VehicleCreditControllers@VehicleCredit')->name('ViewVehicleCredit');
Route::get('/EditVehicleCredit', 'AdminControllers\VehicleCreditControllers@EditVehicleCredit')->name('EditVehicleCredit');
Route::post('/Clients/addVehicleCredit', 'AdminControllers\VehicleCreditControllers@addVehicleCredit')->name('addVehicleCredit');


//Vehicle Renewal
Route::get('/VehicleRenewal', 'AdminControllers\ClientRenewalControllers@AddVehicleRenewal');

//VehicleCreditPayment
Route::get('/Vehicle-Credit-Payment/View', 'AdminControllers\VehicleCreditPaymentController@ViewVehicleCreditPayment')->name('ViewVehicleCreditPayment');
Route::get('/Vehicle-Credit-Payment/Add', 'AdminControllers\VehicleCreditPaymentController@AddVehicleCreditPayment')->name('AddVehicleCreditPayment');
Route::POSt('Vehicle-Credit-Payment/Save', 'AdminControllers\VehicleCreditPaymentController@SaveVehicleCreditPayment')->name('SaveVehicleCreditPayment');
Route::get('/Client/Details', 'AdminControllers\VehicleCreditPaymentController@getClientDetails');

//ADMIN ACCOUNT
Route::get('/Viewadminaccount', 'AdminControllers\AdminController@Viewadminaccount')->name('ViewAdminAccount');
Route::get('/addadminaccount', 'AdminControllers\AdminController@addadminaccount')->name('adminAccountAdd');
Route::POST('/SaveadminAccount', 'AdminControllers\AdminController@SaveadminAccount')->name('SaveadminAccount');



