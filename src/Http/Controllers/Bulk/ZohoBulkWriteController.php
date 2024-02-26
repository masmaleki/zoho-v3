<?php

namespace AliMehraei\ZohoAllInOne\Http\Controllers\Bulk;

use GuzzleHttp\Client;
use AliMehraei\ZohoAllInOne\Http\Controllers\Auth\ZohoTokenCheck;

class ZohoBulkWriteController
{

    public static function uploadFile($organization_id, $filePath)
    {
        $token = ZohoTokenCheck::getToken();
        if (!$token) {
            return null;
        }
        $apiURL = 'https://content.zohoapis.eu/crm/v3/upload';
        $client = new Client();
        
        $params = [
            'headers' => [
                'Authorization' => 'Zoho-oauthtoken ' . $token->access_token,
                'feature' => "bulk-write",
                'X-CRM-ORG' => $organization_id,
            ],
            'multipart' => [
                [
                    'name' => 'file',
                    // 'Mime-Type' => mime_content_type($filePath),
                    'contents' => fopen($filePath, 'r'),
                ],
            ],
        ];

        $response = $client->request('POST', $apiURL, ['headers' => $params['headers'], 'multipart' => $params['multipart']]);
        $statusCode = $response->getStatusCode();
        $responseBody = json_decode($response->getBody(), true);
        return $responseBody;
    }

    public static function createJob($module, $mapping, $file_id, $callback_url)
    {
        $token = ZohoTokenCheck::getToken();
        if (!$token) {
            return null;
        }
        $apiURL = $token->api_domain . '/crm/bulk/v3/write';
        $client = new Client();

        $params = [
            'headers' => [
                'Authorization' => 'Zoho-oauthtoken ' . $token->access_token,
                'Content-Type' => 'application/json'
            ],
            'form_params' => [
                'operation' => 'insert',
                'ignore_empty' => true,
                'callback' => [
                    'url' => $callback_url,
                    'method' => 'post',
                ],
                'resource' => [
                    [
                        'type' => 'data',
                        'module' =>
                        [
                            'api_name' => $module,
                        ],
                        'file_id' => $file_id,
                        'field_mappings' => $mapping
                    ],
                ],
            ],
        ];

        // dd($params);

        // $response = $client->request('POST', $apiURL, ['headers' => $params['headers'], 'body' => json_encode($params['form_params'])]);
        $response = $client->request('POST', $apiURL, ['headers' => $params['headers'], 'body' => json_encode($params['form_params'])]);
        $statusCode = $response->getStatusCode();
        $responseBody = json_decode($response->getBody(), true);
        return $responseBody;
    }
}
