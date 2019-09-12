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

//TRIP
Route::get('/trip/add', 'ManagerController\TripController@add');
Route::post('/trip/add', 'ManagerController\TripController@save')->name('SaveTrip');
Route::get('/trip/{id}/edit', 'ManagerController\TripController@edit')->name('EditTrip');
Route::post('/trip/{id}/edit', 'ManagerController\TripController@update')->name('UpdateTrip');
Route::post('/trip/{id}/status/update', 'ManagerController\TripController@UpdateTripStatus')->name('UpdateTripStatus');


//Entry
Route::get('/entry/memo', 'ManagerController\MemoController@memo');
Route::post('/entry/memo', 'ManagerController\MemoController@SaveMemo')->name('SaveMemo');

//GET AJAX DATA MEMO
Route::get('/entry/memo/expense-type', function (){
    return GetExpenseTypesOption();
});
Route::get('/entry/memo/accounts', function (){
    return GetAccountsOption();
});

Route::get('/entry/memo/customers', function (){
    return GetCustomersOption();
});

Route::get('/entry/memo/RTOMasterData', function (){
    return GetRTOMasterDataInputs();
});


Route::get('/entry/add', 'ManagerController\EntryController@add');
Route::post('/entry/add', 'ManagerController\EntryController@save')->name('SaveEntry');
Route::get('/entry/{id}/edit', 'ManagerController\EntryController@edit')->name('EditEntry');
Route::post('/entry/{id}/update', 'ManagerController\EntryController@update')->name('UpdateEntry');
Route::delete('/entry/{id}/delete', 'ManagerController\EntryController@delete')->name('DeleteEntry');


//Expense
Route::get('/expense/add', 'ManagerController\ExpenseController@add');
Route::post('/expense/add', 'ManagerController\ExpenseController@save')->name('SaveExpense');
Route::get('/expense/{id}/edit', 'ManagerController\ExpenseController@edit')->name('EditExpense');
Route::post('/expense/{id}/update', 'ManagerController\ExpenseController@update')->name('UpdateExpense');
Route::delete('/expense/{id}/delete', 'ManagerController\ExpenseController@delete')->name('DeleteExpense');

Route::get('/expense-vehicle-list', 'ManagerController\ExpenseController@ExpenseVehcleListNonTrip')->name('ExpenseVehcleListNonTrip');
Route::get('/expense/vehicle/{vehicleid}/non-trip-expense', 'ManagerController\ExpenseController@NonTripVehicleExpenseList')->name('NonTripVehicleExpenseList');
Route::get('/expense/GetLastExpenseTypeDetail', 'ManagerController\ExpenseController@GetLastExpenseTypeDetail');

//Halt
Route::get('/halt/add', 'ManagerController\HaltController@add')->name('AddHalt');
Route::post('/halt/add', 'ManagerController\HaltController@save')->name('SaveHalt');
Route::get('/halt/{id}/edit', 'ManagerController\HaltController@edit')->name('EditHalt');
Route::post('/halt/{id}/update', 'ManagerController\HaltController@update')->name('UpdateHalt');
Route::delete('/halt/{id}/delete', 'ManagerController\HaltController@delete')->name('DeleteHalt');

//Halt
Route::get('/trip-advance/add', 'ManagerController\TripAdvanceController@add')->name('AddTripAdvance');
Route::post('/trip-advance/add', 'ManagerController\TripAdvanceController@save')->name('SaveTripAdvance');
Route::get('/trip-advance/{id}/edit', 'ManagerController\TripAdvanceController@edit')->name('EditTripAdvance');
Route::post('/trip-advance/{id}/update', 'ManagerController\TripAdvanceController@update')->name('UpdateTripAdvance');
Route::delete('/trip-advance/{id}/delete', 'ManagerController\TripAdvanceController@delete')->name('DeleteTripAdvance');

//Income
Route::get('/income/add', 'ManagerController\IncomeController@IncomeBalanceCustomerList')->name('IncomeBalanceCustomerList');
Route::get('/income/customer/{customerid}/add', 'ManagerController\IncomeController@AddCustomerIncome')->name('AddCustomerIncome');
Route::post('/income/customer/{customerid}/save', 'ManagerController\IncomeController@SaveCustomerIncome')->name('SaveCustomerIncome');
Route::get('/incomes', 'ManagerController\IncomeController@view')->name('ViewIncome');
Route::get('/income/{id}/edit', 'ManagerController\IncomeController@edit')->name('EditIncome');
Route::post('/income/{id}/update', 'ManagerController\IncomeController@update')->name('UpdateIncome');
Route::delete('/income/{id}/delete', 'ManagerController\IncomeController@delete')->name('DeleteIncome');

//Extra Income
Route::get('/extra-income/add', 'ManagerController\ExtraIncomeController@add')->name('AddExtraIncome');
Route::post('/extra-income/add', 'ManagerController\ExtraIncomeController@save')->name('SaveExtraIncome');
Route::get('/extra-incomes', 'ManagerController\ExtraIncomeController@view')->name('ViewExtraIncomes');
Route::get('/extra-income/vehicle/{vehicleid}/list', 'ManagerController\ExtraIncomeController@ViewExtraIncomeVehicleWiseList')->name('ViewExtraIncomeVehicleWiseList');
Route::get('/extra-income/{expenseid}/edit', 'ManagerController\ExtraIncomeController@edit')->name('EditExtraIncome');
Route::post('/extra-income/{expenseid}/update', 'ManagerController\ExtraIncomeController@update')->name('UpdateExtraIncome');
Route::delete('/extra-income/{expenseid}/delete', 'ManagerController\ExtraIncomeController@delete')->name('DeleteExtraIncome');


//TRIP WISE
Route::get('/Vehicle-list', 'ManagerController\TripWiseController@ViewVehicleList')->name('ViewVehicleList');
Route::get('/Vehicle-list/{vehicleid}/trip-list', 'ManagerController\TripWiseController@ViewTripListVehicleWise')->name('ViewTripListVehicleWise');
Route::get('/Vehicle-trip/{tripid}/entry-list', 'ManagerController\TripWiseController@ViewTripEntryList')->name('ViewTripEntryList');
Route::get('/Vehicle-trip/{tripid}/expense-list', 'ManagerController\TripWiseController@ViewTripExpenseList')->name('ViewTripExpenseList');
Route::get('/Vehicle-trip/{tripid}/halt-list', 'ManagerController\TripWiseController@ViewTripHaltList')->name('ViewTripHaltList');
Route::get('/Vehicle-trip/{tripid}/trip-advance-list', 'ManagerController\TripWiseController@ViewTripAdvanceList')->name('ViewTripAdvanceList');

//Trip Sheet
Route::get('/trip-sheet/{tripid}/download', 'ManagerController\TripSheetController@DownloadTripSheet')->name('DownloadTripSheet');



//profile
Route::get('/profile', 'ManagerController\ProfileController@profile')->name('profile');
Route::post('/profile', 'ManagerController\ProfileController@UpdateProfile')->name('UpdateProfile');
Route::get('/profile/change-password', 'ManagerController\ProfileController@ChangePassword')->name('ChangePassword');
Route::post('/profile/update-password', 'ManagerController\ProfileController@UpdatePassword')->name('UpdatePassword');


//profile
Route::get('/managers', 'ManagerController\ManagerController@view')->name('ViewManagers');
Route::get('/manager/add', 'ManagerController\ManagerController@add')->name('AddManager');
Route::post('/manager/save', 'ManagerController\ManagerController@save')->name('SaveManager');
Route::get('/manager/{id}/edit', 'ManagerController\ManagerController@edit')->name('EditManager');
Route::post('/manager/{id}/update', 'ManagerController\ManagerController@update')->name('UpdateManager');





//Report
Route::get('/report/expense-report', 'ManagerController\ReportController@ExpenseReport')->name('ExpenseReport');
Route::post('/report/expense-report/download', 'ManagerController\ReportController@DownloadExpenseReport')->name('DownloadExpenseReport');

