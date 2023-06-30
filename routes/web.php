<?php

use App\Http\Controllers\InvestController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'invest'], static function () {
    Route::get('/', [InvestController::class, 'index']);
});

Route::group(['prefix' => 'transaction'], function () {
    Route::get('/', [TransactionController::class, 'index']);
});

Route::get('/', function () {
    return view('index');
});
