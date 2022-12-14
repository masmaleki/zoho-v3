<?php

namespace Masmaleki\ZohoAllInOne\Http\Controllers\Records;

use GuzzleHttp\Client;
use Masmaleki\ZohoAllInOne\Http\Controllers\Auth\ZohoTokenCheck;

class ZohoAvailabilityController
{

    public static function get($availability_id)
    {
        $token = ZohoTokenCheck::getToken();
        if (!$token) {
            return null;
        }
        $apiURL = $token->api_domain . '/crm/v3/Availability/' . $availability_id;
        $client = new Client();

        $headers = [
            'Authorization' => 'Zoho-oauthtoken ' . $token->access_token,
        ];

        $response = $client->request('GET', $apiURL, ['headers' => $headers]);
        $statusCode = $response->getStatusCode();
        $responseBody = json_decode($response->getBody(), true);
        return $responseBody;
    }

    public static function getProductAvailabilities($product_id, $fields = null, $condition)
    {
        $token = ZohoTokenCheck::getToken();
        if (!$token) {
            return null;
        }

        $apiURL = $token->api_domain . '/crm/v3/coql';
        $client = new Client();

        $headers = [
            'Authorization' => 'Zoho-oauthtoken ' . $token->access_token,
        ];

        if (!$fields) {
            $fields = 'Name,Product_name,id,Owner,Currency,Created_Time,Valid,Price,Availability_Type,Lead_Time,Availability_Source,Rating,SKU_name,Availability_Stage,Quantity';
        }

        if (!$condition) {
            $condition = "Product_name.id = " . $product_id . " ";
        }

        $body = [
            'select_query' => "select " . $fields . " from Availability where " . $condition . " order by Created_Time desc",
        ];

        $response = $client->request('POST', $apiURL, ['headers' => $headers, 'body' => json_encode($body)]);

        $statusCode = $response->getStatusCode();
        $responseBody = json_decode($response->getBody(), true);
        return $responseBody;
    }

    public static function getAll()
    {
        $token = ZohoTokenCheck::getToken();
        if (!$token) {
            return null;
        }
        $apiURL = $token->api_domain . '/crm/v3/Availability?fields=Name,Product_Name,id,Owner,Currency,Created_Time,Valid,Price,Availability_Type,Lead_Time,Availability_Source,Rating,SKU_name,Availability_Stage,Quantity';
        $client = new Client();

        $headers = [
            'Authorization' => 'Zoho-oauthtoken ' . $token->access_token,
        ];

        $response = $client->request('GET', $apiURL, ['headers' => $headers]);
        $statusCode = $response->getStatusCode();
        $responseBody = json_decode($response->getBody(), true);
        return $responseBody;
    }

    public static function search($phrase, $criteria = '')
    {
        $token = ZohoTokenCheck::getToken();
        if (!$token) {
            return null;
        }
        $apiURL = $token->api_domain . '/crm/v3/Availability/search?word=' . $phrase . $criteria;
        $client = new Client();

        $headers = [
            'Authorization' => 'Zoho-oauthtoken ' . $token->access_token,
        ];

        $response = $client->request('GET', $apiURL, ['headers' => $headers]);
        $statusCode = $response->getStatusCode();
        $responseBody = json_decode($response->getBody(), true);
        return $responseBody;
    }

    public static function create($data = null)
    {
//        if (!$data) {
//            return null;
//        }
//        $token = ZohoTokenCheck::getToken();
//        if (!$token) {
//            return null;
//        }
//        $apiURL = $token->api_domain . '/crm/v3/Availability' ;
//        $client = new Client();
//
//        $headers = [
//            'Authorization' => 'Zoho-oauthtoken ' . $token->access_token,
//        ];
//
//        $body = [
//            'data' => [
//                0 => $data
//            ]
//        ];
//        $response = $client->request('POST', $apiURL, ['headers' => $headers, 'body' => json_encode($body)]);
//        $statusCode = $response->getStatusCode();
//        $responseBody = json_decode($response->getBody(), true);
//        return $responseBody;
    }

    public static function update($data = [])
    {
        $zoho_availability_id = $data['id'];

        $token = ZohoTokenCheck::getToken();
        if (!$token) {
            return null;
        }
        $apiURL = $token->api_domain . '/crm/v3/Availability/' . $zoho_availability_id . '';
        $client = new Client();

        $headers = [
            'Authorization' => 'Zoho-oauthtoken ' . $token->access_token,
        ];

        if (!isset($data['id'])) {
            $data['id'] = $zoho_availability_id;
        }

        $body = [
            'data' => [
                0 => $data
            ]
        ];
        //dd(json_encode($body));
        $response = $client->request('PUT', $apiURL, ['headers' => $headers, 'body' => json_encode($body)]);
        $statusCode = $response->getStatusCode();
        $responseBody = json_decode($response->getBody(), true);
        return $responseBody;
    }

}
