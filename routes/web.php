<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CashTransactionController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CryptoTransactionController;
use App\Http\Controllers\ONUSTransactionController;
use App\Http\Controllers\ReasonController;
use App\Http\Controllers\StatisticController;
use App\Http\Middleware\AuthenticateMiddleware;
use App\Http\Middleware\IfAlreadyLogin;
use App\Livewire\SiteComponent;
use App\Livewire\Transaction;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'auth', 'middleware' => [IfAlreadyLogin::class]], static function() {
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::get('/redirect', [AuthController::class, 'redirect'])->name('redirect');
    Route::get('/callback', [AuthController::class, 'callback'])->name('callback');
});

Route::group(['middleware' => [AuthenticateMiddleware::class]], function () {
    Route::get('/', SiteComponent::class)->name('index');
    Route::get('/market', [SiteComponent::class, 'market'])->name('market');

    Route::group(['prefix' => 'transaction', 'as' => 'transaction.'], function () {
        Route::get('/', Transaction\IndexComponent::class)->name('index');
        Route::get('/cash', Transaction\CashComponent::class)->name('cash');
        Route::get('/onus', Transaction\ONUSComponent::class)->name('onus');
//        Route::resource('cash', CashTransactionController::class)->only(['index', 'store']);
        Route::delete('cash/{transaction}', [CashTransactionController::class, 'destroy'])->name('cash.destroy');
        Route::put('cash/group-transaction', [CashTransactionController::class, 'updateGroupTransaction'])->name('cash.update-group-transaction');

//        Route::resource('onus', ONUSTransactionController::class)->only(['index', 'store']);
        Route::delete('onus/{transaction}', [ONUSTransactionController::class, 'destroy'])->name('onus.destroy');

        Route::resource('crypto', CryptoTransactionController::class)->only(['index', 'store']);
        Route::delete('crypto/{transaction}', [CryptoTransactionController::class, 'destroy'])->name('crypto.destroy');
    });

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
