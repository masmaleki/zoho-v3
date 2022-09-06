<?php

namespace Masmaleki\ZohoAllInOne\Auth;


use Carbon\Carbon;
use Masmaleki\ZohoAllInOne\ZohoToken;

class ZohoTokenCheck
{

    public static function getToken($redirect = false)
    {
        $zoho_token = ZohoToken::query()->latest()->first();
        if ($zoho_token) {
            $expiry_time = Carbon::parse($zoho_token->expiry_time);
            if ($expiry_time->lt(Carbon::now())) {
                $zoho = new ZohoCustomTokenStore();
                $zoho_token = $zoho->refreshToken($zoho_token->id);
            }
            return $zoho_token;
        } elseif ($redirect) {
            $auth_url = ZohoConfig::getAuthUrl();
            return redirect($auth_url);
        }
        return null;

    }

}
