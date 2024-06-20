<?php

namespace AliMehraei\ZohoAllInOne\Http\Controllers\Records;

use GuzzleHttp\Client;
use AliMehraei\ZohoAllInOne\Http\Controllers\Auth\ZohoTokenCheck;
use Illuminate\Support\Carbon;

class ZohoRecentModuleController
{

    public static function getRecentModuleIdFieldV6($module,$action)
    {
        $token = ZohoTokenCheck::getToken();
        if (!$token) {
            return [
                'data' => [
                    0 => [
                        'code' => 498,
                        'message' => 'Invalid or missing token.',
                        'status' => 'error',
                    ]
                ],
            ];
        }
        $apiURL = $token->api_domain . '/crm/v6/coql';
        $client = new Client();

        $headers = [
            'Authorization' => 'Zoho-oauthtoken ' . $token->access_token,
        ];

        $fields = 'id';



        $todayStart = Carbon::today()->subDays(1)->format("Y-m-d") . "T00:00:01+00:00";
        $todayEnd = Carbon::today()->addDay()->format("Y-m-d") . "T23:59:59+00:00";

        if ($action == 'create') {
            $condition = "sync_with_panel is null and Modified_Time between '{$todayStart}' and '{$todayEnd}'";
        } else {
            $condition = "sync_with_panel is not null and Modified_Time between '{$todayStart}' and '{$todayEnd}'";
        }

        $body = [
            'select_query' => "select " . $fields . " from ".$module." where " . $condition . " order by Modified_Time desc limit 0, 200",
        ];

        try {
            $response = $client->request('POST', $apiURL, ['headers' => $headers, 'body' => json_encode($body)]);
            $statusCode = $response->getStatusCode();
            $responseBody = json_decode($response->getBody(), true);
        } catch (\Exception $e) {
            $responseBody = [
                'data' => [
                    0 => [
                        'code' => $e->getCode(),
                        'message' => $e->getMessage(),
                        'status' => 'error',
                    ]
                ],
            ];
        }
        return $responseBody;
    }
}
