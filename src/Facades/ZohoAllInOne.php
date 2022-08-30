<?php

namespace Masmaleki\ZohoAllInOne\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Masmaleki\ZohoAllInOne\ZohoAllInOne
 */
class ZohoAllInOne extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Masmaleki\ZohoAllInOne\ZohoAllInOne::class;
    }
}
