<?php

namespace Masmaleki\ZohoAllInOne;

use Masmaleki\ZohoAllInOne\Http\Controllers\Records\ZohoContactController;
use Masmaleki\ZohoAllInOne\Http\Controllers\Records\ZohoInvoiceController;
use Masmaleki\ZohoAllInOne\Http\Controllers\Records\ZohoProductController;
use Masmaleki\ZohoAllInOne\Http\Controllers\Users\ZohoOrganizationController;
use Masmaleki\ZohoAllInOne\Http\Controllers\Settings\ZohoRoleController;
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
    public static function getContacts($page_token = null)
    {
        return ZohoContactController::getAll($page_token);
    }

    public static function getContact($zoho_contact_id)
    {
        return ZohoContactController::getById($zoho_contact_id);
    }

    public static function getContactByEmailAddress($zoho_email)
    {
        return ZohoContactController::getByEmail($zoho_email);
    }

    public static function createContact($data = [])
    {
        return ZohoContactController::create($data);
    }

    public static function updateContact($zoho_contact_id, $data = [])
    {
        return ZohoContactController::updateById($zoho_contact_id, $data);
    }

    public static function getContactAvatar($zoho_contact_id)
    {
        return ZohoContactController::getAvatar($zoho_contact_id);
    }

    public static function updateContactAvatar($zoho_contact_id, $filePath, $fileMime, $fileUploadedName)
    {
        return ZohoContactController::updateAvatar($zoho_contact_id, $filePath, $fileMime, $fileUploadedName);
    }

    public static function deleteContactAvatar($zoho_contact_id)
    {
        return ZohoContactController::deleteAvatar($zoho_contact_id);
    }
    // end - contact functions

    // start - products functions

    public static function getProducts()
    {
        return ZohoProductController::getAll();
    }

    public static function getProduct($zoho_product_id)
    {
        return ZohoProductController::getById($zoho_product_id);
    }

    public static function productsSearch($phrase)
    {
        return ZohoProductController::search($phrase);
    }
    // end - product functions

    // start - invoice functions
    public static function getInvoices($organization_id)
    {
        return ZohoInvoiceController::getAll($organization_id);
    }

    public static function getInvoice($zoho_invoice_id)
    {
        return ZohoInvoiceController::getById($zoho_invoice_id);
    }

    public static function getVendorInvoices($zoho_vendor_id)
    {
        return ZohoInvoiceController::getByVendorId($zoho_vendor_id);
    }

    // end - invoice functions


    // start - organizations functions

    public static function getOrganizations()
    {
        return ZohoOrganizationController::getAll();
    }

    // end - organizations functions

    // start - settings functions

    public static function getRoles()
    {
        return ZohoRoleController::getAll();
    }
    // end - settings functions

}
