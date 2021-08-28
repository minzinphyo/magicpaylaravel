<?php

use App\Http\Controllers\Backend\PageController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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


//Admin User Auth
Route::get('admin/login','Auth\AdminLoginController@showLoginForm');
Route::post('admin/login','Auth\AdminLoginController@login')-> name('admin.login');
Route::post('admin/logout','Auth\AdminLoginController@logout')-> name('admin.logout');

//User Auth
Auth::routes();

Route::middleware('auth')->namespace('Frontend')->group(function(){
    Route::get('/','PageController@home')->name('home');
    Route::get('/profile','PageController@profile')->name('profile');
    Route::get('/update-password','PageController@updatePassword')-> name('update-password');
    Route::post('/update-password','PageController@updatePasswordStore')-> name('update-password.store');

    Route::get('/wallet','PageController@wallet')-> name('wallet');

    Route::get('/transfer','PageController@transfer');
    Route::get('/transfer/confirm','PageController@transferConfirm');
    Route::post('/transfer/complete','PageController@transferComplete');

    Route::get('/transaction','PageController@transaction');
    Route::get('/transaction/{trx_id}','PageController@transactionDetail');

    Route::get('/to-account-verify','PageController@accountVerify');
    Route::get('/password-check','PageController@passwordCheck');

    Route::get('/transfer-hash','PageController@transferHash');

    Route::get('/receive-qr','PageController@receiveQR');
    Route::get('/scan-and-pay','PageController@scanAndPay');

    //Notifications
    Route::get('/notification','NotificationController@index');
    Route::get('/notification/{id}','NotificationController@show');
});

