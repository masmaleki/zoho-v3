<?php

namespace Masmaleki\ZohoAllInOne\Http\Controllers\Bulk;

use GuzzleHttp\Client;
use Masmaleki\ZohoAllInOne\Http\Controllers\Auth\ZohoTokenCheck;

class ZohoBulkWriteController
{

    public static function uploadFile($organization_id, $fileName, $fileMime, $content)
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
                    'filename' => $fileName,
                    'Mime-Type' => $fileMime,
                    'contents' => $content,
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
        $apiURL = $token->api_domain . '/crm/v3/write';
        $client = new Client();

        $params = [
            'headers' => [
                'Authorization' => 'Zoho-oauthtoken ' . $token->access_token,
            ],
            'form_params' => [
                [
                    'operation' => 'insert',
                    'ignore_empty' => true,
                    'callback' =>
                    [
                        'url' => $callback_url,
                        'method' => 'post',
                    ],
                    'resource' =>
                    [
                        0 =>
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
                ]
            ],
        ];

        $response = $client->request('POST', $apiURL, $params);
        $statusCode = $response->getStatusCode();
        $responseBody = json_decode($response->getBody(), true);
        return $responseBody;
    }
}
