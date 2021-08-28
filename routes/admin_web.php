<?php

use App\Http\Controllers\Backend\WalletController;
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

Route::prefix('admin') ->name('admin.') ->namespace('Backend') -> middleware('auth:admin_user')-> group(function(){
    Route::get('/','PageController@home')-> name('home');

    Route::resource('admin-user', 'AdminUserController');
    Route::get('admin-user/datatable/ssd', 'AdminUserController@ssd');

    Route::resource('user', 'UserController');
    Route::get('user/datatable/ssd', 'UserController@ssd');

    Route::get('wallet', 'WalletController@index')->name('wallet.index');
    Route::get('wallet/datatable/ssd','WalletController@ssd');

    Route::get('wallet/add/amount','WalletController@addAmount');
    Route::post('wallet/add/amount/store','WalletController@addAmountStore');
    Route::get('wallet/reduce/amount','WalletController@reduceAmount');
    Route::post('wallet/reduce/amount/store','WalletController@reduceAmountStore');
});
