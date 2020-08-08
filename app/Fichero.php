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
     * Te devuelve nombre del fichero (y su extension) a partir del path
     */
    public static  function getNombreFicheroByPath($path)
    {
        return substr($path, strrpos($path, '/') + 1);
    }
     /**
      * Crea el binario del fichero en el disco por defecto
      */
     public static function crearBin($fichero,$hashRootDir)
     {
        $nombreReal = $fichero->getClientOriginalName();
        $extension = $fichero->extension();
        $fullNombreReal = $nombreReal.'.'.$extension;

        $path = self::defaultDisk()->put(self::$DIR_FICHEROS.'/'.$hashRootDir.'/',$fichero);

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
        $nuevoFichero = Fichero::create(
            [
            'nombre_real'=>$nombreReal,
            'nombre_hash'=>$nombreHash,
            'extension'=>$extension,
            'user_id'=>$userId
            ]

        );

        return $nuevoFichero != null ? true : false;
     }

     /**
      * Funcion general para subir un fichero guardarlo en el storage y en bd
      */

     public static function guardar($fichero,$user)
     {
        $resultado = false;
        $resultBin = self::crearBin($fichero,$user->hash_root_dir);

        $nombreReal = $resultBin['nombre_real'];
        $nombreHash = $resultBin['nombre_hash'];
        $extension = $resultBin['extension'];

        if ($nombreReal != null and $nombreHash != null) {
            $resultado = self::crearData($nombreReal,$nombreHash,$extension,$user->id);
        }

        return $resultado;
     }

     /**
      * Guardado en bin y bd + comprobacion de si todos los ficheros se subiron correctamente
      * o no..
      * Esta funcion es la que se usa para guardar.
      */


    public static function fullGuardado($ficheros,User $user)
    {
        $resultado = false;
        $statusFicherosGuardados = array();
        foreach ($ficheros as $fichero) {
           $guardado =  Fichero::guardar($fichero,$user);
           array_push($statusFicherosGuardados,$guardado);
        }
        //si todos los status son true no habra habido ningun problema
        if (count(array_unique($statusFicherosGuardados)) === 1 && end($statusFicherosGuardados) === true) {
            $resultado = true;
        }

        return $resultado;
    }
}
