<?php

Route::get('/home', function () {
    $users[] = Auth::user();
    $users[] = Auth::guard()->user();
    $users[] = Auth::guard('client')->user();

    //dd($users);

    return view('client.home');
})->name('home');

Route::get('/getdashboardtotalincomeexpense', 'ClientsControllers\DashboardController@dashboardTotalIncomeExpense');

Route::get('/customer', 'ClientsControllers\CustomerController@show');
Route::get('/customer/add', 'ClientsControllers\CustomerController@add');
Route::get('/customer/{id}/view', 'ClientsControllers\CustomerController@view');
Route::post('/customer/add', 'ClientsControllers\CustomerController@save')->name('addcustomer');
Route::get('/customer/{id}/edit', 'ClientsControllers\CustomerController@edit')->name('editcustomer');
Route::post('/customer/{id}/edit', 'ClientsControllers\CustomerController@update')->name('updatecustomer');
Route::delete('/customer/{id}/delete', 'ClientsControllers\CustomerController@delete')->name('deletecustomer');

Route::get('/staff', 'ClientsControllers\StaffController@show');
Route::get('/staff/add', 'ClientsControllers\StaffController@add');
Route::get('/staff/{id}/view', 'ClientsControllers\StaffController@view');
Route::post('/staff/add', 'ClientsControllers\StaffController@save')->name('addstaff');
Route::get('/staff/{id}/edit', 'ClientsControllers\StaffController@edit')->name('editstaff');
Route::post('/staff/{id}/edit', 'ClientsControllers\StaffController@update')->name('updatestaff');
Route::delete('/staff/{id}/delete', 'ClientsControllers\StaffController@delete')->name('deletestaff');


Route::get('/vehicle', 'ClientsControllers\VehicleController@show');
Route::get('/vehicle/add', 'ClientsControllers\VehicleController@add');
Route::get('/vehicle/{id}/view', 'ClientsControllers\VehicleController@view');
Route::post('/vehicle/add', 'ClientsControllers\VehicleController@save')->name('addvehicle');
Route::get('/vehicle/{id}/edit', 'ClientsControllers\VehicleController@edit')->name('editvehicle');
Route::post('/vehicle/{id}/edit', 'ClientsControllers\VehicleController@update')->name('updatevehicle');
Route::delete('/vehicle/{id}/delete', 'ClientsControllers\VehicleController@delete')->name('deletevehicle');

Route::get('/vehicle/financial-indicator/{id}/add', 'ClientsControllers\VehicleController@AddFinancialIndicator')->name('AddFinancialIndicator');
Route::POST('/vehicle/financial-indicator/{id}/Save', 'ClientsControllers\VehicleController@SaveFinancialIndicator')->name('SaveFinancialIndicator');
Route::get('/vehicle/financial-indicator/{vehicle_id}/{financial_id}/view', 'ClientsControllers\VehicleController@ViewFinancialIndicator')->name('ViewFinancialIndicator');
Route::get('/vehicle/financial-indicator/{vehicle_id}/{financial_id}/edit', 'ClientsControllers\VehicleController@EditFinancialIndicator')->name('EditFinancialIndicator');
Route::post('/vehicle/financial-indicator/{vehicle_id}/{financial_id}/update', 'ClientsControllers\VehicleController@UpdateFinancialIndicator')->name('UpdateFinancialIndicator');






Route::get('/document/{vehicleId}', 'ClientsControllers\DocumentsController@show')->name('document');
Route::get('/document/{vehicleId}/add', 'ClientsControllers\DocumentsController@add')->name('adddocument');
Route::POST('/document/{vehicleId}/add', 'ClientsControllers\DocumentsController@save')->name('savedocument');
Route::get('/document/{id}/view', 'ClientsControllers\DocumentsController@showdocument');
Route::get('/document/{id}/edit', 'ClientsControllers\DocumentsController@editdocument')->name('editdocument');
Route::post('/document/{id}/edit', 'ClientsControllers\DocumentsController@updatedocument')->name('updatedocument');
Route::delete('/document/{id}/delete', 'ClientsControllers\DocumentsController@delete')->name('deletedocument');


Route::get('/entry', 'ClientsControllers\EntryController@add');
Route::post('/entry', 'ClientsControllers\EntryController@save')->name('saveentry');
Route::delete('/entry/{id}/delete', 'ClientsControllers\EntryController@delete')->name('deletEntry');

// VIEW ENTRY
Route::get('/viewentry', 'ClientsControllers\EntryController@viewEntryVehicle');
Route::get('/entry/{id}/view', 'ClientsControllers\EntryController@showOne');
Route::get('/entry/{id}/edit', 'ClientsControllers\EntryController@editEntry')->name('editEntry');
Route::post('/entry/{id}/edit', 'ClientsControllers\EntryController@updateEntry')->name('updateEntry');

Route::get('/viewentry/{id}/vehicle', 'ClientsControllers\EntryController@viewEntryShowAllTrips');
Route::get('/viewentry/{id}/Trips', 'ClientsControllers\EntryController@ViewTripEntries');

//Route::get('/entry/getTripDatas', 'ClientsControllers\EntryController@getTripDatas');



Route::get('/expenseType', 'ClientsControllers\ExpenseController@ExpenseType');
Route::get('/expenseType/add', 'ClientsControllers\ExpenseController@addExpenseType');
Route::post('/expenseType/add', 'ClientsControllers\ExpenseController@saveExpenseType')->name('saveExpenseType');
Route::get('/expenseType/{id}/view', 'ClientsControllers\ExpenseController@viewExpenseType');
Route::get('/expenseType/{id}/edit', 'ClientsControllers\ExpenseController@editExpenseType')->name('editExpenseType');
Route::post('/expenseType/{id}/update', 'ClientsControllers\ExpenseController@updateExpenseType')->name('updateExpenseType');
Route::delete('/expenseType/{id}/delete', 'ClientsControllers\ExpenseController@deleteExpenseType')->name('deleteExpenseType');




// EXPENSE 
Route::get('/expense', 'ClientsControllers\ExpenseController@add');
Route::post('/expense', 'ClientsControllers\ExpenseController@save')->name('addExpense');

// VIEW EXPENSE
Route::get('/viewexpense', 'ClientsControllers\ExpenseController@viewExpenseVehicle');
Route::get('/expense/{id}/view', 'ClientsControllers\ExpenseController@showExpense');
Route::get('/expense/{id}/edit', 'ClientsControllers\ExpenseController@editExpense')->name('editExpense');
Route::post('/expense/{id}/edit', 'ClientsControllers\ExpenseController@updateExpense')->name('updateExpense');
Route::delete('/Expense/{id}/delete', 'ClientsControllers\ExpenseController@delete')->name('deleteExpense');

Route::get('/expense/GetLastExpenseTypeDetail', 'ClientsControllers\ExpenseController@GetLastExpenseTypeDetail');




Route::get('/viewexpense/{id}/vehicle', 'ClientsControllers\ExpenseController@viewExpenseShowAllTrips');
Route::get('/viewexpense/{id}/Trips', 'ClientsControllers\ExpenseController@ViewTripExpenses');

Route::get('/expenses', 'ClientsControllers\ExpenseController@viewExpensesVehicleList');
Route::get('/expenses/{id}/vehicle', 'ClientsControllers\ExpenseController@viewExpensesListWithoutTrip');



// INCOME MODULE
Route::get('/addincome', 'ClientsControllers\IncomeController@showIncomeBalance');
Route::get('/income/{id}/showbalance', 'ClientsControllers\IncomeController@showBalanceList');
Route::post('/incomes/{clientId}/add', 'ClientsControllers\IncomeController@addIncomeAmount')->name('addIncome');
//VIEW INCOME
Route::get('/viewincome', 'ClientsControllers\IncomeController@viewIncome');
Route::get('/income/{id}/view', 'ClientsControllers\IncomeController@showIncome');
Route::get('/income/{id}/edit', 'ClientsControllers\IncomeController@editIncome')->name('editIncome');
Route::post('/income/{id}/update', 'ClientsControllers\IncomeController@updateIncome')->name('updateIncome');
Route::delete('/Income/{id}/delete', 'ClientsControllers\IncomeController@delete')->name('deleteIncome');





//Manager
Route::get('/manager', 'ClientsControllers\ManagerController@show');
Route::get('/manager/add', 'ClientsControllers\ManagerController@add');
Route::post('/manager/add', 'ClientsControllers\ManagerController@save')->name('addmanager');
Route::get('/manager/{id}/view', 'ClientsControllers\ManagerController@viewManager');
Route::get('/manager/{id}/edit', 'ClientsControllers\ManagerController@editManager');
Route::post('/manager/{id}/update', 'ClientsControllers\ManagerController@updateManager')->name('updateManager');
Route::delete('/manager/{id}/delete', 'ClientsControllers\ManagerController@delete')->name('deleteManager');



//Dashboard
Route::get('/dashboard/vehicleWiseCurrentMonthIncome', 'ClientsControllers\dashboardIncomeController@vehicleWiseCurrentMonthIncome');
Route::get('/dashboard/currentMonthIncome/{id}', 'ClientsControllers\dashboardIncomeController@VehicleCurrentMonthIncomeList');



Route::get('/dashboard/vehicleWiseCurrentMonthExpense/{month}/{year}', 'ClientsControllers\dashboardExpenseController@vehicleWiseCurrentMonthExpense');
Route::get('/dashboard/currentMonthExpense/{month}/{year}/{id}', 'ClientsControllers\dashboardExpenseController@VehicleCurrentMonthExpenseList');



Route::get('/dashboard/vehicleWiseCurrentMonthProfit/{month}/{year}', 'ClientsControllers\dashboardProfitController@vehicleWiseCurrentMonthProfit');
Route::get('/dashboard/currentMonthProfit/{month}/{year}/{id}', 'ClientsControllers\dashboardProfitController@VehicleCurrentMonthProfitList');




//TRIP
Route::get('/trip', 'ClientsControllers\TripController@show');
Route::get('/trip/add', 'ClientsControllers\TripController@add');
Route::post('/trip/add', 'ClientsControllers\TripController@save')->name('addTrip');
Route::get('/trip/{id}/view', 'ClientsControllers\TripController@viewTrip');
Route::get('/trip/{id}/edit', 'ClientsControllers\TripController@editTrip')->name('editTrip');
Route::post('/trip/{id}/update', 'ClientsControllers\TripController@updateTrip')->name('updateTrip');


Route::post('/trip/{id}/updateTripStatus', 'ClientsControllers\TripController@updateTripStatus')->name('updateTripStatus');

Route::get('/tripSheet/{id}/show', 'ClientsControllers\TripController@showTripSheet');





// TRIP WISE SHOW DATAS
Route::get('/ViewTripsWise', 'ClientsControllers\TripController@ViewTripsWise')->name('ViewTripWise');
Route::get('/ViewTripsWise/{vehicleID}/showTrips', 'ClientsControllers\TripController@viewVehicleTrips');





//Accounts
Route::get('/accounts', 'ClientsControllers\AccountController@show');
Route::get('/accounts/add', 'ClientsControllers\AccountController@add');
Route::post('/accounts/add', 'ClientsControllers\AccountController@save')->name('addAccount');
Route::get('/accounts/{id}/view', 'ClientsControllers\AccountController@viewAccount');
Route::get('/accounts/{id}/edit', 'ClientsControllers\AccountController@editAccount')->name('editAccount');
Route::post('/accounts/{id}/update', 'ClientsControllers\AccountController@updateAccount')->name('updateAccount');


//Halt
Route::get('/halt', 'ClientsControllers\HaltController@show');
Route::get('/halt/add', 'ClientsControllers\HaltController@add');
Route::post('/halt/add', 'ClientsControllers\HaltController@save')->name('addHalt');
Route::get('/halt/{id}/view', 'ClientsControllers\HaltController@viewHalt');
Route::get('/halt/{id}/edit', 'ClientsControllers\HaltController@editHalt')->name('editHalt');
Route::post('/halt/{id}/update', 'ClientsControllers\HaltController@updateHalt')->name('updateHalt');
Route::delete('/halt/{id}/delete', 'ClientsControllers\HaltController@DeleteHalt')->name('DeleteHalt');


//Trip Amount
Route::get('/tripAmount', 'ClientsControllers\TripAmountController@show');
Route::get('/tripAmount/add', 'ClientsControllers\TripAmountController@add');
Route::post('/tripAmount/add', 'ClientsControllers\TripAmountController@save')->name('addTripAmount');
Route::get('/tripAmount/{id}/view', 'ClientsControllers\TripAmountController@viewTripAmount');
Route::get('/tripAmount/{id}/edit', 'ClientsControllers\TripAmountController@editTripAmount')->name('editTripAmount');
Route::post('/tripAmount/{id}/update', 'ClientsControllers\TripAmountController@updateTripAmount')->name('updateTripAmount');

Route::delete('/tripAmount/{id}/delete', 'ClientsControllers\TripAmountController@delete')->name('deleteTripSheet');




// Client Renewal
Route::get('/renew', 'ClientsControllers\RenewalController@show');
Route::post('/renew', 'ClientsControllers\RenewalController@renew');


//AddVehicleCount
Route::get('/AddVehicleCount', 'ClientsControllers\RenewalController@AddVehicleCount');


//Memo Entry
Route::get('/memoentry', 'ClientsControllers\MemoEntryController@show');
Route::post('/memoentry/add', 'ClientsControllers\MemoEntryController@save')->name('addmemo');


//OIL SERVICE
Route::get('/vehicle/oilservice', 'ClientsControllers\OilServiceController@show');
Route::get('/vehicle/oilservice/{id}/list', 'ClientsControllers\OilServiceController@showOilServiceVehileWiseList')->name('showOilServiceVehileWiseList');
Route::get('/vehicle/oilservice/{id}/add', 'ClientsControllers\OilServiceController@AddOilServiceList')->name('AddOilServiceList');
Route::post('/vehicle/oilservice/{id}/add', 'ClientsControllers\OilServiceController@saveOilServiceList')->name('saveOilServiceList');


//Report
Route::get('/report', 'ClientsControllers\ReportController@Report');
Route::post('/DownloadExpenseReport', 'ClientsControllers\ReportController@DownloadExpenseReport')->name('DownloadExpenseReport');



//Extra Income
Route::get('/extra-income', 'ClientsControllers\ExtraIncomeController@ExtraIncomeVehicleList')->name('ExtraIncomeList');
Route::get('/extra-income/{id}/vehicle', 'ClientsControllers\ExtraIncomeController@view');

Route::get('/extra-income/add', 'ClientsControllers\ExtraIncomeController@add');
Route::post('/extra-income/add', 'ClientsControllers\ExtraIncomeController@save')->name('SaveExtraIncome');
Route::get('/extra-income/{id}/show', 'ClientsControllers\ExtraIncomeController@show');
Route::get('/extra-income/{id}/edit', 'ClientsControllers\ExtraIncomeController@edit')->name('EditExtraIncome');
Route::post('/extra-income/{id}/update', 'ClientsControllers\ExtraIncomeController@UpdateExtraIncome')->name('UpdateExtraIncome');
Route::delete('/extra-income/{id}/delete', 'ClientsControllers\ExtraIncomeController@DeleteExtraIncome')->name('DeleteExtraIncome');

