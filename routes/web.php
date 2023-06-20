<?php

use App\Http\Controllers\InvestController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'invest'], static function () {
    Route::get('/', [InvestController::class, 'index']);
});

Route::get('/', function () {
    return view('index');
});
