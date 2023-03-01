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

    public static function getAccountRFQs($zoho_crm_account_id, $page_token = null, $fields = null, $next_page, $per_page, $conditions = null)
    {
        $token = ZohoTokenCheck::getToken();
        if (!$token) {
            return null;
        }

        if (is_array($zoho_crm_account_id)) {
            if ($zoho_crm_account_id[1] ?? false) {
                $conditionString = '((Account_Name.id:equals:' . $zoho_crm_account_id[0] . ')or(Account_Name.id:equals:' . $zoho_crm_account_id[1] . '))';
                if ($conditions) {
                    $conditionString = '(((Account_Name.id:equals:' . $zoho_crm_account_id[0] . ')or(Account_Name.id:equals:' . $zoho_crm_account_id[1] . '))and(' . $conditions . '))';
                }
            } else {
                $conditionString = '(Account_Name.id:equals:' . $zoho_crm_account_id[0] . ')';
                if ($conditions) {
                    $conditionString = '((Account_Name.id:equals:' . $zoho_crm_account_id[0] . ')and(' . $conditions . '))';
                }
            }
        } else {
            $conditionString = '(Account_Name.id:equals:' . $zoho_crm_account_id . ')';
            if ($conditions) {
                $conditionString = '((Account_Name.id:equals:' . $zoho_crm_account_id . ')and(' . $conditions . '))';
            }
        }

        $apiURL = $token->api_domain . '/crm/v3/' . config('zoho-v3.custom_modules_names.rfq') . '/search?criteria=' . $conditionString;
        // $apiURL = $token->api_domain . '/crm/v3/' . config('zoho-v3.custom_modules_names.rfq') . '/search?criteria=(Account_Name.id:equals:' . $zoho_crm_account_id . ')';
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

        //TODO: improve it for results with more than 2000 records.
        try {
            $response = $client->request('GET', $apiURL, ['headers' => $headers]);
            $statusCode = $response->getStatusCode();
            $responseBody = json_decode($response->getBody(), true);
        } catch (\Throwable $th) {
            $responseBody = [];
            $responseBody['data'] = [];
        }
        return $responseBody;
    }

    public static function getAccountRFQsCOQL($zoho_crm_account_id = null, $offset = 0, $conditions = null, $fields = null)
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


        $fields = $fields ? $fields : 'Name, Customer_RFQ_No, RFQ_Date, id, Owner, Status, RFQ_Dead_Line, Product_Name, Product_Name.Product_Name,  Account_Name, Quantity, RFQ_Status, Contact ,RFQ_Source';
        $body = [
            'select_query' => "select " . $fields . " from " . config('zoho-v3.custom_modules_names.rfq') . "  where " . $conditions . $zoho_crm_account_id_conditions . "  limit " . $offset . ", 200",
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

    public static function create($data = null)
    {
        if (!$data) {
            return null;
        }
        $token = ZohoTokenCheck::getToken();
        if (!$token) {
            return null;
        }
        $apiURL = $token->api_domain . '/crm/v3/' . config('zoho-v3.custom_modules_names.rfq');
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

    public static function update($data = [])
    {
        $zoho_rfq_id = $data['id'];

        $token = ZohoTokenCheck::getToken();
        if (!$token) {
            return null;
        }
        $apiURL = $token->api_domain . '/crm/v3/' . config('zoho-v3.custom_modules_names.rfq') . '/' . $zoho_rfq_id . '';
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
