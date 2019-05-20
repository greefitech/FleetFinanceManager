<?php

Route::get('/home', 'ManagerControllers\EntryController@add')->name('home');



Route::get('/customer', 'ManagerControllers\CustomerController@show');
Route::get('/customer/add', 'ManagerControllers\CustomerController@add');
Route::get('/customer/{id}/view', 'ManagerControllers\CustomerController@view');
Route::post('/customer/add', 'ManagerControllers\CustomerController@save')->name('addcustomer');
Route::get('/customer/{id}/edit', 'ManagerControllers\CustomerController@edit')->name('editcustomer');
Route::post('/customer/{id}/edit', 'ManagerControllers\CustomerController@update')->name('updatecustomer');
Route::delete('/customer/{id}/delete', 'ManagerControllers\CustomerController@delete')->name('deletecustomer');

Route::get('/vehicle', 'ManagerControllers\VehicleController@show');
Route::get('/vehicle/add', 'ManagerControllers\VehicleController@add');
Route::get('/vehicle/{id}/view', 'ManagerControllers\VehicleController@view');
Route::post('/vehicle/add', 'ManagerControllers\VehicleController@save')->name('addvehicle');
Route::get('/vehicle/{id}/edit', 'ManagerControllers\VehicleController@edit')->name('editvehicle');
Route::post('/vehicle/{id}/edit', 'ManagerControllers\VehicleController@update')->name('updatevehicle');
Route::delete('/vehicle/{id}/delete', 'ManagerControllers\VehicleController@delete')->name('deletevehicle');


Route::get('/document/{vehicleId}', 'ManagerControllers\DocumentsController@show')->name('document');
Route::get('/document/{vehicleId}/add', 'ManagerControllers\DocumentsController@add')->name('adddocument');
Route::POST('/document/{vehicleId}/add', 'ManagerControllers\DocumentsController@save')->name('savedocument');
Route::get('/document/{id}/view', 'ManagerControllers\DocumentsController@showdocument');
Route::get('/document/{id}/edit', 'ManagerControllers\DocumentsController@editdocument')->name('editdocument');
Route::post('/document/{id}/edit', 'ManagerControllers\DocumentsController@updatedocument')->name('updatedocument');
Route::delete('/document/{id}/delete', 'ManagerControllers\DocumentsController@delete')->name('deletedocument');




Route::get('/entry', 'ManagerControllers\EntryController@add');
Route::post('/entry', 'ManagerControllers\EntryController@save')->name('saveentry');
Route::delete('/entry/{id}/delete', 'ManagerControllers\EntryController@delete')->name('deleteEntry');
Route::get('/viewentry', 'ManagerControllers\EntryController@viewEntry');
Route::get('/entry/{id}/view', 'ManagerControllers\EntryController@showOne');
Route::get('/entry/{id}/edit', 'ManagerControllers\EntryController@editEntry')->name('editEntry');
Route::post('/entry/{id}/edit', 'ManagerControllers\EntryController@updateEntry')->name('updateEntry');



// EXPENSE
Route::get('/expense', 'ManagerControllers\ExpenseController@add');
Route::post('/expense', 'ManagerControllers\ExpenseController@save')->name('addExpense');
Route::get('/viewexpense', 'ManagerControllers\ExpenseController@viewexpense');
Route::get('/expense/{id}/view', 'ManagerControllers\ExpenseController@showExpense');
Route::get('/expense/{id}/edit', 'ManagerControllers\ExpenseController@editExpense')->name('editExpense');
Route::post('/expense/{id}/edit', 'ManagerControllers\ExpenseController@updateExpense')->name('updateExpense');
Route::delete('/Expense/{id}/delete', 'ManagerControllers\ExpenseController@delete')->name('deleteExpense');



Route::get('/expenseType', 'ManagerControllers\ExpenseController@ExpenseType');
Route::get('/expenseType/add', 'ManagerControllers\ExpenseController@addExpenseType');
Route::post('/expenseType/add', 'ManagerControllers\ExpenseController@saveExpenseType')->name('saveExpenseType');
Route::get('/expenseType/{id}/view', 'ManagerControllers\ExpenseController@viewExpenseType');
Route::get('/expenseType/{id}/edit', 'ManagerControllers\ExpenseController@editExpenseType')->name('editExpenseType');
Route::post('/expenseType/{id}/update', 'ManagerControllers\ExpenseController@updateExpenseType')->name('updateExpenseType');
Route::delete('/expenseType/{id}/delete', 'ManagerControllers\ExpenseController@deleteExpenseType')->name('deleteExpenseType');



// INCOME MODULE
Route::get('/addincome', 'ManagerControllers\IncomeController@showIncomeBalance');
Route::get('/income/{id}/showbalance', 'ManagerControllers\IncomeController@showBalanceList');
Route::post('/incomes/{clientId}/add', 'ManagerControllers\IncomeController@addIncomeAmount')->name('addIncome');
Route::get('/viewincome', 'ManagerControllers\IncomeController@viewIncome');
Route::get('/income/{id}/view', 'ManagerControllers\IncomeController@showIncome');
Route::get('/income/{id}/edit', 'ManagerControllers\IncomeController@editIncome')->name('editIncome');
Route::post('/income/{id}/update', 'ManagerControllers\IncomeController@updateIncome')->name('updateIncome');
Route::delete('/Income/{id}/delete', 'ManagerControllers\IncomeController@delete')->name('deleteIncome');






//TRIP
Route::get('/trip', 'ManagerControllers\TripController@show');
Route::get('/trip/add', 'ManagerControllers\TripController@add');
Route::post('/trip/add', 'ManagerControllers\TripController@save')->name('addTrip');
Route::get('/trip/{id}/view', 'ManagerControllers\TripController@viewTrip');
Route::get('/trip/{id}/edit', 'ManagerControllers\TripController@editTrip')->name('editTrip');
Route::post('/trip/{id}/update', 'ManagerControllers\TripController@updateTrip')->name('updateTrip');

Route::post('/trip/{id}/updateTripStatus', 'ManagerControllers\TripController@updateTripStatus')->name('updateTripStatus');




//Trip Amount
Route::get('/tripAmount', 'ManagerControllers\TripAmountController@show');
Route::get('/tripAmount/add', 'ManagerControllers\TripAmountController@add');
Route::post('/tripAmount/add', 'ManagerControllers\TripAmountController@save')->name('addTripAmount');
Route::get('/tripAmount/{id}/view', 'ManagerControllers\TripAmountController@viewTripAmount');
Route::get('/tripAmount/{id}/edit', 'ManagerControllers\TripAmountController@editTripAmount')->name('editTripAmount');
Route::post('/tripAmount/{id}/update', 'ManagerControllers\TripAmountController@updateTripAmount')->name('updateTripAmount');


// Client Renewal
Route::get('/renew', 'ManagerControllers\RenewalController@show');
Route::post('/renew', 'ManagerControllers\RenewalController@renew');





