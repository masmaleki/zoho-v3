<?php

namespace Masmaleki\ZohoAllInOne\Http\Controllers\Records;

use App\Http\Controllers\Controller;
use Masmaleki\ZohoAllInOne\Models\AllInOneObject;

class ZohoAllInOneObjectController extends Controller
{
    public function do_merge(){
        $result = json_decode(file_get_contents(storage_path() . '/app/public/bulk-read-result/result.json'), true);
        $object_model_items = collect() ;
        foreach ($result as $obj) {
            $object = new AllInOneObject;
            $object->Zoho_ID  =  $obj['Zoho_ID'];
            $object->Zoho_Books_ID =  $obj['Zoho_Books_ID'];
            $object->Product_Name =  $obj['Product_Name'];
            $object->Owner =  $obj['Owner'];
            $object->Created_By = $obj['Created_By'];
            $object->Modified_By =  $obj['Modified_By'];
            $object->RFQs =  $obj['RFQs'];
            $object->Quotes = $obj['Quotes'];
            $object->AVAs =  $obj['AVAs'];
            $object->Invoices =  $obj['Invoices'];
            $object->POs  =  $obj['POs'];
            $object->SOs  =  $obj['SOs'];
            $object_model_items->push($object);
        }

         $duplicated_objects =  $object_model_items->duplicates('Product_Name');
        foreach ($duplicated_objects as $d_object){
            $all_product_duplicates = $object_model_items->where('Product_Name',$d_object->Product_Name)->get();
            // step 1 = get main product
            $main_product = $this->detect_main_object($all_product_duplicates);
            foreach ($all_product_duplicates as $item){

            }
        }
         //$duplicated_objects = $this->get_duplicated_object($object_model_items);
        //        $duplicates = $object_model_items::select('Product_Name')
        //            ->whereIn('Product_Name', function ($q){
        //                $q->select('Product_Name')
        //                    ->from($object_model_items)
        //                    ->havingRaw('COUNT(*) > 1');
        //            })->get();
    }

    public static function get_duplicated_object($module,$duplicated_objects): array
    {
        $duplicated_objects_arr = [];
        $duplicates = $object_model_items::select('Product_Name')
                    ->whereIn('Product_Name', function ($q){
                        $q->select('Product_Name')
                            ->from($object_model_items)
                            ->havingRaw('COUNT(*) > 1');
                    })->get();
        return $duplicated_objects_arr;
    }

    public static function detect_main_object($duplicated_objects_arr): array
    {
        $main_object_zoho = [
            'zoho_books_id' => 0,
            'zoho_crm_id' => 0,
            'name' => 0,
        ];
        return $main_object_zoho;
    }


}
