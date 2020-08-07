<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class Fichero extends Model
{
    //
    protected $table = "ficheros";
    protected $fillable = ['nombre_real','nombre_hash','user_id','extension'];

    public static  $DIR_FICHEROS = '/ficheros';

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

     /**
      * retorna el disco por defecto que vamos a usar, en este caso el
      * disco publico.
      */

     public static function defaultDisk()
     {
        return Storage::disk('public');
     }

    /**
     * Te devuelv e nombre del fichero (y su extension) a partir del path
     */
    public static  function getNombreFicheroByPath($path)
    {
        return substr($path, strrpos($path, '/') + 1);
    }
     /**
      * Crea el binario del fichero en el disco por defecto
      */
     public static function crearBin($fichero)
     {
        $nombreReal = $fichero->getClientOriginalName();
        $extension = $fichero->extension();
        $fullNombreReal = $nombreReal.'.'.$extension;

        $path = self::defaultDisk()->put(self::$DIR_FICHEROS,$fichero);

        $nombreHash = self::getNombreFicheroByPath($path);

        $resultado = array(
            'nombre_hash'=> $nombreHash,
            'nombre_real'=> $fullNombreReal,
            'extension'=>$extension
        );

        return $resultado;
     }

     /**
      * Guarda la info en la base de datos
      */

     public static function crearData($nombreReal,$nombreHash,$extension,$userId)
     {
        $resultado = Fichero::create(
            [
            'nombre_real'=>$nombreReal,
            'nombre_hash'=>$nombreHash,
            'extension'=>$extension,
            'user_id'=>$userId
            ]

        );

        return $resultado;
     }


}
