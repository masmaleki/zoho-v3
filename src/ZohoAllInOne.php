<?php

namespace Masmaleki\ZohoAllInOne;

use Masmaleki\ZohoAllInOne\Http\Controllers\Records\ZohoContactController;
use Masmaleki\ZohoAllInOne\Http\Controllers\Records\ZohoProductController;
use Masmaleki\ZohoAllInOne\Http\Controllers\Users\ZohoUserController;

class ZohoAllInOne
{

    // start - users functions
    public static function getUsers()
    {
        return ZohoUserController::getAll();
    }
    // end - users functions

    // start - contact functions
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
    // end - product functions

    // start - users functions

    public static function getProducts()
    {
        return ZohoProductController::getAll();
    }
    public static function productsSearch($phrase)
    {
        return ZohoProductController::search($phrase);
    }
    // end - product functions

}
