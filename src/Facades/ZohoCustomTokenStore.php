<?php

namespace Masmaleki\ZohoAllInOne\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Masmaleki\ZohoAllInOne\ZohoCustomTokenStore
 */
class ZohoCustomTokenStore extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Masmaleki\ZohoAllInOne\ZohoCustomTokenStore::class;
    }
}
