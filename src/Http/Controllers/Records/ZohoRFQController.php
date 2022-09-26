<?php

namespace Masmaleki\ZohoAllInOne\Http\Controllers\Records;

use GuzzleHttp\Client;
use Masmaleki\ZohoAllInOne\Http\Controllers\Auth\ZohoTokenCheck;

class ZohoRFQController
{

    public static function get($rfq_id)
    {
        $token = ZohoTokenCheck::getToken();
        if (!$token) {
            return null;
        }
        $apiURL = $token->api_domain . '/crm/v3/' . config('zoho-v3.custom_modules_names.rfq') . '/' . $rfq_id;
        $client = new Client();

        $headers = [
            'Authorization' => 'Zoho-oauthtoken ' . $token->access_token,
        ];

        $response = $client->request('GET', $apiURL, ['headers' => $headers]);
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
        $apiURL = $token->api_domain . '/crm/v3/' . config('zoho-v3.custom_modules_names.rfq') . '?fields=Name,Product_Name,id,RFQ_Date,Quantity,Status';
        $client = new Client();

        $headers = [
            'Authorization' => 'Zoho-oauthtoken ' . $token->access_token,
        ];

        $response = $client->request('GET', $apiURL, ['headers' => $headers]);
        $statusCode = $response->getStatusCode();
        $responseBody = json_decode($response->getBody(), true);
        return $responseBody;
    }

    public static function getAccountRFQs($zoho_crm_account_id,  /*$conditions = null,*/ $page_token = null)
    {
        $token = ZohoTokenCheck::getToken();
        if (!$token) {
            return null;
        }

//        $conditions='Account_Name.id:equals:';
//        $conditionString = '(Account_Name.id:equals:' . $zoho_crm_account_id . ')';
//        if ($conditions ) {
//            $conditionString = '((Account_Name.id:equals:' . $zoho_crm_account_id . ')and(' . $conditions . ')';
//        }
//
//        $apiURL = $token->api_domain . '/crm/v3/' . config('zoho-v3.custom_modules_names.rfq') . '/search?criteria=' . $conditionString;

        $apiURL = $token->api_domain . '/crm/v3/' . config('zoho-v3.custom_modules_names.rfq') . '/search?criteria=(Account_Name.id:equals:' . $zoho_crm_account_id . ')';
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

    public static function getAccountRFQsCOQL($zoho_crm_account_id, $more_records = false)
    {
        $token = ZohoTokenCheck::getToken();
        if (!$token) {
            return null;
        }

        $apiURL = $token->api_domain . '/crm/v3/coql';
        if ($more_records) {
            //$apiURL .= '&page_token=' . $page_token;
        }
        $client = new Client();

        $headers = [
            'Authorization' => 'Zoho-oauthtoken ' . $token->access_token,
        ];

        $body = [
            'select_query' => "select Name, Customer_RFQ_No, RFQ_Date, id, Status, RFQ_Dead_Line, Product_Name, Account_Name, Quantity, RFQ_Status, Contact ,RFQ_Source from " . config('zoho-v3.custom_modules_names.rfq') . "  where Account_Name.id = " . $zoho_crm_account_id . "  limit 200",
        ];

        $response = $client->request('POST', $apiURL, ['headers' => $headers, 'body' => json_encode($body)]);

        $statusCode = $response->getStatusCode();
        $responseBody = json_decode($response->getBody(), true);
        return $responseBody;
    }

    
    public static function search($phrase, $criteria = null)
    {
        $token = ZohoTokenCheck::getToken();
        if (!$token) {
            return null;
        }
        $apiURL = $token->api_domain . '/crm/v3/' . config('zoho-v3.custom_modules_names.rfq') . '/search?word=' . $phrase . $criteria;
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
