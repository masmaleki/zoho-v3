<?php

namespace Masmaleki\ZohoAllInOne\Http\Controllers\Records;

use GuzzleHttp\Client;
use Masmaleki\ZohoAllInOne\Http\Controllers\Auth\ZohoTokenCheck;

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
                $apiURL = $token->api_domain . '/crm/v3/' . $moduleName . '/actions/count?email=(' . $value . ')';
                break;
            case 'phone':
                $apiURL = $token->api_domain . '/crm/v3/' . $moduleName . '/actions/count?phone=(' . $value . ')';
                break;
            case 'word':
                $apiURL = $token->api_domain . '/crm/v3/' . $moduleName . '/actions/count?word=(' . $value . ')';
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


}
