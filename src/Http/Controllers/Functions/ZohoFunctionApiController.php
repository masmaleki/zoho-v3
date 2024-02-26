<?php

namespace AliMehraei\ZohoAllInOne\Http\Controllers\Functions;

use GuzzleHttp\Client;
use AliMehraei\ZohoAllInOne\Http\Controllers\Auth\ZohoTokenCheck;

class ZohoFunctionApiController
{

    public static function run($url)
    {
//        $token = ZohoTokenCheck::getToken();
//        if (!$token) {
//            return null;
//        }
        // token is directly passed through url, so its possible to using zoho v2, v1 & ... APIs through this function.
        $apiURL = $url;

        $client = new Client();

        $headers = [
           // 'Authorization' => 'Zoho-oauthtoken ' . $token->access_token,
        ];

        $response = $client->request('POST', $apiURL, ['headers' => $headers]);
        $statusCode = $response->getStatusCode();
        $responseBody = json_decode($response->getBody(), true);
        return $responseBody;
    }


}
