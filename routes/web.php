<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/roadmap', function(){
    return view('roadmap');
});

Route::get('/privacy', function(){
    return view('privacy');
});

Route::get('/terms', function(){
    return view('terms');
});

/*
/----------------------------------------
/ Route cache clear view clear route
/----------------------------------------
*/
Route::get('/cache-clear',function(){
    Artisan::call('cache:clear');
    Artisan::call('config:cache');
    Artisan::call('view:clear');
    Artisan::call('route:clear');
});

Route::get('/entry/getTripDatas', 'customeController@getTripDatas');
Route::get('/vehicle/getLastEntryKm', 'customeController@getVehicleData');

Route::group(['prefix' => 'admin'], function () {
    Route::get('/login', 'AdminAuth\LoginController@showLoginForm')->name('login');
    Route::post('/login', 'AdminAuth\LoginController@login');
    Route::post('/logout', 'AdminAuth\LoginController@logout')->name('logout');

    Route::get('/register', 'AdminAuth\LoginController@showLoginForm')->name('register');
//  Route::post('/register', 'AdminAuth\RegisterController@register');

//  Route::post('/password/email', 'AdminAuth\ForgotPasswordController@sendResetLinkEmail')->name('password.request');
//  Route::post('/password/reset', 'AdminAuth\ResetPasswordController@reset')->name('password.email');
//  Route::get('/password/reset', 'AdminAuth\ForgotPasswordController@showLinkRequestForm')->name('password.reset');
//  Route::get('/password/reset/{token}', 'AdminAuth\ResetPasswordController@showResetForm');
});

Route::group(['prefix' => 'client'], function () {
    Route::get('/', 'ClientAuth\LoginController@showLoginForm')->name('login');
    Route::get('/login', 'ClientAuth\LoginController@showLoginForm')->name('login');
    Route::post('/login', 'ClientAuth\LoginController@login');
    Route::post('/logout', 'ClientAuth\LoginController@logout')->name('logout');

    Route::get('/register', 'ClientAuth\RegisterController@showRegistrationForm')->name('register');
    Route::post('/register', 'ClientAuth\RegisterController@register');

    Route::post('/password/email', 'ClientAuth\ForgotPasswordController@sendResetLinkEmail')->name('password.request');
    Route::post('/password/reset', 'ClientAuth\ResetPasswordController@reset')->name('password.email');
    Route::get('/password/reset', 'ClientAuth\ForgotPasswordController@showLinkRequestForm')->name('password.reset');
    Route::get('/password/reset/{token}', 'ClientAuth\ResetPasswordController@showResetForm');
    Route::get('/verify/{token}', 'ClientAuth\RegisterController@VerifyClient');
});

Route::group(['prefix' => 'manager'], function () {
    Route::get('/', 'ManagerAuth\LoginController@showLoginForm')->name('login');
    Route::get('/login', 'ManagerAuth\LoginController@showLoginForm')->name('login');
    Route::post('/login', 'ManagerAuth\LoginController@login');
    Route::post('/logout', 'ManagerAuth\LoginController@logout')->name('logout');
    Route::post('/password/email', 'ManagerAuth\ForgotPasswordController@sendResetLinkEmail')->name('password.request');
    Route::post('/password/reset', 'ManagerAuth\ResetPasswordController@reset')->name('password.email');
    Route::get('/password/reset', 'ManagerAuth\ForgotPasswordController@showLinkRequestForm')->name('password.reset');
    Route::get('/password/reset/{token}', 'ManagerAuth\ResetPasswordController@showResetForm');
});



/*
/------------------------------------------------------------
/ Routes contain for cron job list
/------------------------------------------------------------
*/


Route::get('email', 'BasicController@ClientMonthlyIncomeExpenseMail');
Route::get('document', 'BasicController@ClientDocumentExpireMail');
Route::get('db-backup-daily', function(){
    $filename = "backup-myvehicle-" . \Carbon\Carbon::now()->format('Y-m-d') . ".gz";
    $command = "mysqldump --user=" . env('DB_USERNAME','root') ." --password=" . env('DB_PASSWORD','') . " --host=" . env('DB_HOST','127.0.0.1') . " " . env('DB_DATABASE','MyVehicle') . "  | gzip > " . public_path() . "/backup/" . $filename;
    $returnVar = NULL;
    $output  = NULL;
    exec($command, $output, $returnVar);
});
Route::get('notification', 'BasicController@notification');
