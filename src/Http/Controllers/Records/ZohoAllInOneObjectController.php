<?php

namespace Masmaleki\ZohoAllInOne\Http\Controllers\Records;

use App\Http\Controllers\Controller;
use Masmaleki\ZohoAllInOne\Models\AllInOneObject;

class ZohoAllInOneObjectController extends Controller
{
    public function do_merge(){
        // $objects = exported data csv file
        // $object_model_items = $objects to AllInOneObject::class
        // $duplicated_objects = $this->get_duplicated_object($object_model_items)
        //
        //        $duplicates = AllInOneObject::select('product_name')
        //            ->whereIn('product_name', function ($q){
        //                $q->select('product_name')
        //                    ->from( AllInOneObject::class)
        //                    ->havingRaw('COUNT(*) > 1');
        //            })->get();
    }
    public static function get_duplicated_object($module,$object_zoho_crm_name): array
    {
        $duplicated_objects_arr = [];

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
