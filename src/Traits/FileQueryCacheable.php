<?php

namespace Garavel\Traits;

use Rennokki\QueryCache\Traits\QueryCacheable;

trait FileQueryCacheable {

    use QueryCacheable;

    protected function getCacheBaseTags() : array
    {
        return [];
    }
}
