<?php

use Illuminate\Support\Facades\Route;
use AliMehraei\ZohoAllInOne\Http\Controllers\Auth\ZohoTokenCheck;


Route::group([
    'middleware' => ['web']
], function () {
    Route::any('zoho_oauth2callback/', [ZohoTokenCheck::class, 'saveTokens'])->name('zoho.save.tokens');

});

Route::group([
    'middleware' => config('zoho-v4.middleware', ['web']),
    'domain' => config('zoho-v4.domain', null),
    'prefix' => config('zoho-v4.prefix'),
], function () {
    Route::prefix('zoho')->group(function () {
        Route::get('/application/register', [ZohoTokenCheck::class, 'applicationRegister'])->name('zoho.application.register');
    });
});
