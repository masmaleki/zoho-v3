<?php

namespace AliMehraei\ZohoAllInOne\Http\Controllers\Settings;

use GuzzleHttp\Client;
use AliMehraei\ZohoAllInOne\Http\Controllers\Auth\ZohoTokenCheck;

class ZohoCrmOrganizationController
{

    public static function get()
    {
        $token = ZohoTokenCheck::getToken();
        if (!$token) {
            return null;
        }
        $apiURL = $token->api_domain . '/crm/v3/org';
        $client = new Client();

        $headers = [
            'Authorization' => 'Zoho-oauthtoken ' . $token->access_token,
        ];

        $response = $client->request('GET', $apiURL, ['headers' => $headers]);
        $statusCode = $response->getStatusCode();
        $responseBody = json_decode($response->getBody(), true);
        return $responseBody;
    }


}
