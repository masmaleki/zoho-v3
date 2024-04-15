<?php

namespace AliMehraei\ZohoAllInOne\Http\Controllers\Records;


use GuzzleHttp\Client;
use AliMehraei\ZohoAllInOne\Http\Controllers\Auth\ZohoTokenCheck;
use Illuminate\Support\Carbon;

class ZohoProductController
{
    public static function getAll($page_token = null)
    {
        $token = ZohoTokenCheck::getToken();
        if (!$token) {
            return null;
        }
        $apiURL = $token->api_domain . '/crm/v3/Products?fields=Product_Name,Lifecylce_Status,Owner,Created_By,Modified_By';
//        $apiURL = $token->api_domain . '/crm/v3/Products';
        if ($page_token) {
            $apiURL .= '&page_token=' . $page_token;
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

    public static function getById($zoho_product_id, $fields = null)
    {

        $token = ZohoTokenCheck::getToken();
        if (!$token) {
            return null;
        }
        $apiURL = $token->api_domain . '/crm/v3/Products/' . $zoho_product_id ;
        // $apiURL = $token->api_domain . '/crm/v3/Products/search?criteria=(id:equals:' . $zoho_product_id . ')';
        if ($fields) {
            $apiURL .= '?fields=' . $fields;
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

    public static function getItemById($zoho_books_item_id, $organization_id = null)
    {
        $token = ZohoTokenCheck::getToken();
        if (!$token) {
            return null;
        }
        $apiURL = config('zoho-v4.books_api_base_url') . '/books/v3/items/' . $zoho_books_item_id;
        if ($organization_id) {
            $apiURL .= '?organization_id=' . $organization_id;
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
    public static function searchItemByName($product_name, $organization_id = null)
    {
        $token = ZohoTokenCheck::getToken();
        if (!$token) {
            return null;
        }
        $apiURL = config('zoho-v4.books_api_base_url') . '/books/v3/items?page=1&per_page=25&sort_column=created_time&sort_order=A&name_contains='.$product_name;
        if ($organization_id) {
            $apiURL .= '&organization_id=' . $organization_id;
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

    public static function updateProduct($data = [])
    {
        $zoho_product_id = $data['id'];

        $token = ZohoTokenCheck::getToken();
        if (!$token) {
            return null;
        }
        $apiURL = $token->api_domain . '/crm/v3/Products/' . $zoho_product_id . '';
        $client = new Client();

        $headers = [
            'Authorization' => 'Zoho-oauthtoken ' . $token->access_token,
        ];

        if (!isset($data['id'])) {
            $data['id'] = $zoho_product_id;
        }

        $body = [
            'data' => [
                0 => $data
            ]
        ];
        $response = $client->request('PUT', $apiURL, ['headers' => $headers, 'body' => json_encode($body)]);
        $statusCode = $response->getStatusCode();
        $responseBody = json_decode($response->getBody(), true);
        return $responseBody;
    }

    public static function create($data = [])
    {
        $token = ZohoTokenCheck::getToken();
        if (!$token) {
            return null;
        }
        $apiURL = $token->api_domain . '/crm/v3/Products';
        $client = new Client();

        $headers = [
            'Authorization' => 'Zoho-oauthtoken ' . $token->access_token,
        ];

        $body = [
            'data' => [
                0 => $data
            ]
        ];

        $response = $client->request('POST', $apiURL, ['headers' => $headers, 'body' => json_encode($body)]);
        $statusCode = $response->getStatusCode();
        $responseBody = json_decode($response->getBody(), true);
        return $responseBody;
    }

    public static function updateItem($data = [])
    {
        $zoho_books_item_id = $data['id'];
        $organization_id = $data['organization_id'] ?? null;
        unset($data['organization_id']);
        unset($data['id']);
        $token = ZohoTokenCheck::getToken();
        if (!$token) {
            return null;
        }
        $apiURL = config('zoho-v4.books_api_base_url') . '/books/v3/items/' . $zoho_books_item_id;
        if ($organization_id) {
            $apiURL .= '?organization_id=' . $organization_id;
        }
        $client = new Client();

        $headers = [
            'Authorization' => 'Zoho-oauthtoken ' . $token->access_token,
        ];

        $body = $data;

        $response = $client->request('PUT', $apiURL, ['headers' => $headers, 'body' => json_encode($body)]);
        $statusCode = $response->getStatusCode();
        $responseBody = json_decode($response->getBody(), true);
        return $responseBody;
    }

    public static function search($phrase)
    {
        $token = ZohoTokenCheck::getToken();
        if (!$token) {
            return null;
        }
        $apiURL = $token->api_domain . '/crm/v3/Products/search?word=' . $phrase;//. '&fields=Product_Name,Part_Description';
        $client = new Client();

        $headers = [
            'Authorization' => 'Zoho-oauthtoken ' . $token->access_token,
        ];

        $response = $client->request('GET', $apiURL, ['headers' => $headers]);
        $statusCode = $response->getStatusCode();
        $responseBody = json_decode($response->getBody(), true);
        return $responseBody;
    }

    public static function getImage($zoho_product_id)
    {
        $token = ZohoTokenCheck::getToken();
        if (!$token) {
            return null;
        }
        $apiURL = $token->api_domain . '/crm/v3/Products/' . $zoho_product_id . '/photo';
        $client = new Client();

        $headers = [
            'Authorization' => 'Zoho-oauthtoken ' . $token->access_token,
        ];

        $response = $client->request('GET', $apiURL, ['headers' => $headers, ['stream' => true]]);

        $responseBody = $response->getBody()->getContents();
        $base64 = base64_encode($responseBody);

        if (!$base64) return null;

        $mime = "image/jpeg";
        $img = ('data:' . $mime . ';base64,' . $base64);

        return $img;
    }

    public static function getZohoBooksItem($zoho_books_item_id, $organization_id = null)
    {
        $token = ZohoTokenCheck::getToken();
        if (!$token) {
            return null;
        }
        $apiURL = config('zoho-v4.books_api_base_url') . '/books/v3/items/' . $zoho_books_item_id;
        if ($organization_id) {
            $apiURL .= '?organization_id=' . $organization_id;
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

    public static function getAllZohoBooksItems($organization_id = null, $page, $conditions)
    {
        $token = ZohoTokenCheck::getToken();
        if (!$token) {
            return null;
        }
        $apiURL = config('zoho-v4.books_api_base_url') . '/books/v3/items?organization_id=' . $organization_id . '&page=' . $page . $conditions;

        $client = new Client();

        $headers = [
            'Authorization' => 'Zoho-oauthtoken ' . $token->access_token,
        ];

        $response = $client->request('GET', $apiURL, ['headers' => $headers]);
        $statusCode = $response->getStatusCode();
        $responseBody = json_decode($response->getBody(), true);
        return $responseBody;
    }

    public static function getProductsCOQL($zoho_crm_product_id = null, $offset = 0, $conditions = null, $fields = null)
    {
        $token = ZohoTokenCheck::getToken();
        if (!$token) {
            return null;
        }

        $apiURL = $token->api_domain . '/crm/v3/coql';
        $client = new Client();

        $headers = [
            'Authorization' => 'Zoho-oauthtoken ' . $token->access_token,
        ];

        $conditions = ($conditions) ? $conditions . ' and ' : '';
        $zoho_crm_product_id_conditions = $zoho_crm_product_id != null ? " (id = " . $zoho_crm_product_id . ")" : "(id != 0) ";

        $fields = $fields ? $fields : 'Qty_in_Demand , Owner ,RoHs,  Product_Active , Created_Time, id, Product_Name , Lifecylce_Status , SPQ1 , Record_Image , RoHs_Status ,  Catagory, MPN_ID , Taxable ,Product_Category, Manufacture_Name, Packaging, Datasheet_URL, Octopart_URL';

        $body = [
            'select_query' => "select " . $fields . " from Products where " . $conditions . $zoho_crm_product_id_conditions . "  limit " . $offset . ", 200",
        ];

        $response = $client->request('POST', $apiURL, ['headers' => $headers, 'body' => json_encode($body)]);

        $statusCode = $response->getStatusCode();
        $responseBody = json_decode($response->getBody(), true);
        return $responseBody;
    }

    public static function getRecentProductsV6($zoho_crm_product_id = null, $offset = 0, $conditions = null, $fields = null,$action)
    {
        $token = ZohoTokenCheck::getToken();
        if (!$token) {
            return null;
        }

        $apiURL = $token->api_domain . '/crm/v6/coql';
        $client = new Client();

        $headers = [
            'Authorization' => 'Zoho-oauthtoken ' . $token->access_token,
        ];

        if (!$conditions) {
            $todayStart = Carbon::today()->subDays(1)->format("Y-m-d") . "T00:00:01+00:00";
            $todayEnd = Carbon::today()->addDay()->format("Y-m-d") . "T23:59:59+00:00";
        
            if ($action == 'create') {
                $conditions = "sync_with_panel is null and Created_Time between '{$todayStart}' and '{$todayEnd}'";
            } else {
                $conditions = "Created_Time between '{$todayStart}' and '{$todayEnd}' and sync_with_panel <> Modified_Time";
            }
        } 

        $fields = $fields ? $fields : 'Created_Time,id,Alternative_MPN,Alternative_MPN_2,Alternative_MPN_3,
        Alternative_MPN_4,Approved_By,Average_Lead_Time,Business_Product,Capacitance,Case_Code_Imperial,Case_Code_Metric,		
        Case_Package,Catagory,Commission_Rate,Composition,Core_Architecture,Created_By,Datasheet_URL,Depth,Description,
        Dielectric,Duplicated_Status,EAR,Flash_Memory_Size,Frequency,Halogen_Free,Handler,Height,M_Last_Update,
        Manufacture_Name,Material,Max_Operating_Temperature,Max_Supply_Voltage,Min_Operating_Temperature,	
        Webhook_Not_Allowed,Weight,Width,ZohoBooksID';

        // Min_Supply_Voltage,Modified_By,Mount,Mouser_Category,Mouser_ID,Lifecycle_Status,Mouser_URL,MPN_ID,Nominal_Supply_Current,	
        // Number_of_A_D_Converters,Number_of_Channels,Number_of_D_A_Converters,Number_of_I_Os,Number_of_I2C_Channels,		
        // Number_of_Pins,Number_of_SPI_Channels,Number_of_Timers_Counters,Number_of_UART_Channels,Number_of_USART_Channels,		
        // Octopart_Compliance_Documents,Octopart_Datasheets,Octopart_ID,Octopart_Images,Octopart_Short_Description,Octopart_URL,	
        // OP_Failure_Message,OP_Last_Update,Package,Packaging,Part_Description,Product_Active,Product_Category,Product_Code,		
        // Record_Image,Product_Margin,Product_Name,Owner,Product_Type,Qty_Ordered,Qty_in_Demand,Qty_in_Stock,Radiation_Hardening,
        // RAM_Size,Rate,Reach,REACH_SVHC,Reorder_Level,Resistance,RFQ_Alternative,RoHs,RoHs_Status,Sales_End_Date,Sales_Start_Date,	
        // Schedule_B,SPQ1,Support_Expiry_Date,Support_Start_Date,sync_with_panel,Tag,Tariff_Code,Tax,Taxable,Temperature_Coefficient,
        // Termination,Thickness,Tolerance,Unit_Price,TEST,Usage_Unit,Vendor_Name,Voltage,Voltage_Rating,Voltage_Rating_DC,Decimal,Manufacture,
        $body = [
            'select_query' => "select " . $fields . " from Products where "  . $conditions  . "  limit " . $offset . ", 200",
        ];

        $response = $client->request('POST', $apiURL, ['headers' => $headers, 'body' => json_encode($body)]);

        $statusCode = $response->getStatusCode();
        $responseBody = json_decode($response->getBody(), true);
        return $responseBody;
    }

}
