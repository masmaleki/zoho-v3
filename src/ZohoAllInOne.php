<?php

namespace Masmaleki\ZohoAllInOne;

use Masmaleki\ZohoAllInOne\Http\Controllers\Records\ZohoContactController;

class ZohoAllInOne
{

    public static function getUsers($token)
    {


        $apiURL = $token->api_domain . '/crm/v3/users';
        $client = new Client();
        $postInput = [
            'page' => 1,
            'type' => 'AllUsers'
        ];
        $headers = [
            'Authorization' => 'Zoho-oauthtoken ' . $token->access_token,
        ];

        $response = $client->request('GET', $apiURL, ['form_params' => $postInput, 'headers' => $headers]);
        $statusCode = $response->getStatusCode();
        $responseBody = json_decode($response->getBody(), true);
        return $responseBody;
    }

    public static function getContacts()
    {
        return ZohoContactController::getAll();
    }

    public static function getContact($zoho_contact_id)
    {
        return ZohoContactController::getById($zoho_contact_id);
    }

    public static function getContactByEmailAddress($zoho_email)
    {
        return ZohoContactController::getByEmail($zoho_email);
    }
}
