<?php

namespace Masmaleki\ZohoAllInOne\Http\Controllers\Records;


use GuzzleHttp\Client;
use Masmaleki\ZohoAllInOne\Http\Controllers\Auth\ZohoTokenCheck;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ZohoPurchaseOrderController
{
    public static function getAll($organization_id, $page = 1, $condition = '')
    {

        $token = ZohoTokenCheck::getToken();
        if (!$token) {
            return null;
        }
        $apiURL = config('zoho-v3.books_api_base_url') . '/api/v3/purchaseorders?organization_id=' . $organization_id . '&page=' . $page . $condition;

        $client = new Client();

        $headers = [
            'Authorization' => 'Zoho-oauthtoken ' . $token->access_token,
        ];

        $response = $client->request('GET', $apiURL, ['headers' => $headers]);
        $statusCode = $response->getStatusCode();
        $responseBody = json_decode($response->getBody(), true);
        return $responseBody;
    }

    public static function getById($sale_order_id, $organization_id = null)
    {

        $token = ZohoTokenCheck::getToken();
        if (!$token) {
            return null;
        }
        $apiURL = config('zoho-v3.books_api_base_url') . '/api/v3/purchaseorders/' . $sale_order_id;
        if ($organization_id) {
            $apiURL .= '?organization_id=' . $organization_id;
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

    public static function getByCustomerId($zoho_customer_id, $organization_id)
    {

        $token = ZohoTokenCheck::getToken();
        if (!$token) {
            return null;
        }
        $apiURL = config('zoho-v3.books_api_base_url') . '/api/v3/purchaseorders?organization_id=' . $organization_id . '&customer_id=' . $zoho_customer_id . '';
        $client = new Client();

        $headers = [
            'Authorization' => 'Zoho-oauthtoken ' . $token->access_token,
        ];

        $response = $client->request('GET', $apiURL, ['headers' => $headers]);
        $statusCode = $response->getStatusCode();
        $responseBody = json_decode($response->getBody(), true);
        return $responseBody;
    }

    public static function searchByCustomerId($zoho_vendor_id, $searchParameter, $organization_id)
    {

        $token = ZohoTokenCheck::getToken();
        if (!$token) {
            return null;
        }
        $apiURL = config('zoho-v3.books_api_base_url') . '/api/v3/purchaseorders?&vendor_id=' . $zoho_vendor_id . '';
        
        if ($searchParameter) {
            $apiURL .= '&salesorder_number_contains=' . $searchParameter;
        }
        if ($organization_id) {
            $apiURL .= '&organization_id=' . $organization_id;
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

    public static function getPDF($sale_order_id)
    {
        $token = ZohoTokenCheck::getToken();
        if (!$token) {
            return null;
        }
        $apiURL = config('zoho-v3.books_api_base_url') . '/api/v3/purchaseorders/' . $sale_order_id . '?accept=pdf';
        $client = new Client();

        $headers = [
            'Authorization' => 'Zoho-oauthtoken ' . $token->access_token,
        ];

        $response = $client->request('GET', $apiURL, ['headers' => $headers, 'stream' => false]);
        $responseBody = $response->getBody();

        $streamResponse = new StreamedResponse(function () use ($responseBody) {
            while (!$responseBody->eof()) {
                echo $responseBody->read(1024);
            }
        });

        $streamResponse->headers->set('Content-Type', 'application/pdf');
        $streamResponse->headers->set('Cache-Control', 'no-cache');

        return $streamResponse;
    }

}
