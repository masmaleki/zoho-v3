<?php

namespace Masmaleki\ZohoAllInOne\Http\Controllers\Auth;


use Carbon\Carbon;
use Illuminate\Http\Request;
use Masmaleki\ZohoAllInOne\ZohoToken;

class ZohoTokenCheck
{

    public static function getToken()
    {
        $zoho_token = ZohoToken::query()->latest()->first();
        if ($zoho_token) {
            $expiry_time = Carbon::parse($zoho_token->expiry_time);
            if ($expiry_time->lt(Carbon::now())) {
                $zoho = new ZohoCustomTokenStore();
                $zoho_token = $zoho->refreshToken($zoho_token->id);
            }
            return $zoho_token;
        }
        return null;

    }

    public function refreshToken()
    {
        return redirect(ZohoConfig::getAuthUrl());
    }

    public static function saveTokens(Request $request)
    {
        $data = $request->all();


        $client_id = config('zoho-v3.client_id');
        $secret_key = config('zoho-v3.client_secret');
        $z_url = config('zoho-v3.accounts_url');
        $z_return_url = config('zoho-v3.redirect_uri');
        $z_api_url = config('zoho-v3.api_base_url');
        $z_current_user_email = config('zoho-v3.current_user_email');

        $postInput = [
            'grant_type' => 'authorization_code',
            'client_id' => $client_id,
            'client_secret' => $secret_key,
            'redirect_uri' => $z_return_url,
            'code' => $data['code'],
        ];
        $zoho = new ZohoCustomTokenStore();
        if ($request->has('refresh_token')) {
            $token = $zoho->saveToken($postInput, $request->all(), $client_id, $secret_key, $z_return_url);
        } else {
            $resp = $zoho->getToken($data['accounts-server'], $data['location'], $postInput);
            $token = $zoho->saveToken($postInput, $resp, $client_id, $secret_key, $z_return_url);
        }

        return $token;
    }

}
