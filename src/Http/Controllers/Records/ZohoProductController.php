<?php

namespace Masmaleki\ZohoAllInOne\Http\Controllers\Records;


use GuzzleHttp\Client;
use Masmaleki\ZohoAllInOne\Http\Controllers\Auth\ZohoTokenCheck;

class ZohoProductController
{
    public static function getAll($page_token = null)
    {
        $token = ZohoTokenCheck::getToken();
        if (!$token) {
            return null;
        }
        $apiURL = $token->api_domain . '/crm/v3/Products?fields=Product_Name,Lifecylce_Status';
//        $apiURL = $token->api_domain . '/crm/v3/Products';
        if ($page_token) {
            $apiURL .= '&page_token=' . $page_token;
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

    public static function getById($zoho_product_id)
    {

        $token = ZohoTokenCheck::getToken();
        if (!$token) {
            return null;
        }
        $apiURL = $token->api_domain . '/crm/v3/Products/search?criteria=(id:equals:' . $zoho_product_id . ')';
        $client = new Client();

        $headers = [
            'Authorization' => 'Zoho-oauthtoken ' . $token->access_token,
        ];

        $response = $client->request('GET', $apiURL, ['headers' => $headers]);
        $statusCode = $response->getStatusCode();
        $responseBody = json_decode($response->getBody(), true);
        return $responseBody;
    }

    public static function search($phrase)
    {
        $token = ZohoTokenCheck::getToken();
        //dd($token);
        if (!$token) {
            return null;
        }
        $apiURL = $token->api_domain . '/crm/v3/Products/search?word=' . $phrase;//. '&fields=Product_Name,Part_Description';
        //dump($apiURL);
        //$apiURL = $token->api_domain . '/crm/v3/Products/search?criteria=((Product_Name:starts_with:' . $phrase . ')or(Part_Description:starts_with:' . $phrase . '))';
        $client = new Client();

        $headers = [
            'Authorization' => 'Zoho-oauthtoken ' . $token->access_token,
        ];

        $response = $client->request('GET', $apiURL, ['headers' => $headers]);
        //dump($response);
        $statusCode = $response->getStatusCode();
        $responseBody = json_decode($response->getBody(), true);
        return $responseBody;
    }

}
