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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

//only logged in users can view the below pages
Route::group(['middleware'=>'auth'], function() {

    Route::resource('qrcodes', 'QrcodeController')->except(['show']);

    Route::resource('transactions', 'TransactionController');

    Route::resource('users', 'UserController');

    Route::resource('accounts', 'AccountController')->except(['show']);

    Route::get('/accounts/show/{id?}', 'AccountController@show')->name('accounts.show');

    Route::resource('accountHistories', 'AccountHistoryController');

    //only moderators and admins
    Route::group(['middleware'=>'checkmoderator'], function() {
        Route::get('/users', 'UserController@index')->name('users.index');
    });

    //only admins can access this
    Route::resource('roles', 'RoleController')->middleware('checkadmin');

    Route::post('/accounts/apply_for_payout', 'AccountController@apply_for_payout')->name('accounts.apply_for_payout');

    Route::post('/accounts/confirm_payment', 'AccountController@confirm_payment')
    ->name('accounts.confirm_payment')->middleware('checkmoderator'); 

    Route::get('/accounts', 'AccountController@index')
    ->name('accounts.index')->middleware('checkmoderator'); 

    Route::get('/accounts/create', 'AccountController@create')
    ->name('accounts.create')->middleware('checkadmin'); 

    Route::get('/accountHistories', 'AccountHistoryController@index')
    ->name('accountHistories.index')->middleware('checkmoderator'); 

    Route::get('/accountHistories/create', 'AccountHistoryController@create')
    ->name('accountHistories.create')->middleware('checkadmin'); 

});


    Route::get('/qrcode/{id}', 'QrcodeController@show')->name('qrcodes.show');
  
    Route::post('/pay', 'PaymentController@redirectToGateway')->name('pay'); 

    Route::get('/payment/callback', 'PaymentController@handleGatewayCallback');