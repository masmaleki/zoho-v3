<?php

namespace Masmaleki\ZohoAllInOne;

use com\zoho\crm\api\UserSignature;
use com\zoho\api\logger\Logger;
use com\zoho\crm\api\dc\USDataCenter;
use com\zoho\api\authenticator\OAuthToken;
use com\zoho\api\authenticator\TokenType;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Masmaleki\ZohoAllInOne\ZohoCustomTokenStore;

class ZohoAllInOne
{
    public static function getAuthUrl()
    {

        $client_id = env('ZOHO_CLIENT_ID');
        $secret_key = env('ZOHO_CLIENT_SECRET');
        $z_url = env('ZOHO_ACCOUNTS_URL');
        $z_return_url = env('ZOHO_REDIRECT_URI');
        $z_api_url = env('ZOHO_API_BASE_URL');
        $z_current_user_email = env('ZOHO_CURRENT_USER_EMAIL');

        return $z_url . "/oauth/v2/auth?scope=ZohoCRM.users.ALL,ZohoCRM.settings.ALL,ZohoCRM.modules.ALL,ZohoSearch.securesearch.READ&client_id=" . $client_id . "&response_type=code&access_type=offline&redirect_uri=" . $z_return_url;
    }

    public static function saveTokens(Request $request)
    {
        $data = $request->all();
        $client_id = env('ZOHO_CLIENT_ID');
        $secret_key = env('ZOHO_CLIENT_SECRET');
        $z_url = env('ZOHO_ACCOUNTS_URL');
        $z_return_url = env('ZOHO_REDIRECT_URI');
        $z_api_url = env('ZOHO_API_BASE_URL');
        $z_current_user_email = env('ZOHO_CURRENT_USER_EMAIL');
        $postInput = [
            'grant_type' => 'authorization_code',
            'client_id' => $client_id,
            'client_secret' => $secret_key,
            'redirect_uri' => $z_return_url,
            'code' => $data['code'],
        ];
        $zoho = new ZohoCustomTokenStore();
        if ($request->has('refresh_token')) {
            $token = $zoho->saveToken($postInput, $request->all(), $client_id, $secret_key, $z_return_url);
        } else {
            $resp = $zoho->getToken($data['accounts-server'], $data['location'], $postInput);
            $token = $zoho->saveToken($postInput, $resp, $client_id, $secret_key, $z_return_url);
        }


        //TODO: must be improved.
        $previousURL = url()->previous();
        //dd($previousURL,str_contains( $previousURL,'customers'));
        if (str_contains($previousURL, 'customers'))
            return redirect()->to($previousURL);


        return $token;
    }

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

    public static function getContacts($token)
    {
        if (!$token) {
            return null;
        }
        $apiURL = $token->api_domain . '/crm/v3/Contacts?fields=Email,First_Name,Last_Name,Mobile';
        $client = new Client();

        $headers = [
            'Authorization' => 'Zoho-oauthtoken ' . $token->access_token,
        ];

        $response = $client->request('GET', $apiURL, ['headers' => $headers]);
        $statusCode = $response->getStatusCode();
        $responseBody = json_decode($response->getBody(), true);
        return $responseBody;
    }

    public static function getContact($zoho_contact_id, $token)
    {

        $apiURL = $token->api_domain . '/crm/v3/Contacts/search?criteria=(id:equals:' . $zoho_contact_id . ')';
        $client = new Client();

        $headers = [
            'Authorization' => 'Zoho-oauthtoken ' . $token->access_token,
        ];

        $response = $client->request('GET', $apiURL, ['headers' => $headers]);
        $statusCode = $response->getStatusCode();
        $responseBody = json_decode($response->getBody(), true);
        return $responseBody;
    }

    public static function getContactByEmailAddress($zoho_email, $token)
    {
        $apiURL = $token->api_domain . '/crm/v3/Contacts/search?email=' . $zoho_email . '';
        $client = new Client();

        $headers = [
            'Authorization' => 'Zoho-oauthtoken ' . $token->access_token,
        ];

        $response = $client->request('GET', $apiURL, ['headers' => $headers]);
        $statusCode = $response->getStatusCode();
        $responseBody = json_decode($response->getBody(), true);
        return $responseBody;
    }
}
