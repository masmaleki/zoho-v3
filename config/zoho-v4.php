<?php

// config for AliMehraei/ZohoAllInOne
return [
    /*
    |--------------------------------------------------------------------------
    | Location
    |--------------------------------------------------------------------------
    |
    | Zoho's location
    |
    */
    'location' => env('ZOHO_LOCATION', 'eu'),

    /*
    |--------------------------------------------------------------------------
    | Client ID
    |--------------------------------------------------------------------------
    |
    | Zoho's Client id for OAuth process
    |
    */
    'client_id' => env('ZOHO_CLIENT_ID', null),

    /*
    |--------------------------------------------------------------------------
    | Client Secret
    |--------------------------------------------------------------------------
    |
    | Zoho's Client secret for OAuth process
    |
    */
    'client_secret' => env('ZOHO_CLIENT_SECRET', null),

    /*
    |--------------------------------------------------------------------------
    | REDIRECT URI
    |--------------------------------------------------------------------------
    |
    | this is were we should handle the OAuth tokens after registering your
    | Zoho client
    |
    */
    'redirect_uri' => env('ZOHO_REDIRECT_URI', null),

    /*
    |--------------------------------------------------------------------------
    | CURRENT USER EMAIL
    |--------------------------------------------------------------------------
    |
    | Zoho's email address that will be used to interact with API
    |
    */
    'current_user_email' => env('ZOHO_CURRENT_USER_EMAIL', null),

    /*
    |--------------------------------------------------------------------------
    | LOG FILE PATH
    |--------------------------------------------------------------------------
    |
    | The SDK stores the log information in a file. you can change the path but
    | just make sure to create an empty file with name `ZCRMClientLibrary.log`
    | then point to the folder contains it in config file here
    |
    | note: In case the path is not specified, the log file will be created
    | inside the project.
    |
    */
    'application_log_file_path' => storage_path('app/zoho/oauth/logs'),

    /*
    |--------------------------------------------------------------------------
    | Token Persistence Path
    |--------------------------------------------------------------------------
    |
    | path of your tokens text file, this path is predefined and used by default,
    | and you are free to change this path, but just make sure that you generate
    | file with name `zcrm_oauthtokens.txt` then point to the folder that containing
    | the file here
    |
    */
    'token_persistence_path' => storage_path('app/zoho/oauth/tokens'),

    /*
    |--------------------------------------------------------------------------
    | ACCOUNTS URL
    |--------------------------------------------------------------------------
    |
    | Default value is set as US domain. This value can be changed based on your
    | domain (EU, CN).
    |
    | Available url's is:-
    | [`accounts.zoho.com`, `accounts.zoho.eu`, `accounts.zoho.com.cn`]
    |
    */
    'accounts_url' => env('ZOHO_ACCOUNTS_URL', 'https://accounts.zoho.com'),

    /*
    |--------------------------------------------------------------------------
    | ZOHO SANDBOX
    |--------------------------------------------------------------------------
    |
    | To make API calls to sandbox account, change the value of this key to true.
    | By default, the value is false
    |
    */
    'sandbox' => env('ZOHO_SANDBOX', false),

    /*
    |--------------------------------------------------------------------------
    | API BASE URL
    |--------------------------------------------------------------------------
    |
    | URL to be used when calling an API. It denotes the domain of the user.
    | This URL may be:
    | - www.zohoapis.com (default)
    | - www.zohoapis.eu
    | - www.zohoapis.com.cn
    |
    */
    'api_base_url' => env('ZOHO_API_BASE_URL', 'www.zohoapis.com'),
    'books_api_base_url' => env('ZOHO_BOOKS_API_BASE_URL', 'www.zohoapis.eu'),

    /*
    |--------------------------------------------------------------------------
    | API VERSION
    |--------------------------------------------------------------------------
    |
    | Zoho API version
    |
    */
    'api_version' => env('ZOHO_API_VERSION', 'v3'),

    /*
    |--------------------------------------------------------------------------
    | ACCESS TYPE
    |--------------------------------------------------------------------------
    |
    | must be set only to "offline" as online OAuth client is not supported by the
    | PHP SDK as of now.
    |
    */
    'access_type' => env('ZOHO_ACCESS_TYPE', 'offline'),

    /*
    |--------------------------------------------------------------------------
    | PERSISTENCE HANDLER CLASS
    |--------------------------------------------------------------------------
    |
    | Is the implementation of the ZohoOAuthPersistenceInterface. Refer to this
    | page for more details.
    | https://www.zoho.com/crm/developer/docs/php-sdk/token-persistence.html
    |
    */
    'persistence_handler_class' => env('ZOHO_PERSISTENCE_HANDLER_CLASS', 'ZohoOAuthPersistenceHandler'),

    /*
    |--------------------------------------------------------------------------
    | Zoho Path
    |--------------------------------------------------------------------------
    |
    | This is the base URI path where Zoho's views, such as the callback
    | verification screen, will be available from. You're free to tweak
    | this path according to your preferences and application design.
    |
    */
    'path' => env('ZOHO_PATH', 'zoho'),

    /*
    |--------------------------------------------------------------------------
    | Zoho Path
    |--------------------------------------------------------------------------
    |
    | This is the base URI path where Zoho's views, such as the callback
    | verification screen, will be available from. You're free to tweak
    | this path according to your preferences and application design.
    |
    */
    'oauth_scope' => env('ZOHO_OAUTH_SCOPE', 'ZohoCRM.modules.ALL,ZohoCRM.settings.ALL'),

    'middleware' => ['web'],

    'domain' => null,

    'prefix' => '',

    'custom_modules_names' => [
        'rfq' => env('ZOHO_CUSTOM_MODULE_RFQ', 'rfq'),
        'rfq_alternative_product' => env('ZOHO_CUSTOM_MODULE_RFQ_ALTERNATIVE_PRODUCT', 'Products_X_RFQ'),
        'manufacture' => env('ZOHO_CUSTOM_MODULE_MANUFACTURE', 'Manufacture'),
        'excess' => env('ZOHO_CUSTOM_MODULE_EXCESS', 'excess'),
        'history_po_so' => env('ZOHO_CUSTOM_MODULE_HISTORY_PO_SO', 'History_PO_SO'),
        'vendor_rfq' => env('ZOHO_CUSTOM_MODULE_VENDOR_RFQ', 'Vendor_RFQs'),
    ],

    'bulk_read_callback_base_url' => env('ZOHO_BULK_READ_CALLBACK_BASE_URL', env('APP_URL')),

    /*
    |--------------------------------------------------------------------------
    | Zoho User Roles
    |--------------------------------------------------------------------------
    |
    | This is array of all zoho roles which we used in our system.
    |
    */

    'roles' => [
        1 => [
            "display_label" => "CEO",
            "forecast_manager" => null,
            "share_with_peers" => true,
            "name" => "CEO",
            "description" => "Users with this role have access to the data owned by all other users.",
            "id" => "12792000000026968",
            "default_email" => "ceo@ceo.com"
        ],
        2 => [
            "display_label" => "Operative Manager",
            "forecast_manager" => null,
            "share_with_peers" => false,
            "name" => "Operative Manager",
            "description" => "Users belonging to this role cannot see data for admin users.",
            "id" => "12792000000369349",
            "default_email" => "operative.manager@operative.manager.com"
        ],
        3 => [
            "display_label" => "Administration",
            "forecast_manager" => null,
            "share_with_peers" => true,
            "name" => "Administration",
            "description" => "",
            "id" => "12792000000369350",
            "default_email" => "administration@administration.com"
        ],
        4 => [
            "display_label" => "Marketing",
            "forecast_manager" => null,
            "share_with_peers" => true,
            "name" => "Marketing",
            "description" => "",
            "id" => "12792000000369351",
            "default_email" => "marketing@marketing.com"
        ],
        5 => [
            "display_label" => "Purchasing",
            "forecast_manager" => null,
            "share_with_peers" => true,
            "name" => "Purchasing",
            "description" => "",
            "id" => "12792000000369352",
            "default_email" => "purchasing@purchasing.com"
        ],
        6 => [
            "display_label" => "Sales Manager",
            "forecast_manager" => null,
            "share_with_peers" => false,
            "name" => "Sales Manager",
            "description" => null,
            "id" => "12792000000369353",
            "default_email" => "sales.manager@sales.manager.com"
        ],
        7 => [
            "display_label" => "Sales",
            "forecast_manager" => null,
            "share_with_peers" => true,
            "name" => "Sales",
            "description" => "",
            "id" => "12792000000369354",
            "default_email" => "sales@sales.com"
        ],
    ],

    'sync_new_records_period_in_days' => env('ZOHO_SYNC_NEW_RECORDS_PERIOD_IN_DAYS', 1),
    'report_data_collector_months_ago' => env('ZOHO_REPORT_DATA_COLLECTOR_MONTHS_AGO', 1),
];
