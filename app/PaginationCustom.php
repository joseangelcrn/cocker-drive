<?php

namespace App;

use Illuminate\Database\Eloquent\Collection;

/**
 * This class fix a problem to paginate custom collections because of
 * you cant apply paginate in thoose type of collections.
 */

class PaginationCustom
{
    //

    public static function split($collection, $chunk = 10)
    {
        return $collection->chunk($chunk);
    }
}
