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
Route::get('/Clients/{id}/edit-client', 'AdminControllers\ClientControllers@EditClient')->name('EditClientList');
Route::post('/Client/{id}/update-details', 'AdminControllers\ClientControllers@UpdateClientDetails')->name('UpdateClientDetails');
//ClientVehicle
Route::get('/Clients/{id}/VehicleList', 'AdminControllers\ClientControllers@VehicleLists')->name('VehicleListClientWise');
Route::get('/Client/{id}/credit-details', 'AdminControllers\ClientControllers@ClientVehicleCreditDetails')->name('ClientVehicleCreditDetails');



// Vehicle Credit
Route::get('/VehicleCredit', 'AdminControllers\VehicleCreditControllers@add')->name('AddVehicleCredit');
Route::post('/vehicleCredit/add', 'AdminControllers\VehicleCreditControllers@SaveVehicleCredit')->name('SaveVehicleCredit');


//Vehicle Renewal
Route::get('/VehicleRenewal', 'AdminControllers\ClientRenewalControllers@AddVehicleRenewal');

//VehicleCreditPayment
Route::get('/Vehicle-Credit-Payment/add', 'AdminControllers\VehicleCreditPaymentController@add')->name('AddVehicleCreditPayment');
Route::POSt('Vehicle-Credit-Payment/Save', 'AdminControllers\VehicleCreditPaymentController@SaveVehicleCreditPayment')->name('SaveVehicleCreditPayment');
Route::get('/Client/client-payment-balance-details', 'AdminControllers\VehicleCreditPaymentController@getClientDetails');




//ADMIN ACCOUNT
Route::get('/Viewadminaccount', 'AdminControllers\AdminController@Viewadminaccount')->name('ViewAdminAccount');
Route::get('/addadminaccount', 'AdminControllers\AdminController@addadminaccount')->name('adminAccountAdd');
Route::POST('/SaveadminAccount', 'AdminControllers\AdminController@SaveadminAccount')->name('SaveadminAccount');



