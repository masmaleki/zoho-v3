<?php

namespace Masmaleki\ZohoAllInOne\Http\Controllers\Bulk;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Storage;
use Masmaleki\ZohoAllInOne\Http\Controllers\Auth\ZohoTokenCheck;

class ZohoBulkReadController
{

    public static function createJob($data)
    {
        $token = ZohoTokenCheck::getToken();
        if (!$token) {
            return null;
        }
        $apiURL = $token->api_domain . '/crm/bulk/v3/read';
        $client = new Client();

        $params = [
            'headers' => [
                'Authorization' => 'Zoho-oauthtoken ' . $token->access_token,
                'Content-Type' => 'application/json'
            ],
            'form_params' => $data,
        ];

        $response = $client->request('POST', $apiURL, ['headers' => $params['headers'], 'body' => json_encode($params['form_params'])]);
        $statusCode = $response->getStatusCode();
        $responseBody = json_decode($response->getBody(), true);
        return $responseBody;
    }

    public static function downloadResult($download_url)
    {
        $token = ZohoTokenCheck::getToken();
        if (!$token) {
            return null;
        }
        $apiURL = $token->api_domain . $download_url;
        $client = new Client();

        $headers = [
            'Authorization' => 'Zoho-oauthtoken ' . $token->access_token,
        ];

        $response = $client->request('GET', $apiURL, ['headers' => $headers]);

        $responseBody = $response->getBody();
        $fileContents = $responseBody->getContents();
        // $base64 = base64_encode($responseBody);

        // if (!$base64) return null;

        // $mime = "image/jpeg";
        // $img = ('data:' . $mime . ';base64,' . $base64);
        return $fileContents;
    }

    public static function saveDuplicatedList($file_name, $data)
    {
        Storage::put($file_name, json_encode($data));
        return true;

    }
}
