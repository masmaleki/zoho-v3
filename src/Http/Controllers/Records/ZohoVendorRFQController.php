<?php

namespace AliMehraei\ZohoAllInOne\Http\Controllers\Records;


use GuzzleHttp\Client;
use AliMehraei\ZohoAllInOne\Http\Controllers\Auth\ZohoTokenCheck;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ZohoVendorRFQController
{


    public static function createV6($data = null)
    {
        if (!$data) {
            return null;
        }
        $token = ZohoTokenCheck::getToken();
        if (!$token) {
            return null;
        }
        $apiURL = $token->api_domain . '/crm/v6/' . config('zoho-v4.custom_modules_names.vendor_rfq');
        $client = new Client();

        $headers = [
            'Authorization' => 'Zoho-oauthtoken ' . $token->access_token,
        ];

        $body = [
            'data' => [
                0 => $data
            ]
        ];
        $response = $client->request('POST', $apiURL, ['headers' => $headers, 'body' => json_encode($body)]);
        $statusCode = $response->getStatusCode();
        $responseBody = json_decode($response->getBody(), true);
        return $responseBody;
    }

    public static function get($vendor_rfq_id)
    {
        $token = ZohoTokenCheck::getToken();
        if (!$token) {
            return null;
        }
        
        $apiURL = $token->api_domain . '/crm/v3/' . config('zoho-v4.custom_modules_names.vendor_rfq') . '/' . $vendor_rfq_id;
        $client = new Client();

        $headers = [
            'Authorization' => 'Zoho-oauthtoken ' . $token->access_token,
        ];

        $response = $client->request('GET', $apiURL, ['headers' => $headers]);
        $statusCode = $response->getStatusCode();
        $responseBody = json_decode($response->getBody(), true);
        return $responseBody;
    }

    public static function getAll($page_token = null, $page = 1, $perPage = 200)
    {
        $token = ZohoTokenCheck::getToken();
        if (!$token) {
            return null;
        }
        $apiURL = $token->api_domain . '/crm/v3/' . config('zoho-v4.custom_modules_names.vendor_rfq') . '?fields=Created_Time,id,Date,Email,Offered_Products,Quantity,Related_RFQs,Requested_Products,Secondary_Email,Status,Vendor_Name,Tag,Name,Vendor_RFQ_Number,Owner';
        if ($page_token) {
            $apiURL .= '&page_token=' . $page_token;
        } else {
            $apiURL .= '&page=' . $page . '&per_page=' . $perPage;
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

    public static function update($data = [])
    {
        $zoho_rfq_id = $data['id'];

        $token = ZohoTokenCheck::getToken();
        if (!$token) {
            return null;
        }
        $apiURL = $token->api_domain . '/crm/v3/' . config('zoho-v4.custom_modules_names.vendor_rfq') . '/' . $zoho_rfq_id . '';
        $client = new Client();

        $headers = [
            'Authorization' => 'Zoho-oauthtoken ' . $token->access_token,
        ];

        if (!isset($data['id'])) {
            $data['id'] = $zoho_rfq_id;
        }

        $body = [
            'data' => [
                0 => $data
            ]
        ];

        $response = $client->request('PUT', $apiURL, ['headers' => $headers, 'body' => json_encode($body)]);
        $statusCode = $response->getStatusCode();
        $responseBody = json_decode($response->getBody(), true);
        return $responseBody;
    }
}
