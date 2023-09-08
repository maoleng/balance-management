<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\FinancialManagementController;
use App\Http\Controllers\InvestController;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\TransactionController;
use App\Http\Middleware\AuthenticateMiddleware;
use App\Http\Middleware\IfAlreadyLogin;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'auth', 'middleware' => [IfAlreadyLogin::class]], static function() {
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::get('/redirect', [AuthController::class, 'redirect'])->name('redirect');
    Route::get('/callback', [AuthController::class, 'callback'])->name('callback');
});

Route::group(['middleware' => [AuthenticateMiddleware::class]], function () {
    Route::get('/', [SiteController::class, 'index'])->name('index');

    Route::get('/market', [SiteController::class, 'market'])->name('market.index');

    Route::group(['prefix' => 'invest', 'as' => 'invest.'], static function () {
        Route::get('/', [InvestController::class, 'index'])->name('index');
        Route::put('/{notify_coin}', [InvestController::class, 'update'])->name('update');
    });

    Route::group(['prefix' => 'transaction', 'as' => 'transaction.'], function () {
        Route::get('/', [TransactionController::class, 'index'])->name('index');
        Route::post('/', [TransactionController::class, 'store'])->name('store');
        Route::delete('/{transaction}', [TransactionController::class, 'destroy'])->name('destroy');
    });

    Route::group(['prefix' => 'financial-management', 'as' => 'financial-management.'], function () {
        Route::get('/', [FinancialManagementController::class, 'index'])->name('index');
        Route::post('/', [FinancialManagementController::class, 'store'])->name('store');
        Route::put('/{category}', [FinancialManagementController::class, 'update'])->name('update');
        Route::delete('/{category}', [FinancialManagementController::class, 'destroy'])->name('destroy');
    });

});
