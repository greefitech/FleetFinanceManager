<?php

Route::get('/home', function () {
    $users[] = Auth::user();
    $users[] = Auth::guard()->user();
    $users[] = Auth::guard('client')->user();
    return view('client.home');
})->name('home');

//Dashboard
Route::group(['prefix' => 'dashboard'], function() {
    Route::get('/total-income-expense', 'ClientController\DashboardController@DashboardTotalIncomeExpense');
    Route::get('/profit/{month}/{year}/vehicle-list', 'ClientController\DashboardController@DashboardVehicleProfitTotal')->name('DashboardVehicleProfitTotal');
    Route::get('/expense/{month}/{year}/vehicle-list', 'ClientController\DashboardController@DashboardVehicleExpenseTotal')->name('DashboardVehicleExpenseTotal');

    Route::get('/profit/{vehicleid}/{month}/{year}/list', 'ClientController\DashboardController@DashboardVehicleProfitList')->name('DashboardVehicleProfitList');
    Route::get('/non-trip-expense/{vehicleid}/{month}/{year}/list', 'ClientController\DashboardController@DashboardVehicleNonTripExpenseList')->name('DashboardVehicleNonTripExpenseList');
    Route::get('/get-dashboard-chart-values', 'ClientController\DashboardController@DashboardGetChartValues');
    Route::get('/un-paid-expense-list', 'ClientController\DashboardController@unPaidExpenseList');
});

/*
*------------------------------
* Master Route list
*------------------------------
*/


/*Master route list*/
Route::group(['prefix' => 'master'], function() {
	Route::resource('/customers','ClientController\CustomerController');
	Route::resource('/staffs','ClientController\StaffController');
	Route::resource('/vehicles','ClientController\VehicleController');
	Route::resource('/vehicle-service', 'ClientController\Master\VehicleServiceController');
	Route::resource('/tyre', 'ClientController\Master\TyreController');
	Route::resource('/expense-types', 'ClientController\ExpenseTypeController');
    Route::resource('/vendor', 'ClientController\Master\VendorController');
});

//Documents
Route::get('/documents/{vehicleid}/view', 'ClientController\DocumentController@view')->name('ViewDocuments');
Route::get('/document/{vehicleid}/add', 'ClientController\DocumentController@add')->name('AddDocument');
Route::post('/document/{vehicleid}/save', 'ClientController\DocumentController@save')->name('SaveDocument');
Route::get('/document/{documentid}/edit', 'ClientController\DocumentController@edit')->name('EditDocument');
Route::post('/document/{documentid}/update', 'ClientController\DocumentController@update')->name('UpdateDocument');
Route::delete('/document/{documentid}/delete', 'ClientController\DocumentController@delete')->name('DeleteDocument');

//Financial Indicator
Route::get('/financial-indicator/{vehicleid}/add', 'ClientController\FinancialIndicatorController@add')->name('AddFinancialIndicators');
Route::post('/financial-indicator/{vehicleid}/save', 'ClientController\FinancialIndicatorController@save')->name('SaveFinancialIndicators');
Route::get('/financial-indicator/{indicatorid}/view', 'ClientController\FinancialIndicatorController@view')->name('ViewFinancialIndicators');
Route::get('/financial-indicator/{indicatorid}/edit', 'ClientController\FinancialIndicatorController@edit')->name('EditFinancialIndicators');
Route::post('/financial-indicator/{vehicleid}/{indicatorid}/update', 'ClientController\FinancialIndicatorController@update')->name('UpdateFinancialIndicators');


//Account
Route::get('/accounts', 'ClientController\AccountController@view')->name('ViewAccounts');
Route::get('/account/add', 'ClientController\AccountController@add')->name('AddAccount');
Route::post('/account/add', 'ClientController\AccountController@save')->name('SaveAccount');
Route::get('/account/{id}/edit', 'ClientController\AccountController@edit')->name('EditAccount');
Route::post('/account/{id}/update', 'ClientController\AccountController@update')->name('UpdateAccount');
Route::delete('/account/{id}/delete', 'ClientController\AccountController@delete')->name('DeleteAccount');
Route::get('/account/{id}/view', 'ClientController\AccountController@ViewAccountDetail')->name('ViewAccountDetail');
Route::get('/accounts/{AccountId}/{VehicleId}/view', 'ClientController\AccountController@AccountDetailVehicleWise');

//RTO Master
// Route::resource('/rto-masters', 'ClientController\RTOMasterController');
Route::get('/rto-masters', 'ClientController\RTOMasterController@view')->name('ViewRTOMasters');
Route::get('/rto-master/add', 'ClientController\RTOMasterController@add')->name('AddRTOMaster');
Route::post('/rto-master/save', 'ClientController\RTOMasterController@save')->name('SaveRTOMaster');
Route::get('/rto-master/{id}/edit', 'ClientController\RTOMasterController@edit')->name('EditRTOMaster');
Route::post('/rto-master/{id}/update', 'ClientController\RTOMasterController@update')->name('UpdateRTOMaster');
Route::delete('/rto-master/{id}/delete', 'ClientController\RTOMasterController@delete')->name('DeleteRTOMaster');

//TRIP
Route::get('/trip/add', 'ClientController\TripController@add');
Route::post('/trip/add', 'ClientController\TripController@save')->name('SaveTrip');
Route::get('/trip/{id}/edit', 'ClientController\TripController@edit')->name('EditTrip');
Route::post('/trip/{id}/edit', 'ClientController\TripController@update')->name('UpdateTrip');
Route::post('/trip/{id}/status/update', 'ClientController\TripController@UpdateTripStatus')->name('UpdateTripStatus');
Route::post('/trip-status-update', 'ClientController\TripController@UpdateTripStatusAjax');


//Entry
Route::get('/entry/memo', 'ClientController\MemoController@memo');
Route::post('/entry/memo', 'ClientController\MemoController@SaveMemo')->name('SaveMemo');
Route::get('/entry/memo/view', 'ClientController\MemoController@ViewTempMemo')->name('ViewMemoList');
Route::get('/entry/memo/{id}/edit', 'ClientController\MemoController@edit')->name('EditMemo');
Route::delete('/entry/temp-memo/{id}/delete', 'ClientController\MemoController@deleteTempMemo')->name('DeleteMemo');
Route::put('/entry/memo/{id}/update', 'ClientController\MemoController@updateMemo')->name('updateMemo');

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

Route::get('/entry/memo/vendors', function (){
    return GetVendorOption();
});

Route::get('/check-entry-already-present', 'ClientController\MemoController@checkEntryAlreadyPresent');


// Route::resource('/entry', 'ClientController\EntryController');

Route::get('/entry/add', 'ClientController\EntryController@add');
Route::post('/entry/add', 'ClientController\EntryController@save')->name('SaveEntry');
Route::get('/entry/{id}/edit', 'ClientController\EntryController@edit')->name('EditEntry');
Route::post('/entry/{id}/update', 'ClientController\EntryController@update')->name('UpdateEntry');
Route::delete('/entry/{id}/delete', 'ClientController\EntryController@delete')->name('DeleteEntry');


//Expense NON-Trip
Route::get('/non-trip-expense/create', 'ClientController\ExpenseController@CreateNonTripExpense');
Route::post('/non-trip-expense/create', 'ClientController\ExpenseController@SaveNonTripExpense');
Route::get('/non-trip-expense/{id}/edit', 'ClientController\ExpenseController@EditNonTripExpense');
Route::post('/non-trip-expense/{id}/update', 'ClientController\ExpenseController@UpdateNonTripExpense');
Route::post('/delete-non-trip-expense', 'ClientController\ExpenseController@DeleteMultipleNonTripExpense');


//Expense
Route::get('/expense/add', 'ClientController\ExpenseController@add');
Route::post('/expense/add', 'ClientController\ExpenseController@save')->name('SaveExpense');
Route::get('/expense/{id}/edit', 'ClientController\ExpenseController@edit')->name('EditExpense');
Route::post('/expense/{id}/update', 'ClientController\ExpenseController@update')->name('UpdateExpense');
Route::delete('/expense/{id}/delete', 'ClientController\ExpenseController@delete')->name('DeleteExpense');

Route::get('/expense-vehicle-list', 'ClientController\ExpenseController@ExpenseVehcleListNonTrip')->name('ExpenseVehcleListNonTrip');
Route::get('/expense/vehicle/{vehicleid}/non-trip-expense', 'ClientController\ExpenseController@NonTripVehicleExpenseList')->name('NonTripVehicleExpenseList');
Route::get('/expense/GetLastExpenseTypeDetail', 'ClientController\ExpenseController@GetLastExpenseTypeDetail');

//Halt
Route::get('/halt/add', 'ClientController\HaltController@add')->name('AddHalt');
Route::post('/halt/add', 'ClientController\HaltController@save')->name('SaveHalt');
Route::get('/halt/{id}/edit', 'ClientController\HaltController@edit')->name('EditHalt');
Route::post('/halt/{id}/update', 'ClientController\HaltController@update')->name('UpdateHalt');
Route::delete('/halt/{id}/delete', 'ClientController\HaltController@delete')->name('DeleteHalt');

//Halt
Route::get('/trip-advance/add', 'ClientController\TripAdvanceController@add')->name('AddTripAdvance');
Route::post('/trip-advance/add', 'ClientController\TripAdvanceController@save')->name('SaveTripAdvance');
Route::get('/trip-advance/{id}/edit', 'ClientController\TripAdvanceController@edit')->name('EditTripAdvance');
Route::post('/trip-advance/{id}/update', 'ClientController\TripAdvanceController@update')->name('UpdateTripAdvance');
Route::delete('/trip-advance/{id}/delete', 'ClientController\TripAdvanceController@delete')->name('DeleteTripAdvance');

//Income
Route::get('/income/add', 'ClientController\IncomeController@IncomeBalanceCustomerList')->name('IncomeBalanceCustomerList');
Route::get('/income/customer/{customerid}/add', 'ClientController\IncomeController@AddCustomerIncome')->name('AddCustomerIncome');
Route::post('/income/customer/{customerid}/save', 'ClientController\IncomeController@SaveCustomerIncome')->name('SaveCustomerIncome');
Route::get('/incomes', 'ClientController\IncomeController@view')->name('ViewIncome');
Route::get('/income/{id}/edit', 'ClientController\IncomeController@edit')->name('EditIncome');
Route::post('/income/{id}/update', 'ClientController\IncomeController@update')->name('UpdateIncome');
Route::delete('/income/{id}/delete', 'ClientController\IncomeController@delete')->name('DeleteIncome');

//Extra Income
Route::get('/extra-income/add', 'ClientController\ExtraIncomeController@add')->name('AddExtraIncome');
Route::post('/extra-income/add', 'ClientController\ExtraIncomeController@save')->name('SaveExtraIncome');
Route::get('/extra-incomes', 'ClientController\ExtraIncomeController@view')->name('ViewExtraIncomes');
Route::get('/extra-income/vehicle/{vehicleid}/list', 'ClientController\ExtraIncomeController@ViewExtraIncomeVehicleWiseList')->name('ViewExtraIncomeVehicleWiseList');
Route::get('/extra-income/{expenseid}/edit', 'ClientController\ExtraIncomeController@edit')->name('EditExtraIncome');
Route::post('/extra-income/{expenseid}/update', 'ClientController\ExtraIncomeController@update')->name('UpdateExtraIncome');
Route::delete('/extra-income/{expenseid}/delete', 'ClientController\ExtraIncomeController@delete')->name('DeleteExtraIncome');


//TRIP WISE
Route::get('/Vehicle-list', 'ClientController\TripWiseController@ViewVehicleList')->name('ViewVehicleList');
Route::get('/Vehicle-list/{vehicleid}/trip-list', 'ClientController\TripWiseController@ViewTripListVehicleWise')->name('ViewTripListVehicleWise');
Route::get('/Vehicle-trip/{tripid}/entry-list', 'ClientController\TripWiseController@ViewTripEntryList')->name('ViewTripEntryList');
Route::get('/Vehicle-trip/{tripid}/expense-list', 'ClientController\TripWiseController@ViewTripExpenseList')->name('ViewTripExpenseList');
Route::get('/Vehicle-trip/{tripid}/halt-list', 'ClientController\TripWiseController@ViewTripHaltList')->name('ViewTripHaltList');
Route::get('/Vehicle-trip/{tripid}/trip-advance-list', 'ClientController\TripWiseController@ViewTripAdvanceList')->name('ViewTripAdvanceList');
Route::delete('/Vehicle-trip/{tripid}/delete-trip', 'ClientController\TripWiseController@DeleteTripSheetData')->name('DeleteTripSheetData');

/*Undo Delete Trip*/
Route::get('/Vehicle-list-trip-undo/{id}', 'ClientController\TripWiseController@TripUndoList');
//Trip Sheet
Route::get('/trip-sheet/{tripid}/download', 'ClientController\TripSheetController@DownloadTripSheet')->name('DownloadTripSheet');

/*=======================
	Profile Route list
=========================*/
Route::group(['prefix'=>'profile'],function(){
	Route::get('/', 'ClientController\ProfileController@profile')->name('profile');
	Route::post('/', 'ClientController\ProfileController@UpdateProfile')->name('UpdateProfile');
	Route::get('/change-password', 'ClientController\ProfileController@ChangePassword')->name('ChangePassword');
	Route::post('/update-password', 'ClientController\ProfileController@UpdatePassword')->name('UpdatePassword');
});

/*=======================
    Manager
=========================*/
Route::get('/managers', 'ClientController\ManagerController@view')->name('ViewManagers');
Route::get('/manager/add', 'ClientController\ManagerController@add')->name('AddManager');
Route::post('/manager/save', 'ClientController\ManagerController@save')->name('SaveManager');
Route::get('/manager/{id}/edit', 'ClientController\ManagerController@edit')->name('EditManager');
Route::post('/manager/{id}/update', 'ClientController\ManagerController@update')->name('UpdateManager');


//Report
Route::get('/report/expense-report', 'ClientController\ReportController@ExpenseReport')->name('ExpenseReport');
Route::post('/report/expense-report/download', 'ClientController\ReportController@DownloadExpenseReport')->name('DownloadExpenseReport');


Route::get('getendingkm','ClientController\MemoController@getendingkm');


/*===============================
    Auto Search for vehicle
=================================*/
Route::get('AutoExpense','ClientController\ExpenseController@AutoExpense')->name('AutoExpense');
Route::get('AutoVehicle','ClientController\ExpenseController@AutoVehicle')->name('AutoVehicle');
Route::get('AutoStaff','ClientController\TripController@AutoStaff')->name('AutoStaff');
Route::get('AutoCustomer','ClientController\EntryController@AutoCustomer')->name('AutoCustomer');


//auditor

/*=====================
         SETTING
=======================*/
Route::group(['prefix' => 'setting'], function() {
    Route::resource('/service', 'ClientController\Setting\ServiceController');
    Route::get('/services/VehicleWise/{VehicleId}', 'ClientController\Setting\ServiceController@VehicleWiseService');
    Route::get('/services/VehicleWise/Service/{ServiceTypeId}/{VehicleId}', 'ClientController\Setting\ServiceController@editService');


    Route::resource('/tyre', 'ClientController\Setting\TyreController');
    Route::get('/tyre/vehicle/{vehicleid}/assign-tyre/{assignedtyreid}/edit',  'ClientController\Setting\TyreController@EditVehicleAssignTyre')->name('EditVehicleAssignTyre');
    Route::post('/tyre/vehicle/{vehicleid}/assign-tyre/{assignedtyreid}/update',  'ClientController\Setting\TyreController@UpdateVehicleAssignTyre')->name('UpdateVehicleAssignTyre');
    Route::get('/tyre/vehicle/{vehicleid}/status/{assignedtyreid}/add',  'ClientController\Setting\TyreController@AddTyreCurrentStatusVehicle')->name('AddTyreCurrentStatusVehicle');
    Route::post('/tyre/vehicle/{vehicleid}/status/{assignedtyreid}/add',  'ClientController\Setting\TyreController@SaveTyreCurrentStatusVehicle')->name('SaveTyreCurrentStatusVehicle');
});



/*=================================
    Vendor Payment
===================================*/

Route::group(['prefix' => 'vendor-payment'], function() {
    Route::resource('/vendor-list', 'ClientController\vendorPayment\VendorPaymentController');
    Route::resource('/vendor-payment-list', 'ClientController\vendorPayment\VendorPaymentListController');
});