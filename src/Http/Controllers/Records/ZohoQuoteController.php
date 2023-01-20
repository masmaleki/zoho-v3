<?php

namespace Masmaleki\ZohoAllInOne\Http\Controllers\Records;

use GuzzleHttp\Client;
use Masmaleki\ZohoAllInOne\Http\Controllers\Auth\ZohoTokenCheck;

class ZohoQuoteController
{

    public static function get($quote_id)
    {
        $token = ZohoTokenCheck::getToken();
        if (!$token) {
            return null;
        }
        $apiURL = $token->api_domain . '/crm/v3/Quotes/' . $quote_id;

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
        $apiURL = $token->api_domain . '/crm/v3/Quotes?fields=Subject,Product_Name,id,Quote_Date,Quantity,Quote_Stage';
        $client = new Client();

        $headers = [
            'Authorization' => 'Zoho-oauthtoken ' . $token->access_token,
        ];

        $response = $client->request('GET', $apiURL, ['headers' => $headers]);
        $statusCode = $response->getStatusCode();
        $responseBody = json_decode($response->getBody(), true);
        return $responseBody;
    }

    public static function getAccountQuotes($zoho_crm_account_id, $page_token = null, $fields = null, $next_page, $per_page, $conditions = null)
    {
        $token = ZohoTokenCheck::getToken();
        if (!$token) {
            return null;
        }

        if (is_array($zoho_crm_account_id)) {
            $conditionString = '((Account_Name.id:equals:' . $zoho_crm_account_id[0] . ')or(Account_Name.id:equals:' . $zoho_crm_account_id[1] . '))';
            if ($conditions ) {
                $conditionString = '(((Account_Name.id:equals:' . $zoho_crm_account_id[0] . ')or(Account_Name.id:equals:' . $zoho_crm_account_id[1] . '))and(' . $conditions . '))';
            }
        } else {
            $conditionString = '(Account_Name.id:equals:' . $zoho_crm_account_id . ')';
            if ($conditions ) {
                $conditionString = '((Account_Name.id:equals:' . $zoho_crm_account_id . ')and(' . $conditions . '))';
            }
        }

        $apiURL = $token->api_domain . '/crm/v3/Quotes/search?criteria=' . $conditionString;

        // $apiURL = $token->api_domain . '/crm/v3/Quotes/search?criteria=(Account_Name.id:equals:' . $zoho_crm_vendor_id . ')';
        if ($page_token) {
            $apiURL .= '&page_token=' . $page_token;
        }
        if ($next_page) {
            $apiURL .= '&page=' . $next_page;
        }
        if ($per_page) {
            $apiURL .= '&per_page=' . $per_page;
        }
        if ($fields) {
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

    public static function getAccountQuotesCOQL($zoho_crm_account_id = null, $offset = 0, $conditions = null, $fields = null)
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

        $conditions = ($conditions) ? $conditions . ' and ' : '';
        $zoho_crm_account_id_conditions = $zoho_crm_account_id != null ? " (Account_Name.id = " . $zoho_crm_account_id . ")" : "(id != 0) ";

        $fields = $fields ? $fields : ' id, Owner, Customer_RFQ_No, Quote_Date,  RFQ, Product_Name, Quote_Number1, Product_Name.Product_Name,  Account_Name, Quantity, Contact_Name ,Quote_Type ';

        $body = [
            'select_query' => "select " . $fields . " from Quotes where " . $conditions . $zoho_crm_account_id_conditions . "  limit " . $offset . ", 200",
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
        $apiURL = $token->api_domain . '/crm/v3/Quotes/search?word=' . $phrase . $criteria;
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
        $zoho_contact_id = $data['id'];

        $token = ZohoTokenCheck::getToken();
        if (!$token) {
            return null;
        }
        $apiURL = $token->api_domain . '/crm/v3/Quotes/' . $zoho_contact_id . '';
        $client = new Client();

        $headers = [
            'Authorization' => 'Zoho-oauthtoken ' . $token->access_token,
        ];

        if (!isset($data['id'])) {
            $data['id'] = $zoho_contact_id;
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
