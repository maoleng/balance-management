<?php

use App\Http\Controllers\AuthController;
use App\Http\Middleware\AuthenticateMiddleware;
use App\Http\Middleware\IfAlreadyLogin;
use App\Livewire\BillComponent;
use App\Livewire\ClassifyComponent;
use App\Livewire\MeComponent;
use App\Livewire\SiteComponent;
use App\Livewire\StatisticComponent;
use App\Livewire\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'auth', 'middleware' => [IfAlreadyLogin::class]], static function() {
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::get('/redirect', [AuthController::class, 'redirect'])->name('redirect');
    Route::get('/callback', [AuthController::class, 'callback'])->name('callback');
});

Route::group(['middleware' => [AuthenticateMiddleware::class]], function () {
    Route::get('/', SiteComponent::class)->name('index');
    Route::get('/me', MeComponent::class)->name('me');
    Route::get('/market', [SiteComponent::class, 'market'])->name('market');

    Route::group(['prefix' => 'bill', 'as' => 'bill.'], function () {
        Route::get('/', BillComponent::class)->name('index');
    });

    Route::group(['prefix' => 'transaction', 'as' => 'transaction.'], function () {
        Route::get('/', Transaction\IndexComponent::class)->name('index');
        Route::get('/cash/{transaction?}', Transaction\CashComponent::class)->name('cash');
        Route::get('/onus/{transaction?}', Transaction\ONUSComponent::class)->name('onus');
        Route::get('/crypto/{transaction?}', Transaction\CryptoComponent::class)->name('crypto');
    });

    Route::group(['prefix' => 'classify', 'as' => 'classify.'], function () {
        Route::get('/', ClassifyComponent::class)->name('index');
        Route::post('/store-image', [ClassifyComponent::class, 'storeImage'])->name('image.store');
        Route::post('/store-category', [ClassifyComponent::class, 'storeCategory'])->name('category.store');
        Route::delete('/destroy-category', [ClassifyComponent::class, 'destroyCategory'])->name('category.destroy');
        Route::delete('/destroy-reason', [ClassifyComponent::class, 'destroyReason'])->name('reason.destroy');
        Route::post('/store-reason', [ClassifyComponent::class, 'storeReason'])->name('reason.store');
    });

    Route::group(['prefix' => 'statistic', 'as' => 'statistic.'], function () {
        Route::get('/', StatisticComponent::class)->name('index');
        Route::get('/fetch', [StatisticComponent::class, 'fetch'])->name('fetch');
    });

    Route::post('/subscription', function (Request $request) {
        $s = $request->get('subscription');
        Auth::user()->updatePushSubscription($s['endpoint'], $s['keys']['p256dh'], $s['keys']['auth']);
    })->name('subscription');
});
