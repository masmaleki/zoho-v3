<?php

use Illuminate\Support\Facades\Route;
use Masmaleki\ZohoAllInOne\Http\Controllers\Auth\ZohoTokenCheck;


Route::group(['middleware' => config('zoho-v3.middleware')], function () {
    Route::any('zoho_oauth2callback/', [ZohoTokenCheck::class, 'saveTokens'])->name('zoho.save.tokens');

});

Route::group(['middleware' => config('zoho-v3.middleware'), 'prefix' => config('zoho-v3.prefix'),], function () {
    Route::prefix('zoho')->group(function () {
        Route::get('/refresh/token', [ZohoTokenCheck::class, 'refreshToken'])->name('zoho.refresh.token');
    });
});
