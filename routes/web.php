<?php

use App\Http\Controllers\ApiCardController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Auth::routes();


Route::get('/guest', function () {
    return view('cards.guest');
})->name('guest');

Route::post('login', 'Auth\LoginController@login')->name('web.login');
Route::post('register', 'Auth\RegisterController@create');

Route::group(['middleware' => 'auth'], function () {
    Route::resource('user', 'UserController', ['except' => ['show']]);
    Route::get('profile', ['as' => 'profile.edit', 'uses' => 'ProfileController@edit']);
});

Route::middleware(['auth', 'ActiveUser'])->group(function () {

    Route::get('user/search', 'UserController@search')->name('user.search');
    Route::get('virtualBalance/datatable', 'VirtualBalanceController@dataTable')->name('virtualBalance.datatable');

    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('/', 'HomeController@index');

    Route::get('card/datatable', 'CardController@dataTable')->name('card.datatable');
    Route::get('card/show/disable', 'CardController@showDisable')->name('card.show.disable');
    Route::get('card/search', 'CardController@search')->name('card.search');
    Route::post('card/disable', 'CardController@disable')->name('card.disable');
    Route::post('card/amount', 'CardController@amount')->name('card.amount');
    Route::get('order/datatable', 'OrderController@dataTable')->name('order.datatable');
    Route::put('/order_type_active', [\App\Http\Controllers\OrderTypeController::class, 'activeOrderType'])->name('order_type_active');
    Route::put('/order_type_edit', [\App\Http\Controllers\OrderTypeController::class, 'update'])->name('order_type_update');
    Route::get('/charge_report', [\App\Http\Controllers\LogController::class, 'getChargeReport'])->name('charge_report');

    Route::put('profile', 'ProfileController@update')->name('profile.update');
    Route::put('order/approve/{order?}', 'OrderController@approve')->name('order.approve');
    Route::put('user/balance/{user}', 'UserController@updateBalance')->name('user.balance.update');
    Route::get('user/{user}', 'UserController@update')->name('user.update');

    Route::get('users/{user}/userPermissions/{permission}', 'UserController@userPermissions')->name('user.userPermissions');
    Route::get('users/{user}/userRoles/{role}', 'UserController@userRoles')->name('user.userRoles');

    Route::get('log/datatable', 'LogController@dataTable')->name('log.datatable');
    Route::get('datatable_cahrge_balance', 'LogController@dataTableChargeReport')->name('log.datatable_cahrge_balance');

    Route::get('delete_company/{id}', 'CompanyController@delete')->name('company.delete');


    Route::resource('company', 'CompanyController');
    Route::resource('log', 'LogController');
    Route::resource('virtualBalance', 'VirtualBalanceController');
    Route::resource('card', 'CardController');
    Route::resource('city', 'CityController');
    Route::resource('user', 'UserController');
    Route::resource('amount', 'AmountController');
    Route::resource('users', 'UserController');
    Route::resource('ads', 'AdsController');
    Route::resource('order_type', 'OrderTypeController');
    Route::resource('order', 'OrderController');

    Route::get('users/{user?}', 'UserController@show')->name('users.show');
    Route::put('users/change/password/{user}', 'UserController@changePassword')->name('users.change.password');
    route::get('add_card_api', [ApiCardController::class, 'addCardApi']); // add items from api cards to database
    Route::get('get_cards', [ApiCardController::class, 'dataTable'])->name('card_api.datatable');
    Route::get('show_cards', [ApiCardController::class, 'showCards'])->name('card_api.show');
    Route::get('delete_cards/{id}', [ApiCardController::class, 'deleteCards']);
    Route::get('edit_cards/{id}', [ApiCardController::class, 'editCards']);
    Route::put('update_card', [ApiCardController::class, 'updateCard'])->name('card.update');
    route::get("refresh_api_card", [ApiCardController::class, 'refreshApiCard'])->name("refresh_api_card");
});


Route::get('/home', 'HomeController@index')->name('home');