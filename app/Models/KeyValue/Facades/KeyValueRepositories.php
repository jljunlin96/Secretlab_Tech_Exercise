<?php

namespace App\Models\KeyValue\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @mixin \App\Models\KeyValue\Repositories\KeyValueRepositories
 */
class KeyValueRepositories extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \App\Models\KeyValue\Repositories\KeyValueRepositories::class;
    }
}
