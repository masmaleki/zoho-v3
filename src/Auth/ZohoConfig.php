<?php

namespace Masmaleki\ZohoAllInOne\Auth;


use Carbon\Carbon;
use Masmaleki\ZohoAllInOne\ZohoAllInOne;
use Masmaleki\ZohoAllInOne\ZohoToken;

class ZohoConfig
{

    public static function getAuthUrl()
    {

        $client_id = env('ZOHO_CLIENT_ID');
        $secret_key = env('ZOHO_CLIENT_SECRET');
        $z_url = env('ZOHO_ACCOUNTS_URL');
        $z_return_url = env('ZOHO_REDIRECT_URI');
        $z_api_url = env('ZOHO_API_BASE_URL');
        $z_current_user_email = env('ZOHO_CURRENT_USER_EMAIL');

        return $z_url . "/oauth/v2/auth?scope=ZohoCRM.users.ALL,ZohoCRM.settings.ALL,ZohoCRM.modules.ALL,ZohoSearch.securesearch.READ&client_id=" . $client_id . "&response_type=code&access_type=offline&redirect_uri=" . $z_return_url;
    }

}
