<?php

namespace Masmaleki\ZohoAllInOne\Http\Controllers\Records;

use Illuminate\Support\Facades\Storage;
use Masmaleki\ZohoAllInOne\Models\AllInOneObject;

class ZohoAllInOneObjectController
{

    protected $resultList;
    protected $processedResultList;
    protected $crmProductsThatMustBeDeleted;
    protected $booksItemsThatMustBeDeleted;


    public function __construct()
    {
        $this->resultList = collect();
        $this->processedResultList = collect();
        $this->crmProductsThatMustBeDeleted = [];
        $this->booksItemsThatMustBeDeleted = [];
    }

    public function getJsonList()
    {
        return json_decode(file_get_contents(storage_path() . '/app/public/bulk-read-result/result.json'), true);
    }

    public function convertListToCollection()
    {
        foreach ($this->getJsonList() as $obj) {
            $this->resultList->push(new AllInOneObject($obj));
        }
    }

    public function getUniIdMaxNumber()
    {
        return $this->resultList->max('uni_id');
    }

    public function getNeighbours($uniId, $unmarked = false)
    {
        if ($unmarked)
            return $this->resultList->where('uni_id', '=', $uniId)->where('mark_as_deleted', '=', false);
        return $this->resultList->where('uni_id', '=', $uniId);
    }

    public function processDeletedMarks()
    {
        $markedItems = $this->resultList->where('mark_as_deleted', '=', true);

        foreach ($markedItems as $item) {
            if ($item->books_id) {
                $this->booksItemsThatMustBeDeleted [] = $item->books_id;
            }
            $this->crmProductsThatMustBeDeleted[] = $item->id;
        }
        Storage::put('public/bulk-read-process-result/items-mark-deleted.json', json_encode($this->booksItemsThatMustBeDeleted));
        Storage::put('public/bulk-read-process-result/products-mark-deleted.json', json_encode($this->crmProductsThatMustBeDeleted));

        return true;
    }

    public function setMainAndDeletedMarks($allNeighbours)
    {
        //main detection process
        $main = $allNeighbours->where('books_objects_count', '=', $allNeighbours->max('books_objects_count'))->first();
        $neighbours = $allNeighbours->where('list_id', '!=', $main->list_id);
        // dd($main, $neighbours,$allNeighbours);
        if ($main->books_id == null) {
            $main = $allNeighbours->where('crm_objects_count', '=', $allNeighbours->max('crm_objects_count'))->first();
            $neighbours = $allNeighbours->where('list_id', '!=', $main->list_id);
        }

        $main->is_main = true;
        foreach ($neighbours as $neighbour) {
            if ($neighbour->books_objects_count == 0 && $neighbour->crm_objects_count == 0) {
                $neighbour->mark_as_deleted = true;
            }
            $this->processedResultList->push($neighbour);
        }
        $this->processedResultList->push($main);
        return true;
    }

    public function processNeighboursBatch($allNeighbours)
    {
        //main detection process
        $main = $allNeighbours->where('is_main', '=', true)->first();
        $neighbours = $allNeighbours->where('is_main', '=', false);
        // dd($main, $neighbours,$allNeighbours);
        $allChanges = [];
        foreach ($neighbours as $neighbour) {
            $changes = [];
            $changes['crm_product_changes'] = [];
            $changes['books_product_changes'] = [];

            $changes['crm_product_changes']['product_id'] = null;
            $changes['crm_product_changes']['rfq'] = [];
            $changes['crm_product_changes']['quotes'] = [];
            $changes['crm_product_changes']['availabilities'] = [];

            $changes['books_product_changes']['item_id'] = null;
            $changes['books_product_changes']['invoices'] = [];
            $changes['books_product_changes']['pos'] = [];
            $changes['books_product_changes']['sos'] = [];

            if ($neighbour->crm_objects_count > 0) {
                $changes['crm_product_changes']['product_id'] = $neighbour->id;
                foreach (['rfq', 'quotes', 'availabilities'] as $crmItem) {
                    if ($neighbour->$crmItem['count'] > 0) {
                        foreach ($neighbour->$crmItem['items'] as $item) {
                            $changes['crm_product_changes'][$crmItem] = $item;
                        }
                    }
                }
            }
            if ($neighbour->books_objects_count > 0) {
                $changes['books_product_changes']['item_id'] = $neighbour->books_id;
                foreach (['invoices', 'pos', 'sos'] as $bookItem) {
                    if ($neighbour->$bookItem['count'] > 0) {
                        foreach ($neighbour->$bookItem['items'] as $item) {
                            $changes['books_product_changes'][$bookItem] = $item;
                        }
                    }
                }
            }
            $allChanges[] = $changes;
        }
        $main->changes = $allChanges;
        $this->processedResultList->push($main);
        return true;
    }


    public function doMerge()
    {
        $this->convertListToCollection();
        //dd($this->resultList->where('uni_id', '>', 270)->where('uni_id', '<', 275));
        $uniIdMax = $this->getUniIdMaxNumber();
        for ($i = 1; $i <= $uniIdMax; $i++) {
//            $i = 271;
//            $i = 13;
//            //$i = 398;
            $neighbours = $this->getNeighbours($i);
            $this->setMainAndDeletedMarks($neighbours);
        }
        $this->resultList = $this->processedResultList;
        $this->processedResultList = collect();
        //unset($this->processedResultList);

        $this->processDeletedMarks();


        for ($i = 1; $i <= $uniIdMax; $i++) {
            $neighbours = $this->getNeighbours($i, true);
            $this->processNeighboursBatch($neighbours);
        }
        $this->resultList = $this->processedResultList;
        $this->processedResultList = collect();

        Storage::put('public/bulk-read-process-result/final-process-list.json', json_encode($this->resultList));

        dd($this->resultList);

    }


}
