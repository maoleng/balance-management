<?php

use App\Http\Controllers\BalanceController;
use Illuminate\Support\Facades\Route;

Route::get('/get-stock-balance', [BalanceController::class, 'getStockBalance']);
