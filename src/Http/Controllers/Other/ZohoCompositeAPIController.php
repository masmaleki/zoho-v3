<?php

namespace Masmaleki\ZohoAllInOne\Http\Controllers\Other;

use GuzzleHttp\Client;
use Masmaleki\ZohoAllInOne\Http\Controllers\Auth\ZohoTokenCheck;

class ZohoCompositeAPIController
{

    public static function compositeRequests($requests)
    {
        $token = ZohoTokenCheck::getToken();
        if (!$token) {
            return null;
        }
        $apiURL = $token->api_domain . '/crm/v3/__composite_requests';

        $client = new Client();

        $headers = [
            'Authorization' => 'Zoho-oauthtoken ' . $token->access_token,
        ];

        $body = [
            'rollback_on_fail' => true,
            'concurrent_execution' => false,
            '__composite_requests' => $requests
        ];

        try {
            $response = $client->request('POST', $apiURL, ['headers' => $headers, 'body' => json_encode($body)]);
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            return json_decode($e->getResponse()->getBody()->getContents());
        }
        $statusCode = $response->getStatusCode();
        $responseBody = json_decode($response->getBody(), true);
        return $responseBody;
    }


}
