<?php

Route::get('/home', function () {
    $users[] = Auth::user();
    $users[] = Auth::guard()->user();
    $users[] = Auth::guard('admin')->user();

    //dd($users);

    return view('admin.home');
})->name('home');




Route::get('/getClientDetails', 'AdminControllers\CustomeControllers@getClientDetails');



// ENTRY LOAD TYPE
Route::get('/loadType', 'AdminControllers\EntryLoadType@show');
Route::get('/loadType/add', 'AdminControllers\EntryLoadType@add');
Route::post('/loadType/add', 'AdminControllers\EntryLoadType@addLoadType')->name('addLoadType');
Route::get('/loadType/{id}/edit', 'AdminControllers\EntryLoadType@editLoadType');
Route::post('/loadType/{id}/update', 'AdminControllers\EntryLoadType@updateLoadType')->name('updateLoadType');
Route::delete('/loadType/{id}/delete', 'AdminControllers\EntryLoadType@deleteLoadType')->name('deleteLoadType');



// VEHICLE MODEL TYPE
Route::get('/vehicleType', 'AdminControllers\vehicleTypeController@show');
Route::get('/vehicleType/add', 'AdminControllers\vehicleTypeController@add')->name('VehicleType');
Route::post('/vehicleType/add', 'AdminControllers\vehicleTypeController@addVehicleType')->name('addVehicleType');
Route::get('/vehicleType/{id}/edit', 'AdminControllers\vehicleTypeController@editVehicleType')->name('vehicleTypeEdit');
Route::post('/vehicleType/{id}/update', 'AdminControllers\vehicleTypeController@updateVehicleType')->name('updateVehicleType');
Route::get('/vehicleType/{id}/delete', 'AdminControllers\vehicleTypeController@deleteVehicleType')->name('deleteVehicleType');


// EXPENSE TYPE
Route::get('/expenseType', 'AdminControllers\ExpenseTypeController@show')->name('ExpenseType');
Route::get('/expenseType/add', 'AdminControllers\ExpenseTypeController@add')->name('AddExpense');
Route::post('/expenseType/add', 'AdminControllers\ExpenseTypeController@addExpenseType')->name('addExpenseType');
Route::get('/expenseType/{id}/edit', 'AdminControllers\ExpenseTypeController@editExpenseType')->name('ExpenseTypeEdit');
Route::post('/expenseType/{id}/update', 'AdminControllers\ExpenseTypeController@updateExpenseType')->name('updateExpenseType');
Route::get('/expenseType/{id}/delete', 'AdminControllers\ExpenseTypeController@deleteExpenseType')->name('deleteExpenseType');


Route::get('/documentType', 'AdminControllers\DocumentTypeController@show')->name('view');
Route::get('/documentType/add', 'AdminControllers\DocumentTypeController@add')->name('addDocument');
Route::post('/documentType/add', 'AdminControllers\DocumentTypeController@addDocumentType')->name('addDocumentType');
Route::get('/documentType/{id}/edit', 'AdminControllers\DocumentTypeController@editDocumentType')->name('editDocumentType');
Route::post('/documentType/{id}/update', 'AdminControllers\DocumentTypeController@updateDocumentType')->name('updateDocumentType');
Route::get('/documentType/{id}/delete', 'AdminControllers\DocumentTypeController@deleteDocumentType')->name('deleteDocumentType');






Route::get('/ClientList', 'AdminControllers\ClientControllers@ClientList')->name('ClientList');
Route::get('/Clients/VehicleList/{id}', 'AdminControllers\ClientControllers@VehicleLists');
Route::get('/Clients/Vehicle/{id}/delete', 'AdminControllers\ClientControllers@deleteVehicle')->name('deleteVehicle');
Route::get('/Clients/{id}/delete', 'AdminControllers\ClientControllers@deleteCustomer')->name('deleteCustomer');

Route::get('/Clients/{id}/editClient', 'AdminControllers\ClientControllers@EditClient');
Route::post('/Clients/{id}/UpdateClient', 'AdminControllers\ClientControllers@UpdateClientDeteils')->name('UpdateClientDeteils');


// Vehicle Credit
Route::get('/VehicleCredit', 'AdminControllers\ClientCreditControllers@VehicleCredit');
Route::post('/Clients/addVehicleCredit', 'AdminControllers\ClientCreditControllers@addVehicleCredit')->name('addVehicleCredit');








//Vehicle Renewal
Route::get('/VehicleRenewal', 'AdminControllers\ClientRenewalControllers@AddVehicleRenewal');



