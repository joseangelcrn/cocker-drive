<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Fichero extends Model
{
    //
    protected $table = "ficheros";
    protected $fillable = ['nombre_real,nombre_hash,suser_id'];

    /**
     * Relaciones
     */

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Funciones
     */

     public function crearBin(File $file)
     {

     }

     public function crearData($nombreReal,$nombreHash,$userId)
     {
         
     }

}
