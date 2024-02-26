<?php

namespace AliMehraei\ZohoAllInOne\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \AliMehraei\ZohoAllInOne\ZohoAllInOne
 */
class ZohoAllInOne extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \AliMehraei\ZohoAllInOne\ZohoAllInOne::class;
    }
}
