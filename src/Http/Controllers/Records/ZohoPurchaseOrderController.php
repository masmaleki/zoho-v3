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
        $apiURL = config('zoho-v3.books_api_base_url') . '/books/v3/purchaseorders?organization_id=' . $organization_id . '&page=' . $page . $condition;

        $client = new Client();

        $headers = [
            'Authorization' => 'Zoho-oauthtoken ' . $token->access_token,
        ];

        $response = $client->request('GET', $apiURL, ['headers' => $headers]);
        $statusCode = $response->getStatusCode();
        $responseBody = json_decode($response->getBody(), true);
        return $responseBody;
    }

    public static function getById($purchase_order_id, $organization_id = null)
    {

        $token = ZohoTokenCheck::getToken();
        if (!$token) {
            return null;
        }
        $apiURL = config('zoho-v3.books_api_base_url') . '/books/v3/purchaseorders/' . $purchase_order_id;
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

    public static function getByCustomerId($zoho_vendor_id, $organization_id)
    {

        $token = ZohoTokenCheck::getToken();
        if (!$token) {
            return null;
        }
        $apiURL = config('zoho-v3.books_api_base_url') . '/books/v3/purchaseorders?organization_id=' . $organization_id . '&vendor_id=' . $zoho_vendor_id . '';
        $client = new Client();

        $headers = [
            'Authorization' => 'Zoho-oauthtoken ' . $token->access_token,
        ];

        $response = $client->request('GET', $apiURL, ['headers' => $headers]);
        $statusCode = $response->getStatusCode();
        $responseBody = json_decode($response->getBody(), true);
        return $responseBody;
    }

    public static function getByItemName($item_name, $organization_id = null)
    {

        $token = ZohoTokenCheck::getToken();
        if (!$token) {
            return null;
        }
        $apiURL = config('zoho-v3.books_api_base_url') . '/books/v3/purchaseorders?page=1&per_page=200&sort_column=created_time&sort_order=D&custom_field_222119000000940129_contains=' . $item_name . '';
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

    public static function searchByCustomerId($zoho_vendor_id, $searchParameter, $organization_id)
    {

        $token = ZohoTokenCheck::getToken();
        if (!$token) {
            return null;
        }
        $apiURL = config('zoho-v3.books_api_base_url') . '/books/v3/purchaseorders?&vendor_id=' . $zoho_vendor_id . '';

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

    public static function getPDF($purchase_order_id)
    {
        $token = ZohoTokenCheck::getToken();
        if (!$token) {
            return null;
        }
        $apiURL = config('zoho-v3.books_api_base_url') . '/books/v3/purchaseorders/' . $purchase_order_id . '?accept=pdf';
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

    public static function getCRMPurchaseOrderById($purchase_order_id, $fields = null)
    {
        $token = ZohoTokenCheck::getToken();
        if (!$token) {
            return null;
        }

        $apiURL = $token->api_domain . '/crm/v3/Purchase_Orders/' . $purchase_order_id ;

        if ($fields) {
            $apiURL .= '?fields=' . $fields;
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
