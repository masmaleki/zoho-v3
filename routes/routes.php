<?php

use Illuminate\Support\Facades\Route;
use AliMehraei\ZohoAllInOne\Http\Controllers\Auth\ZohoTokenCheck;


Route::group([
    'middleware' => ['web']
], function () {
    Route::any('zoho_oauth2callback/', [ZohoTokenCheck::class, 'saveTokens'])->name('zoho.save.tokens');

});

Route::group([
    'middleware' => config('zoho-v3.middleware', ['web']),
    'domain' => config('zoho-v3.domain', null),
    'prefix' => config('zoho-v3.prefix'),
], function () {
    Route::prefix('zoho')->group(function () {
        Route::get('/application/register', [ZohoTokenCheck::class, 'applicationRegister'])->name('zoho.application.register');
    });
});
