<?php

namespace Masmaleki\ZohoAllInOne\Http\Controllers\Records;


use GuzzleHttp\Client;
use Masmaleki\ZohoAllInOne\Http\Controllers\Auth\ZohoTokenCheck;

class ZohoVendorController
{

    public static function getAll($page_token = null,$fields=null)
    {
        $token = ZohoTokenCheck::getToken();
        if (!$token) {
            return null;
        }
        if($fields==null){
            $fields='Email,Business_Vendor,Vendor_Source,Vendor_Type,LinkedIn,Website,Mobile,Phone,Vendor_Name,Country,First_Name,Last_Name,ZohoBooksID,Octopart_ID,Broker_Type,Vendor_Site,Vendor_Owner,Zip_Code,Street,State,Description,City,VAT_No,Approve_status,Currency,Incoterms,Line_Card,Parent_Vendor,Payment_Terms,Vendor_Number';
        }
        $apiURL = $token->api_domain . '/crm/v3/Vendors?fields='.$fields;
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
   
    public static function create($data)
    {
        if (!$data) {
            return null;
        }
        $token = ZohoTokenCheck::getToken();
        if (!$token) {
            return null;
        }
        $apiURL = $token->api_domain . '/crm/v3/Vendors';
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


    public static function getZohoCrmVendor($zoho_crm_vendor_id)
    {
        $token = ZohoTokenCheck::getToken();
        if (!$token) {
            return null;
        }
        $apiURL = $token->api_domain . '/crm/v3/Vendors/' . $zoho_crm_vendor_id . '';
        $client = new Client();

        $headers = [
            'Authorization' => 'Zoho-oauthtoken ' . $token->access_token,
        ];

        $response = $client->request('GET', $apiURL, ['headers' => $headers]);
        $statusCode = $response->getStatusCode();
        $responseBody = json_decode($response->getBody(), true);
        return $responseBody;
    }

    public static function getAllFromBooks($organization_id, $page = 1, $condition = '')
    {

        $token = ZohoTokenCheck::getToken();
        if (!$token) {
            return null;
        }
        $apiURL = config('zoho-v3.books_api_base_url') . '/api/v3/vendors?organization_id=' . $organization_id . '&page=' . $page . $condition;

        $client = new Client();

        $headers = [
            'Authorization' => 'Zoho-oauthtoken ' . $token->access_token,
        ];

        $response = $client->request('GET', $apiURL, ['headers' => $headers]);
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
        $apiURL = $token->api_domain . '/crm/v3/Vendors/search?word=' . $phrase;
        $client = new Client();

        $headers = [
            'Authorization' => 'Zoho-oauthtoken ' . $token->access_token,
        ];

        $response = $client->request('GET', $apiURL, ['headers' => $headers]);
        $statusCode = $response->getStatusCode();
        $responseBody = json_decode($response->getBody(), true);
        return $responseBody;
    }

    public static function getZohoBooksVendorByCrmVendorId($zoho_crm_vendor_id, $organization_id)
    {
        $token = ZohoTokenCheck::getToken();
        if (!$token) {
            return null;
        }
        // TODO: Must be checked
        $apiURL = config('zoho-v3.books_api_base_url') . '/api/v3/vendors?zcrm_vendor_id=' . $zoho_crm_vendor_id;
        // $apiURL = $token->api_domain . '/books/v3/crm/vendor/' . $zoho_crm_vendor_id . '/import?organization_id=' . $organization_id;

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

    public static function getZohoBooksVendorById($zoho_books_vendor_id, $organization_id = null)
    {
        $token = ZohoTokenCheck::getToken();
        if (!$token) {
            return null;
        }
        $apiURL = config('zoho-v3.books_api_base_url') . '/api/v3/contacts/' . $zoho_books_vendor_id ;
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

    public static function getImage($zoho_id)
    {
        $token = ZohoTokenCheck::getToken();
        if (!$token) {
            return null;
        }
        $apiURL = $token->api_domain . '/crm/v3/Vendors/' . $zoho_id . '/photo';
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
    public static function updateAvatar($zoho_contact_id, $filePath, $fileMime, $fileUploadedName)
    {
        $token = ZohoTokenCheck::getToken();
        if (!$token) {
            return null;
        }
        $apiURL = $token->api_domain . '/crm/v3/Vendors/' . $zoho_contact_id . '/photo';
        $client = new Client();

        $params = [
            'headers' => [
                'Authorization' => 'Zoho-oauthtoken ' . $token->access_token,
            ],
            'multipart' => [
                [
                    'name' => 'file',
                    'filename' => $fileUploadedName,
                    'Mime-Type' => $fileMime,
                    'contents' => fopen($filePath, 'r'),
                ],
            ],
        ];

        $response = $client->request('POST', $apiURL, $params);
        $statusCode = $response->getStatusCode();
        $responseBody = json_decode($response->getBody(), true);
        return $responseBody;
    }

    public static function deleteAvatar($zoho_contact_id)
    {
        $token = ZohoTokenCheck::getToken();
        if (!$token) {
            return null;
        }
        $apiURL = $token->api_domain . '/crm/v3/Vendors/' . $zoho_contact_id . '/photo';
        $client = new Client();

        $headers = [
            'Authorization' => 'Zoho-oauthtoken ' . $token->access_token,
        ];

        $response = $client->request('DELETE', $apiURL, ['headers' => $headers]);
        $statusCode = $response->getStatusCode();
        $responseBody = json_decode($response->getBody(), true);
        return $responseBody;
    }

    public static function update($zoho_crm_id, $data)
    {
        if (!$data) {
            return null;
        }
        $token = ZohoTokenCheck::getToken();
        if (!$token) {
            return null;
        }
        $apiURL = $token->api_domain . '/crm/v3/Vendors/' . $zoho_crm_id;
        $client = new Client();

        $headers = [
            'Authorization' => 'Zoho-oauthtoken ' . $token->access_token,
        ];

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


}
