<?php

namespace Masmaleki\ZohoAllInOne;

use Masmaleki\ZohoAllInOne\Http\Controllers\Records\ZohoRecordCountController;
use Masmaleki\ZohoAllInOne\Http\Controllers\Records\ZohoRFQController;
use Masmaleki\ZohoAllInOne\Http\Controllers\Records\ZohoAccountController;
use Masmaleki\ZohoAllInOne\Http\Controllers\Records\ZohoContactController;
use Masmaleki\ZohoAllInOne\Http\Controllers\Records\ZohoInvoiceController;
use Masmaleki\ZohoAllInOne\Http\Controllers\Records\ZohoProductController;
use Masmaleki\ZohoAllInOne\Http\Controllers\Records\ZohoQuoteController;
use Masmaleki\ZohoAllInOne\Http\Controllers\Records\ZohoSaleOrderController;
use Masmaleki\ZohoAllInOne\Http\Controllers\Users\ZohoOrganizationController;
use Masmaleki\ZohoAllInOne\Http\Controllers\Settings\ZohoRoleController;
use Masmaleki\ZohoAllInOne\Http\Controllers\Users\ZohoUserController;

class ZohoAllInOne
{

    // start - general functions
    public static function getModuleCount($moduleName, $type = null, $value = null)
    {
        return ZohoRecordCountController::count($moduleName, $type, $value);
    }

    public static function getModuleCountCOQL($moduleName, $condition = null)
    {
        return ZohoRecordCountController::countCOQL($moduleName, $condition);
    }

    public static function getZBCount($moduleName, $organization_id)
    {
        return ZohoRecordCountController::countZBCOQL($moduleName, $organization_id);
    }
    // end - general functions

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

    public static function contactsSearch($phrase)
    {
        return ZohoContactController::search($phrase);
    }
    // end - contact functions

    // start - accounts functions
    public static function getZohoCrmAccount($zoho_crm_account_id)
    {
        return ZohoAccountController::getZohoCrmAccount($zoho_crm_account_id);
    }

    public static function getZohoBooksAccountByCrmAccountId($zoho_crm_account_id, $organization_id = null)
    {
        return ZohoAccountController::getZohoBooksAccountByCrmAccountId($zoho_crm_account_id, $organization_id);
    }
    // end - accounts functions

    // start - products functions

    public static function getProducts($page_token = null)
    {
        return ZohoProductController::getAll($page_token);
    }

    public static function getProduct($zoho_product_id)
    {
        return ZohoProductController::getById($zoho_product_id);
    }

    public static function productsSearch($phrase)
    {
        return ZohoProductController::search($phrase);
    }

    public static function getProductImage($zoho_product_id)
    {
        return ZohoProductController::getImage($zoho_product_id);
    }
    // end - product functions

    // start - invoice functions
    public static function getInvoices($organization_id)
    {
        return ZohoInvoiceController::getAll($organization_id);
    }

    public static function getInvoice($zoho_invoice_id, $organization_id = null)
    {
        return ZohoInvoiceController::getById($zoho_invoice_id, $organization_id);
    }

    public static function getVendorInvoices($zoho_vendor_id)
    {
        return ZohoInvoiceController::getByVendorId($zoho_vendor_id);
    }

    public static function getInvoiceByCustomerId($zoho_customer_id, $organization_id = null)
    {
        return ZohoInvoiceController::getByCustomerId($zoho_customer_id, $organization_id);
    }

    public static function searchInvoiceByCustomerId($zoho_customer_id, $searchParameter = null, $organization_id = null)
    {
        return ZohoInvoiceController::searchByCustomerId($zoho_customer_id, $searchParameter, $organization_id);
    }

    public static function getInvoicePDF($invoice_id)
    {
        return ZohoInvoiceController::getPDF($invoice_id);
    }

    // end - invoice functions


    // start - invoice functions
    public static function getSaleOrders($organization_id)
    {
        return ZohoSaleOrderController::getAll($organization_id);
    }

    public static function getSaleOrder($sale_order_id, $organization_id = null)
    {
        return ZohoSaleOrderController::getById($sale_order_id, $organization_id);
    }

    public static function getSaleOrderByCustomerId($zoho_customer_id, $organization_id = null)
    {
        return ZohoSaleOrderController::getByCustomerId($zoho_customer_id, $organization_id);
    }

    public static function getSaleOrderPDF($sale_order_id)
    {
        return ZohoSaleOrderController::getPDF($sale_order_id);
    }

    // end - invoice functions


    // start - organizations functions

    public static function getOrganizations()
    {
        return ZohoOrganizationController::getAll();
    }

    // end - organizations functions


    // start - RFQ functions

    public static function getRFQ($rfq_id)
    {
        return ZohoRFQController::get($rfq_id);
    }

    public static function getRFQs()
    {
        return ZohoRFQController::getAll();
    }

    public static function getAccountRFQs($zoho_crm_account_id, $page_token = null)
    {
        return ZohoRFQController::getAccountRFQs($zoho_crm_account_id, $page_token);
    }

    public static function getAccountRFQsCOQL($zoho_crm_account_id, $offset = 0, $conditions = null, $fields = null)
    {
        return ZohoRFQController::getAccountRFQsCOQL($zoho_crm_account_id, $offset, $conditions, $fields);
    }

    public static function rfqsSearch($phrase, $criteria = null)
    {
        return ZohoRFQController::search($phrase, $criteria);
    }

    // end - RFQ functions


    // start - Quote functions

    public static function getQuote($quote_id)
    {
        return ZohoQuoteController::get($quote_id);
    }

    public static function getQuotes()
    {
        return ZohoQuoteController::getAll();
    }

    public static function getAccountQuotes($zoho_crm_account_id, $page_token = null)
    {
        return ZohoQuoteController::getAccountQuotes($zoho_crm_account_id, $page_token);
    }

    public static function quotesSearch($phrase, $criteria = null)
    {
        return ZohoQuoteController::search($phrase, $criteria);
    }

    // end - Quote functions

    // start - settings functions

    public static function getRoles()
    {
        return ZohoRoleController::getAll();
    }
    // end - settings functions

}
