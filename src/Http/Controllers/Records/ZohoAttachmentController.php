<?php

namespace Masmaleki\ZohoAllInOne\Http\Controllers\Records;

use GuzzleHttp\Client;
use Masmaleki\ZohoAllInOne\Http\Controllers\Auth\ZohoTokenCheck;

class ZohoAttachmentController
{
    public static function getAll($zoho_module_name, $zoho_record_id)
    {
        $token = ZohoTokenCheck::getToken();
        if (!$token) {
            return null;
        }
        $apiURL = $token->api_domain . '/crm/v3/' . $zoho_module_name . '/' . $zoho_record_id . '/Attachments?fields=id,File_Name';
        $client = new Client();

        $headers = [
            'Authorization' => 'Zoho-oauthtoken ' . $token->access_token,
        ];

        $response = $client->request('GET', $apiURL, ['headers' => $headers]);
        $statusCode = $response->getStatusCode();
        $responseBody = json_decode($response->getBody(), true);
        return $responseBody;
    }

    public static function upload($zoho_module_name, $zoho_record_id, $file_content, $file_mime, $file_upload_name)
    {
        $token = ZohoTokenCheck::getToken();
        if (!$token) {
            return null;
        }
        $apiURL = $token->api_domain . '/crm/v3/' . $zoho_module_name . '/' . $zoho_record_id . '/Attachments';
        $client = new Client();

        $params = [
            'headers' => [
                'Authorization' => 'Zoho-oauthtoken ' . $token->access_token,
            ],
            'multipart' => [
                [
                    'name' => 'file',
                    'filename' => $file_upload_name,
                    'Mime-Type' => $file_mime,
                    'contents' => $file_content,
                ],
            ],
        ];

        $response = $client->request('POST', $apiURL, $params);
        $statusCode = $response->getStatusCode();
        $responseBody = json_decode($response->getBody(), true);
        return $responseBody;
    }

    public static function delete($zoho_module_name, $zoho_record_id, $zoho_attachment_id)
    {
        $token = ZohoTokenCheck::getToken();
        if (!$token) {
            return null;
        }
        $apiURL = $token->api_domain . '/crm/v3/' . $zoho_module_name . '/' . $zoho_record_id . '/Attachments/' . $zoho_attachment_id;
        $client = new Client();

        $headers = [
            'Authorization' => 'Zoho-oauthtoken ' . $token->access_token,
        ];

        $response = $client->request('DELETE', $apiURL, ['headers' => $headers]);
        $statusCode = $response->getStatusCode();
        $responseBody = json_decode($response->getBody(), true);
        return $responseBody;
    }
}
