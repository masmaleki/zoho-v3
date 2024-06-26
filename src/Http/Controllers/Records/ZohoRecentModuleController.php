<?php

namespace AliMehraei\ZohoAllInOne\Http\Controllers\Records;

use GuzzleHttp\Client;
use AliMehraei\ZohoAllInOne\Http\Controllers\Auth\ZohoTokenCheck;
use Illuminate\Support\Carbon;

class ZohoRecentModuleController
{

    public static function getModuleRecentRecords($module, $action = 'create', $offset = 0, $perPage = 200, $fields = null, $startDay = null, $endDay = null)
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

        $fields = $fields ?: 'id';

        $startDay = $startDay ?: Carbon::today()->subDays(config('zoho-v4.sync_new_records_period_in_days'))->format("Y-m-d") . "T00:00:01+00:00";
        $endDay = $endDay ?: Carbon::today()->addDay(1)->format("Y-m-d") . "T23:59:59+00:00";

        switch ($action) {
            case 'create':
                $condition = "Sales_Tools_Synced_At is null and Modified_Time between '{$startDay}' and '{$endDay}'";
                $query = "select " . $fields . " from " . $module . " where " . $condition . " order by Modified_Time desc limit " . $offset . ", " . $perPage;
                break;
            case 'update':
                $condition = "Sales_Tools_Synced_At is not null and Modified_Time between '{$startDay}' and '{$endDay}'";
                $query = "select " . $fields . " from " . $module . " where " . $condition . " order by Sales_Tools_Synced_At desc limit " . $offset . ", " . $perPage;
                break;
            case 'sync':
                $condition = "Created_Time between '{$startDay}' and '{$endDay}'";
                $query = "select " . $fields . " from " . $module . " where " . $condition . " order by Created_Time desc limit " . $offset . ", " . $perPage;
                break;
        }


        $body = ['select_query' => $query,];
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
