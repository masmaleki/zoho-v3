<?php

namespace AliMehraei\ZohoAllInOne\Http\Controllers\Auth;


use Carbon\Carbon;
use AliMehraei\ZohoAllInOne\ZohoAllInOne;
use AliMehraei\ZohoAllInOne\ZohoToken;

class ZohoConfig
{

    public static function getAuthUrl()
    {

        $client_id = config('zoho-v3.client_id');
        $secret_key = config('zoho-v3.client_secret');
        $z_url = config('zoho-v3.accounts_url');
        $z_return_url = config('zoho-v3.redirect_uri');
        $z_api_url = config('zoho-v3.api_base_url');
        $z_current_user_email = config('zoho-v3.current_user_email');
        $z_oauth_scope = config('zoho-v3.oauth_scope');

        return "$z_url/oauth/v2/auth?scope=$z_oauth_scope&client_id=$client_id&response_type=code&access_type=offline&redirect_uri=$z_return_url";

    }

}
