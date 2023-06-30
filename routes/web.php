<?php

use App\Http\Controllers\InvestController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'invest'], static function () {
    Route::get('/', [InvestController::class, 'index']);
});

Route::group(['prefix' => 'transaction', 'as' => 'transaction.'], function () {
    Route::get('/', [TransactionController::class, 'index']);
    Route::post('/', [TransactionController::class, 'store'])->name('store');
    Route::delete('/{transaction}', [TransactionController::class, 'destroy'])->name('destroy');
});

Route::get('/', function () {
    return view('index');
});
