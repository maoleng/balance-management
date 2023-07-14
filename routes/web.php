<?php

use App\Http\Controllers\InvestController;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;

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


