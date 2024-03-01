<?php

namespace AliMehraei\ZohoAllInOne\Http\Controllers\Users;

use GuzzleHttp\Client;
use AliMehraei\ZohoAllInOne\Http\Controllers\Auth\ZohoTokenCheck;

class ZohoUserController
{

    public static function getAll($page_token = null)
    {
        $token = ZohoTokenCheck::getToken();
        if (!$token) {
            return null;
        }
        $apiURL = $token->api_domain . '/crm/v3/users';
        //TODO: paginations
        if ($page_token) {
           // $apiURL .= '&page_token=' . $page_token;
        }
        $client = new Client();
        $postInput = [
            'page' => 1,
            'type' => 'AllUsers'
        ];
        $headers = [
            'Authorization' => 'Zoho-oauthtoken ' . $token->access_token,
        ];

        $response = $client->request('GET', $apiURL, ['form_params' => $postInput, 'headers' => $headers]);
        $statusCode = $response->getStatusCode();
        $responseBody = json_decode($response->getBody(), true);
        return $responseBody;

    }


}
