<?php

namespace Masmaleki\ZohoAllInOne\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AllInOneObject extends Model
{
    protected $guarded = [];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->is_main = false;
        $this->mark_as_deleted = false;

        $this->crm_objects_count = 0;
        $this->books_objects_count = 0;

        //$this->processes = false;

        foreach (['rfq', 'quotes', 'availabilities'] as $crmItem) {
            $this->crm_objects_count += $this->$crmItem['count'];
        }
        if ($this->books_id) {
            foreach (['invoices', 'pos', 'sos'] as $bookItem) {
                $this->books_objects_count += $this->$bookItem['count'];
            }
        }
    }

}
