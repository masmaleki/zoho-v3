<?php

namespace Masmaleki\ZohoAllInOne\Http\Controllers\Records;

use Masmaleki\ZohoAllInOne\Models\AllInOneObject;

class ZohoAllInOneObjectController
{

    protected $resultList;


    public function __construct()
    {
        $this->resultList = collect();
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
        dd($this->resultList->take(5));
    }

    public function getUnifiedDuplicates()
    {
        return $this->resultList->duplicates('Product_Name');
    }

    public function getNeighbours($dObject)
    {
        return $this->resultList->where('Product_Name', $dObject->Product_Name)->get();
    }

    public function detectMain($neighbours)
    {
        //main detection process
        $mainObject = new AllInOneObject(); //temporary code line;

        return $mainObject;
    }


    public function doMerge()
    {
        $this->convertListToCollection();
        foreach ($this->getUnifiedDuplicates() as $dObject) {

            $neighbours = $this->getNeighbours($dObject);
            $mainObject = $this->detectMain($neighbours);

        }

    }


}
