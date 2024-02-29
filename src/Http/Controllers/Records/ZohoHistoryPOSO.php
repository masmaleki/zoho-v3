<?php

namespace AliMehraei\ZohoAllInOne\Http\Controllers\Records;

use GuzzleHttp\Client;
use AliMehraei\ZohoAllInOne\Http\Controllers\Auth\ZohoTokenCheck;

class ZohoHistoryPOSO
{

    public static function getAll($fields = null, $page_token = null, $conditions = null)
    {
        $token = ZohoTokenCheck::getToken();
        if (!$token) {
            return null;
        
        }
        $apiURL = $token->api_domain . '/crm/v3/' . config('zoho-v3.custom_modules_names.history_po_so') . '?';

        if ($page_token) {
            $apiURL .= '&page_token=' . $page_token;
        }

        if ($fields) {
            $apiURL .= '&fields=' . $fields;
        }
        
        if ($conditions) {
            $apiURL .= '&fields=' . $fields;
        }

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
