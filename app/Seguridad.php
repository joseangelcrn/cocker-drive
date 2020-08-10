<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Seguridad extends Model
{
    //return a 'n' digit hash (default n = 9)
    public static function uniqueId($limit = 9)
    {
        return str_replace('/','',substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, $limit)); ;
    }
}
