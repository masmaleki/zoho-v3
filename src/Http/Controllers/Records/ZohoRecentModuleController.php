<?php

namespace AliMehraei\ZohoAllInOne\Http\Controllers\Records;

use GuzzleHttp\Client;
use AliMehraei\ZohoAllInOne\Http\Controllers\Auth\ZohoTokenCheck;
use Illuminate\Support\Carbon;

class ZohoRecentModuleController
{

    public static function getRecentModuleIdFieldV6($module, $action = 'create')
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


        $startDay = Carbon::today()->subDays(config('zoho-v4.sync_new_records_period_in_days'))->format("Y-m-d") . "T00:00:01+00:00";
        $endDay = Carbon::today()->addDay(1)->format("Y-m-d") . "T23:59:59+00:00";

        switch ($action) {
            case 'create':
                $condition = "Sales_Tools_Synced_At is null and Modified_Time between '{$startDay}' and '{$endDay}'";
                break;
            case 'edit':
                $condition = "Sales_Tools_Synced_At is not null and Modified_Time between '{$startDay}' and '{$endDay}'";
                break;
            case 'sync':
                $condition = "Created_Time between '{$startDay}' and '{$endDay}'";
                break;
        }


        $body = [
            'select_query' => "select " . $fields . " from " . $module . " where " . $condition . " order by Modified_Time desc limit 0, 200",
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
