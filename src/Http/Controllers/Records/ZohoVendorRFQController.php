<?php

namespace Masmaleki\ZohoAllInOne\Http\Controllers\Records;


use GuzzleHttp\Client;
use Masmaleki\ZohoAllInOne\Http\Controllers\Auth\ZohoTokenCheck;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ZohoVendorRFQController
{
    public static function get($vendor_rfq_id)
    {
        $token = ZohoTokenCheck::getToken();
        if (!$token) {
            return null;
        }
        
        $apiURL = $token->api_domain . '/crm/v3/' . config('zoho-v3.custom_modules_names.vendor_rfq') . '/' . $vendor_rfq_id;
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
