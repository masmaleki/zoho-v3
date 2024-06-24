<?php

namespace AliMehraei\ZohoAllInOne\Http\Controllers\Records;

use GuzzleHttp\Client;
use Illuminate\Support\Carbon;
use AliMehraei\ZohoAllInOne\Http\Controllers\Auth\ZohoTokenCheck;

class ZohoExcessController
{
    public static function create($data = null)
    {
        if (!$data) {
            return null;
        }
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
        $apiURL = $token->api_domain . '/crm/v3/' . config('zoho-v4.custom_modules_names.excess');
        $client = new Client();

        $headers = [
            'Authorization' => 'Zoho-oauthtoken ' . $token->access_token,
        ];

        $body = [
            'data' => [
                0 => $data
            ]
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

    public static function updateV2_2($data = [])
    {
        $zoho_excess_id = $data['id'];

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
        $apiURL = $token->api_domain . '/crm/v2.2/'. config('zoho-v4.custom_modules_names.excess').'/' . $zoho_excess_id . '';
        $client = new Client();

        $headers = [
            'Authorization' => 'Zoho-oauthtoken ' . $token->access_token,
        ];

        if (!isset($data['id'])) {
            $data['id'] = $zoho_excess_id;
        }

        $body = [
            'data' => [
                0 => $data
            ]

        ];

        try {
            $response = $client->request('PUT', $apiURL, ['headers' => $headers, 'body' => json_encode($body)]);
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

    public static function get($excess_id)
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
        $apiURL = $token->api_domain . '/crm/v3/' . config('zoho-v4.custom_modules_names.excess') . '/' . $excess_id;
        $client = new Client();

        $headers = [
            'Authorization' => 'Zoho-oauthtoken ' . $token->access_token,
        ];

        try {
            $response = $client->request('GET', $apiURL, ['headers' => $headers]);
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

    public static function getProductExcesses($product_id, $fields, $condition)
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

        $apiURL = $token->api_domain . '/crm/v3/coql';
        $client = new Client();

        $headers = [
            'Authorization' => 'Zoho-oauthtoken ' . $token->access_token,
        ];

        if (!$fields) {
            $fields = 'Name,id,Currency,Created_Time,Cost,Quantity,Date_Code,SPQ,MOQ';
        }

        if (!$condition) {
            $condition = "Product_name.id = " . $product_id . " ";
        }

        $body = [
            'select_query' => "select " . $fields . " from " . config('zoho-v4.custom_modules_names.excess') . " where " . $condition . " order by Created_Time desc",
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

    public static function getRecentExcesses($offset, $condition, $fields)
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

        $apiURL = $token->api_domain . '/crm/v3/coql';
        $client = new Client();

        $headers = [
            'Authorization' => 'Zoho-oauthtoken ' . $token->access_token,
        ];

        if (!$fields) {
            $fields = 'Name,id,Currency,Owner,Owner.email,Owner.first_name,Owner.last_name,Product_name,Product_name.Product_Name,Created_Time,Cost,Quantity,Date_Code,SPQ,MOQ';
        }

        if (!$condition) {
            $condition = " Created_Time between '" . Carbon::today()->subDays(1)->format("Y-m-d") . "T00:00:01+00:00' and '" . Carbon::today()->addDay()->format("Y-m-d") . "T23:59:59+00:00' ";
        }
        $body = [
            'select_query' => "select " . $fields . " from " . config('zoho-v4.custom_modules_names.excess') . " where " . $condition . " order by Created_Time desc limit " . $offset . ", 200",
        ];
        // dd($body);
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

    public static function getRecentExcessesV6($offset, $condition, $fields,$action)
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

        if (!$fields) {
            $fields = 'Name,id,Currency,Owner,Product_name,Created_Time,Cost,Quantity,
            Date_Code,SPQ,MOQ,Sales_Tools_Synced_At,Account_Name,Contact,Email,Excess_Source,
            Created_By,Secondary_Email,Comment,Customer_Internal_No,Email_Opt_Out,
            Excess_No,Excess_Type,Exchange_Rate,Modified_By,Portal_Excess_Id,Modified_Time';

        }

        if (!$condition) {
            $todayStart = Carbon::today()->subDays(1)->format("Y-m-d") . "T00:00:01+00:00";
            $todayEnd = Carbon::today()->addDay()->format("Y-m-d") . "T23:59:59+00:00";

            if ($action == 'create') {
                $condition = "Sales_Tools_Synced_At is null and Modified_Time between '{$todayStart}' and '{$todayEnd}'";
            } else {
                // $condition = "(((Sales_Tools_Synced_At is not null) and (Modified_Time between '{$todayStart}' and '{$todayEnd}')) and (Sales_Tools_Synced_At < Modified_Time))";
                $condition = "Sales_Tools_Synced_At is not null and Modified_Time between '{$todayStart}' and '{$todayEnd}'";
            }
        }
        $body = [
            'select_query' => "select " . $fields . " from " . config('zoho-v4.custom_modules_names.excess') . " where " . $condition . " order by Modified_Time desc limit " . $offset . ", 200",
        ];
        // dd($body);
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
