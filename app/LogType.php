<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LogType extends Model
{
    //
    protected $table = "log_types";
    protected $fillable = ['name'];
    public  $timestamps = false;



    /**
     * Relations
     */

     public function logs()
     {
         return $this->hasMany(Log::class);
     }

     /**
      * Functions
      */

}
