<?php

namespace Masmaleki\ZohoAllInOne;

use Masmaleki\ZohoAllInOne\Http\Controllers\Bulk\ZohoBulkReadController;
use Masmaleki\ZohoAllInOne\Http\Controllers\Bulk\ZohoBulkWriteController;
use Masmaleki\ZohoAllInOne\Http\Controllers\Other\ZohoCompositeAPIController;
use Masmaleki\ZohoAllInOne\Http\Controllers\Records\ZohoAvailabilityController;
use Masmaleki\ZohoAllInOne\Http\Controllers\Records\ZohoCallController;
use Masmaleki\ZohoAllInOne\Http\Controllers\Functions\ZohoFunctionApiController;
use Masmaleki\ZohoAllInOne\Http\Controllers\Records\ZohoManufactureController;
use Masmaleki\ZohoAllInOne\Http\Controllers\Records\ZohoPurchaseOrderController;
use Masmaleki\ZohoAllInOne\Http\Controllers\Records\ZohoRecordCountController;
use Masmaleki\ZohoAllInOne\Http\Controllers\Records\ZohoRFQController;
use Masmaleki\ZohoAllInOne\Http\Controllers\Records\ZohoAccountController;
use Masmaleki\ZohoAllInOne\Http\Controllers\Records\ZohoAttachmentController;
use Masmaleki\ZohoAllInOne\Http\Controllers\Records\ZohoContactController;
use Masmaleki\ZohoAllInOne\Http\Controllers\Records\ZohoDealController;
use Masmaleki\ZohoAllInOne\Http\Controllers\Records\ZohoEmailController;
use Masmaleki\ZohoAllInOne\Http\Controllers\Records\ZohoExcessController;
use Masmaleki\ZohoAllInOne\Http\Controllers\Records\ZohoHistoryPOSO;
use Masmaleki\ZohoAllInOne\Http\Controllers\Records\ZohoInvoiceController;
use Masmaleki\ZohoAllInOne\Http\Controllers\Records\ZohoLeadController;
use Masmaleki\ZohoAllInOne\Http\Controllers\Records\ZohoPackageController;
use Masmaleki\ZohoAllInOne\Http\Controllers\Records\ZohoProductController;
use Masmaleki\ZohoAllInOne\Http\Controllers\Records\ZohoQuoteController;
use Masmaleki\ZohoAllInOne\Http\Controllers\Records\ZohoSaleOrderController;
use Masmaleki\ZohoAllInOne\Http\Controllers\Records\ZohoTaskController;
use Masmaleki\ZohoAllInOne\Http\Controllers\Records\ZohoVendorController;
use Masmaleki\ZohoAllInOne\Http\Controllers\Records\ZohoVendorRFQController;
use Masmaleki\ZohoAllInOne\Http\Controllers\Settings\ZohoCrmOrganizationController;
use Masmaleki\ZohoAllInOne\Http\Controllers\Users\ZohoOrganizationController;
use Masmaleki\ZohoAllInOne\Http\Controllers\Settings\ZohoRoleController;
use Masmaleki\ZohoAllInOne\Http\Controllers\Users\ZohoUserController;

class ZohoAllInOne
{

    // start - API functions
    public static function callApiFunction($url)
    {
        return ZohoFunctionApiController::run($url);
    }
    // end - API functions

    // start - general functions
    public static function getModuleCount($moduleName, $type = null, $value = null)
    {
        return ZohoRecordCountController::count($moduleName, $type, $value);
    }

    public static function getModuleCountCOQL($moduleName, $condition = null)
    {
        return ZohoRecordCountController::countCOQL($moduleName, $condition);
    }

    public static function getZBCount($moduleName, $organization_id, $condition = null)
    {
        return ZohoRecordCountController::countZBCOQL($moduleName, $organization_id, $condition);
    }

    public static function compositeAPI($requests)
    {
        return ZohoCompositeAPIController::compositeRequests($requests);
    }
    // end - general functions

    // start - users functions
    public static function getUsers($page_token = null)
    {
        return ZohoUserController::getAll($page_token);
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

    public static function getContactSecond($zoho_contact_id)
    {
        return ZohoContactController::getByIdSecond($zoho_contact_id);
    }

    public static function getContactByEmailAddress($zoho_email)
    {
        return ZohoContactController::getByEmail($zoho_email);
    }

    public static function createContact($data = [])
    {
        return ZohoContactController::create($data);
    }

    public static function updateContact($data = [])
    {
        return ZohoContactController::update($data);
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

    public static function contactsSearch($phrase, $page = 1, $perPage = 200)
    {
        return ZohoContactController::search($phrase, $page, $perPage);
    }

    public static function getContactImage($zoho_contact_id)
    {
        return ZohoContactController::getImage($zoho_contact_id);
    }

    // end - contact functions

    // start - accounts functions
    public static function getAccounts($page_token = null)
    {
        return ZohoAccountController::getAll($page_token);
    }

    public static function getAccountContacts($zoho_crm_account_id)
    {
        return ZohoAccountController::getContacts($zoho_crm_account_id);
    }

    public static function createAccount($data)
    {
        return ZohoAccountController::create($data);
    }

    public static function updateAccount($zoho_crm_account_id, $data)
    {
        return ZohoAccountController::update($zoho_crm_account_id, $data);
    }

    public static function getZohoCrmAccount($zoho_crm_account_id)
    {
        return ZohoAccountController::getZohoCrmAccount($zoho_crm_account_id);
    }

    public static function getZohoBooksAccountByCrmAccountId($zoho_crm_account_id, $organization_id = null)
    {
        return ZohoAccountController::getZohoBooksAccountByCrmAccountId($zoho_crm_account_id, $organization_id);
    }
    // end - accounts functions

    // start - vendors functions
    public static function getVendors($page_token = null, $fields = null)
    {
        return ZohoVendorController::getAll($page_token, $fields);
    }


    public static function getZohoBooksVendorById($zoho_books_vendor_id, $organization_id = null)
    {
        return ZohoVendorController::getZohoBooksVendorById($zoho_books_vendor_id, $organization_id);
    }

    public static function createVendor($data)
    {
        return ZohoVendorController::create($data);
    }

    public static function getVendorImage($zoho_id)
    {
        return ZohoVendorController::getImage($zoho_id);
    }

    public static function updateVendorAvatar($zoho_vendor_id, $filePath, $fileMime, $fileUploadedName)
    {
        return ZohoVendorController::updateAvatar($zoho_vendor_id, $filePath, $fileMime, $fileUploadedName);
    }

    public static function updateVendor($zoho_crm_id, $data)
    {
        return ZohoVendorController::update($zoho_crm_id, $data);
    }

    public static function deleteVendorAvatar($zoho_vendor_id)
    {
        return ZohoVendorController::deleteAvatar($zoho_vendor_id);
    }

    public static function getVendorsZB($organization_id, $page = 1, $condition = '')
    {
        return ZohoVendorController::getAllFromBooks($organization_id, $page, $condition);
    }

    public static function getZohoCrmVendor($zoho_crm_vendor_id)
    {
        return ZohoVendorController::getZohoCrmVendor($zoho_crm_vendor_id);
    }

    public static function vendorsSearch($phrase)
    {
        return ZohoVendorController::search($phrase);
    }

    public static function getZohoBooksVendorByCrmVendorId($zoho_crm_vendor_id, $organization_id = null)
    {
        return ZohoVendorController::getZohoBooksVendorByCrmVendorId($zoho_crm_vendor_id, $organization_id);
    }

    // end - vendors functions

    // start - manufactures functions
    public static function getManufactures($page_token = null)
    {
        return ZohoManufactureController::getAll($page_token);
    }

    public static function getManufacture($zoho_manufacture_id, $fields = null)
    {
        return ZohoManufactureController::getById($zoho_manufacture_id, $fields);
    }

    public static function manufactureSearch($phrase)
    {
        return ZohoManufactureController::search($phrase);
    }

    public static function getManufacturesCOQL($zoho_crm_manufacture_id = null, $offset = 0, $conditions = null, $fields = null)
    {
        return ZohoManufactureController::getCOQL($zoho_crm_manufacture_id, $offset, $conditions, $fields);
    }

    public static function createManufacture($data)
    {
        return ZohoManufactureController::create($data);
    }

    public static function updateManufacture($zoho_crm_manufacture_id, $data)
    {
        return ZohoManufactureController::update($zoho_crm_manufacture_id, $data);
    }

    // end - manufactures functions

    // start - products functions

    public static function getProducts($page_token = null, $fields = null)
    {
        return ZohoProductController::getAll($page_token, $fields);
    }

    public static function getProduct($zoho_product_id, $fields = null)
    {
        return ZohoProductController::getById($zoho_product_id, $fields);
    }

    public static function getItem($zoho_books_item_id, $organization_id = null)
    {
        return ZohoProductController::getItemById($zoho_books_item_id, $organization_id);
    }

    public static function searchItemByName($product_name, $organization_id = null)
    {
        return ZohoProductController::searchItemByName($product_name, $organization_id);
    }

    public static function updateProduct($data = [])
    {
        return ZohoProductController::updateProduct($data);
    }

    public static function createProduct($data)
    {
        return ZohoProductController::create($data);
    }

    public static function updateItem($data = [])
    {
        return ZohoProductController::updateItem($data);
    }

    public static function getProductsCOQL($zoho_crm_product_id = null, $offset = 0, $conditions = null, $fields = null)
    {
        return ZohoProductController::getProductsCOQL($zoho_crm_product_id, $offset, $conditions, $fields);
    }

    public static function productsSearch($phrase)
    {
        return ZohoProductController::search($phrase);
    }

    public static function getProductImage($zoho_product_id)
    {
        return ZohoProductController::getImage($zoho_product_id);
    }

    public function getZohoBooksItem($zoho_books_item_id, $organization_id = null)
    {
        return ZohoProductController::getZohoBooksItem($zoho_books_item_id, $organization_id);
    }

    public function getAllZohoBooksItems($organization_id = null, $page, $conditions)
    {
        return ZohoProductController::getAllZohoBooksItems($organization_id, $page, $conditions);
    }
    // end - product functions

    // start - invoice functions
    public static function getInvoices($organization_id, $page = 1, $condition = '')
    {
        return ZohoInvoiceController::getAll($organization_id, $page, $condition);
    }

    public static function getInvoice($zoho_invoice_id, $organization_id = null)
    {
        return ZohoInvoiceController::getById($zoho_invoice_id, $organization_id);
    }

    public static function getCRMInvoice($zoho_invoice_id)
    {
        return ZohoInvoiceController::getCRMInvoiceById($zoho_invoice_id);
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

    public static function getInvoiceHTML($invoice_id)
    {
        return ZohoInvoiceController::getHTML($invoice_id);
    }

    // end - invoice functions


    // start - packages functions
    public static function getPackages($organization_id, $page = 1, $condition = '')
    {
        return ZohoPackageController::getAll($organization_id, $page, $condition);
    }

    public static function searchPackageByCustomerId($zoho_customer_id, $searchParameter = null, $organization_id = null)
    {
        return ZohoPackageController::searchByCustomerId($zoho_customer_id, $searchParameter, $organization_id);
    }
    // end - packages functions

    // start - deals functions
    public static function createDeal($data)
    {
        return ZohoDealController::create($data);
    }
    // end - deals functions

    // start - leads functions
    public static function createLead($data)
    {
        return ZohoLeadController::create($data);
    }

    public static function getLead($id)
    {
        return ZohoLeadController::getLead($id);
    }

    public static function updateLead($data)
    {
        return ZohoLeadController::update($data);
    }

    public static function getLeadByEmailAddress($zoho_email)
    {
        return ZohoLeadController::getByEmailAddress($zoho_email);
    }

    public static function convertLead($data, $id)
    {
        return ZohoLeadController::convertLead($data, $id);
    }

    public static function conversionOptionsLead($data)
    {
        return ZohoLeadController::conversionOptions($data);
    }


    // end - leads functions

    public static function getSaleOrders($organization_id, $page = 1, $condition = '')
    {
        return ZohoSaleOrderController::getAll($organization_id, $page, $condition);
    }

    public static function getSaleOrder($sale_order_id, $organization_id = null)
    {
        return ZohoSaleOrderController::getById($sale_order_id, $organization_id);
    }

    public static function getCRMSaleOrder($sale_order_id)
    {
        return ZohoSaleOrderController::getCRMSaleOrderById($sale_order_id);
    }

    public static function getSaleOrderByCustomerId($zoho_customer_id, $organization_id = null)
    {
        return ZohoSaleOrderController::getByCustomerId($zoho_customer_id, $organization_id);
    }

    public static function searchSaleOrderByCustomerId($zoho_customer_id, $searchParameter = null, $organization_id = null)
    {
        return ZohoSaleOrderController::searchByCustomerId($zoho_customer_id, $searchParameter, $organization_id);
    }

    public static function getSaleOrderPDF($sale_order_id)
    {
        return ZohoSaleOrderController::getPDF($sale_order_id);
    }

    // end - sales orders functions

    // start - purchase order functions
    public static function getPurchaseOrders($organization_id, $page = 1, $condition = '')
    {
        return ZohoPurchaseOrderController::getAll($organization_id, $page, $condition);
    }

    public static function getPurchaseOrder($purchase_order_id, $organization_id = null)
    {
        return ZohoPurchaseOrderController::getById($purchase_order_id, $organization_id);
    }

    public static function getCRMPurchaseOrder($purchase_order_id)
    {
        return ZohoPurchaseOrderController::getCRMPurchaseOrderById($purchase_order_id);
    }

    public static function getPurchaseOrderByCustomerId($zoho_vendor_id, $organization_id = null)
    {
        return ZohoPurchaseOrderController::getByCustomerId($zoho_vendor_id, $organization_id);
    }

    public static function getPurchaseOrderByItemName($item_name, $organization_id = null)
    {
        return ZohoPurchaseOrderController::getByItemName($item_name, $organization_id);
    }

    public static function searchPurchaseOrderByCustomerId($zoho_vendor_id, $searchParameter = null, $organization_id = null)
    {
        return ZohoPurchaseOrderController::searchByCustomerId($zoho_vendor_id, $searchParameter, $organization_id);
    }

    public static function getPurchaseOrderPDF($sale_order_id)
    {
        return ZohoPurchaseOrderController::getPDF($sale_order_id);
    }

    // end -  purchase order functions


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

    public static function setRFQAlternative($rfq_id, $product_id)
    {
        return ZohoRFQController::setRFQAlternative($rfq_id, $product_id);
    }

    public static function getRFQList($rfq_id, $list)
    {
        return ZohoRFQController::getRFQList($rfq_id, $list);
    }

    public static function getRFQs()
    {
        return ZohoRFQController::getAll();
    }

    public static function updateRFQ($data = [])
    {
        return ZohoRFQController::update($data);
    }

    public static function getAccountRFQs($zoho_crm_account_id, $page_token = null, $fields = null, $next_page = 1, $per_page = 200, $conditions = null)
    {
        return ZohoRFQController::getAccountRFQs($zoho_crm_account_id, $page_token, $fields, $next_page, $per_page, $conditions);
    }

    public static function getAccountRFQsCOQL($zoho_crm_account_id, $offset = 0, $conditions = null, $fields = null)
    {
        return ZohoRFQController::getAccountRFQsCOQL($zoho_crm_account_id, $offset, $conditions, $fields);
    }

    public static function getRFQsCOQL($offset = 0, $conditions = null, $fields = null)
    {
        return ZohoRFQController::getRFQsCOQL($offset, $conditions, $fields);
    }

    public static function rfqsSearch($phrase, $criteria = null)
    {
        return ZohoRFQController::search($phrase, $criteria);
    }

    public static function createRFQ($data)
    {
        return ZohoRFQController::create($data);
    }

    // end - RFQ functions
    // start - Vendor RFQ functions

    public static function getVendorRFQ($vendor_rfq_id)
    {
        return ZohoVendorRFQController::get($vendor_rfq_id);
    }

    public static function getVendorRFQs($vendor_rfq_id)
    {
        return ZohoVendorRFQController::getAll($vendor_rfq_id);
    }

    public static function updateVendorRFQ($data = [])
    {
        return ZohoVendorRFQController::update($data);
    }

    // end - Vendor RFQ functions

    // start - Availability functions

    public static function getAvailability($availability_id)
    {
        return ZohoAvailabilityController::get($availability_id);
    }

    public static function getProductAvailabilities($product_id, $fields = null, $condition = null)
    {
        return ZohoAvailabilityController::getProductAvailabilities($product_id, $fields, $condition);
    }

    public static function getAvailabilities()
    {
        return ZohoAvailabilityController::getAll();
    }

    public static function availabilitySearch($phrase, $criteria = null)
    {
        return ZohoAvailabilityController::search($phrase, $criteria);
    }

    public static function createAvailability($data)
    {
        return ZohoAvailabilityController::create($data);
    }

    public static function updateAvailability($data = [])
    {
        return ZohoAvailabilityController::update($data);
    }
    public static function getAvailabilitiesCOQL($offset = 0, $conditions = null, $fields = null)
    {
        return ZohoAvailabilityController::getAvailabilitiesCOQL($offset, $conditions, $fields);
    }

    // end - Availability functions


    // start - History PO SO functions

    public static function getAllHistory($fields = null, $page_token = null, $conditions = null)
    {
        return ZohoHistoryPOSO::getAll($fields, $page_token, $conditions);
    }

    // end -History PO SO functions


    // start - Quote functions

    public static function getQuote($quote_id)
    {
        return ZohoQuoteController::get($quote_id);
    }

    public static function getQuotes()
    {
        return ZohoQuoteController::getAll();
    }

    public static function getAccountQuotes($zoho_crm_account_id, $page_token = null, $fields = null, $next_page = 1, $per_page = 200, $conditions = null)
    {
        return ZohoQuoteController::getAccountQuotes($zoho_crm_account_id, $page_token, $fields, $next_page, $per_page, $conditions);
    }

    public static function getAccountQuotesCOQL($zoho_crm_account_id, $offset = 0, $conditions = null, $fields = null)
    {
        return ZohoQuoteController::getAccountQuotesCOQL($zoho_crm_account_id, $offset, $conditions, $fields);
    }

    public static function quotesSearch($phrase, $criteria = null)
    {
        return ZohoQuoteController::search($phrase, $criteria);
    }

    public static function updateQuote($data = [])
    {
        return ZohoQuoteController::update($data);
    }

    // end - Quote functions

    // start - tasks functions

    public static function getTasks($page_token = null, $fields = null)
    {
        return ZohoTaskController::getAll($page_token, $fields);
    }

    public static function getTasksCOQL($conditions = null, $offset = 0, $fields = null)
    {
        return ZohoTaskController::getByCOQL($conditions, $offset, $fields);
    }

    public static function getTaskById($id)
    {
        return ZohoTaskController::get($id);
    }

    public static function createTask($data)
    {
        return ZohoTaskController::create($data);
    }

    // end - tasks functions

    // start - calls functions

    public static function getCalls($page_token = null, $fields = null)
    {
        return ZohoCallController::getAll($page_token, $fields);
    }

    public static function getCallsCOQL($conditions = null, $offset = 0, $fields = null)
    {
        return ZohoCallController::getByCOQL($conditions, $offset, $fields);
    }

    public static function getCallById($id)
    {
        return ZohoCallController::get($id);
    }

    public static function createCall($data)
    {
        return ZohoCallController::create($data);
    }

    // end - calls functions

    // start - bulk functions

    public static function uploadBulkFile($organization_id, $filePath)
    {
        return ZohoBulkWriteController::uploadFile($organization_id, $filePath);
    }

    public static function createBulkReadJob($data)
    {
        return ZohoBulkReadController::createJob($data);
    }

    public static function downloadBulkReadResult($download_url)
    {
        return ZohoBulkReadController::downloadResult($download_url);
    }

    public static function saveDuplicatedList($file_name, $data)
    {
        return ZohoBulkReadController::saveDuplicatedList($file_name, $data);
    }


    // end - bulk functions

    // start - settings functions

    public static function getRoles()
    {
        return ZohoRoleController::getAll();
    }

    public static function getOrganization()
    {
        return ZohoCrmOrganizationController::get();
    }
    // end - settings functions

    // start - attachments functions

    public static function uploadAttachment($zoho_module_name, $zoho_record_id, $file_path, $file_mime, $file_uploaded_name)
    {
        return ZohoAttachmentController::upload($zoho_module_name, $zoho_record_id, $file_path, $file_mime, $file_uploaded_name);
    }

    public static function getAttachments($zoho_module_name, $zoho_record_id)
    {
        return ZohoAttachmentController::getAll($zoho_module_name, $zoho_record_id);
    }

    public static function deleteAttachment($zoho_module_name, $zoho_record_id, $zoho_attachment_id)
    {
        return ZohoAttachmentController::delete($zoho_module_name, $zoho_record_id, $zoho_attachment_id);
    }
    // end - attachments functions

    // start - Email functions

    public static function sendEmail($zoho_module_name, $zoho_record_id, $data)
    {
        return ZohoEmailController::send($zoho_module_name, $zoho_record_id, $data);
    }
    // end - Email functions

    // start - Excess functions

    public static function createExcess($data)
    {
        return ZohoExcessController::create($data);
    }

    public static function getExcess($excess_id)
    {
        return ZohoExcessController::get($excess_id);
    }

    public static function getProductExcesses($product_id, $fields = null, $condition = null)
    {
        return ZohoExcessController::getProductExcesses($product_id, $fields, $condition);
    }

    public static function getRecentExcesses($offset = 0, $condition = null, $fields = null)
    {
        return ZohoExcessController::getRecentExcesses($offset, $condition, $fields);
    }

    // end - Excess functions

}
