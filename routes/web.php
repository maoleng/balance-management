<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\FinancialManagementController;
use App\Http\Controllers\InvestController;
use App\Http\Controllers\ReasonController;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\StatisticController;
use App\Http\Controllers\TransactionController;
use App\Http\Middleware\AuthenticateMiddleware;
use App\Http\Middleware\IfAlreadyLogin;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;

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

    Route::resource('transaction', TransactionController::class)->only(['index', 'store', 'destroy']);
    Route::put('transaction/group-transaction', [TransactionController::class, 'updateGroupTransaction'])->name('transaction.update-group-transaction');

    Route::group(['prefix' => 'financial-management', 'as' => 'financial-management.'], function () {
        Route::resource('category', CategoryController::class)->only(['index', 'store', 'update', 'destroy']);
        Route::resource('reason', ReasonController::class)->only(['index', 'store', 'update', 'destroy']);
    });

    Route::group(['prefix' => 'statistic', 'as' => 'statistic.'], function () {
        Route::get('/', [StatisticController::class, 'index'])->name('index');
        Route::get('/expense', [StatisticController::class, 'expense'])->name('expense');
        Route::get('/income', [StatisticController::class, 'income'])->name('income');
    });

});
