<?php

use App\Http\Controllers\api\v1\AuthController;
use App\Http\Controllers\api\v1\QicardController;
use App\Mail\resetPasswordMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;


Route::group(['prefix' => 'v1', 'namespace' => 'api\v1',], function () {
    Route::post('/login', 'AuthController@login');
    Route::post('/signIn', 'AuthController@signIn');


    route::post('reset_password', [\App\Http\Controllers\api\v1\AuthController::class, 'resetPassword']);
    route::post('confirm_password', [\App\Http\Controllers\api\v1\AuthController::class, 'confirmPassword']);

    Route::group(['middleware' => ['auth:sanctum', 'apiActiveUser']], function () {
        Route::get('/reports', 'ReportController@index');
        Route::get('/companies', 'CompanyController@index')->name('companies');
        Route::get('/companies/{company}', 'CompanyController@show');
        Route::put('/cards', 'CardController@update');
        Route::get('/ads', 'AdsController@index');
        Route::post('/transaction/{user}', 'UserController@transaction');
        Route::get('/user', 'UserController@show');
        Route::get('/orders/type', 'OrderTypeController@index');
        Route::post('/orders', 'OrderController@store');
        Route::get('/orders', 'OrderController@index');
        Route::get('/orders/{id}', 'OrderController@show');

        route::post('recharge_balance', [\App\Http\Controllers\api\v1\AuthController::class, 'rechargeBalance']);
        route::post('addBills', [\App\Http\Controllers\api\v1\QicardController::class, 'addBill']);
    });
    route::post('get_notification', [\App\Http\Controllers\api\v1\QicardController::class, 'getNotification']);

    Route::get('/cities', 'CityController@index');
    Route::get('/amounts', 'AmountController@index');
});