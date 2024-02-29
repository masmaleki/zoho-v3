<?php

namespace AliMehraei\ZohoAllInOne\Http\Controllers\Records;

use GuzzleHttp\Client;
use AliMehraei\ZohoAllInOne\Http\Controllers\Auth\ZohoTokenCheck;

class ZohoRecordCountController
{

    public static function count($moduleName = null, $type = null, $value = null)
    {

        //TODO: check module name validity
        //TODO: check type validity


        //GET /{module_api_name}/actions/count?criteria=(criterion_here)
        //GET /{module_api_name}/actions/count?email=(email_here)
        //GET /{module_api_name}/actions/count?phone=(phone_number_here)
        //GET /{module_api_name}/actions/count?word=(search_word_here)

        $responseBody['count'] = 0;
        if (!$moduleName || ($type != null && $value == null)) {
            return $responseBody;
        }


        $token = ZohoTokenCheck::getToken();
        if (!$token) {
            return null;
        }

        switch ($type) {
            case 'criteria':
                $apiURL = $token->api_domain . '/crm/v3/' . $moduleName . '/actions/count?criteria=(' . $value . ')';
                break;
            case 'email':
                $apiURL = $token->api_domain . '/crm/v3/' . $moduleName . '/actions/count?email=' . $value;
                break;
            case 'phone':
                $apiURL = $token->api_domain . '/crm/v3/' . $moduleName . '/actions/count?phone=' . $value;
                break;
            case 'word':
                $apiURL = $token->api_domain . '/crm/v3/' . $moduleName . '/actions/count?word=' . $value;
                break;
            default:
                $apiURL = $token->api_domain . '/crm/v3/' . $moduleName . '/actions/count';

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

    public static function countCOQL($moduleName, $condition = null)
    {
        $result = 0;
        $offset = 0;
        $morePage = true;
        do {
            $a = self::processCountCOQL($moduleName, $condition, $offset);
            if (($a['info']['more_records'] ?? false) == true) {
                $offset += 200;
            } else {
                $morePage = false;
            }
            $result += $a['info']['count'] ?? 0;
        } while ($morePage);
        return $result;
    }

    protected static function processCountCOQL($moduleName, $condition = null, $offset = 0)
    {
        $token = ZohoTokenCheck::getToken();
        if (!$token) {
            return null;
        }

        if (!$condition) {
            $condition = 'id != null';
        }
        $apiURL = $token->api_domain . '/crm/v3/coql';

        $client = new Client();

        $headers = [
            'Authorization' => 'Zoho-oauthtoken ' . $token->access_token,
        ];

        $body = [
            'select_query' => "Select id from " . $moduleName . "  WHERE " . $condition . " limit " . $offset . " , 200 ",
        ];

        $response = $client->request('POST', $apiURL, ['headers' => $headers, 'body' => json_encode($body)]);

        $statusCode = $response->getStatusCode();
        $responseBody = json_decode($response->getBody(), true);
        return $responseBody;
    }

    public static function countZBCOQL($moduleName = null, $organization_id, $condition = null)
    {

        $responseBody['count'] = 0;
        if (!$moduleName) {
            return $responseBody;
        }

        $token = ZohoTokenCheck::getToken();
        if (!$token) {
            return null;
        }

        $apiURL = config('zoho-v3.books_api_base_url') . '/books/v3/' . $moduleName . '?page=1&per_page=2&response_option=2&organization_id=' . $organization_id;

        if ($condition) {
            $apiURL .= $condition;
        }

        $client = new Client();

        $headers = [
            'Authorization' => 'Zoho-oauthtoken ' . $token->access_token,
        ];

        $response = $client->request('GET', $apiURL, ['headers' => $headers]);
        $statusCode = $response->getStatusCode();
        $responseBody = json_decode($response->getBody(), true);
        $responseBody['count'] = $responseBody['page_context']['total'] ?? 0;
        return $responseBody;

    }

}
