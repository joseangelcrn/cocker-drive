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
     * Relations
     */

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Functions
     */

     /**
      * Return the default disk we are going to use, in this case: public disk
      */

     public static function defaultDisk()
     {
        return Storage::disk('public');
     }

     /**
      * Returns total used disk space from a directory (MB)
      */
      public static function getEspacioUsado($rootDir = '')
      {
        $path = public_path('storage\\ficheros\\'.$rootDir);

        $file_size = 0;

        if (file_exists($path)) {

            foreach( File::allFiles($path) as $file)
            {
                $file_size += $file->getSize();
            }

        }

        return number_format($file_size/1048576,2);
      }


    /**
     * Return filename (and its extension) from path
     */
    public static  function getNombreFicheroByPath($path)
    {
        return substr($path, strrpos($path, '/') + 1);
    }
     /**
      * Create bin of file in default disk
      */
     public static function crearBin($fichero,$hashRootDir)
     {
        $nombreReal = $fichero->getClientOriginalName();
        $extension = $fichero->extension();
        // $fullNombreReal = $nombreReal.'.'.$extension;

        $path = self::defaultDisk()->put(self::$DIR_FICHEROS.'/'.$hashRootDir.'/',$fichero);

        $nombreHash = self::getNombreFicheroByPath($path);

        $resultado = array(
            'nombre_hash'=> $nombreHash,
            'nombre_real'=> $nombreReal,
            'extension'=>$extension
        );

        return $resultado;
     }

     /**
      * Store info of file on the  database
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
      * General function to upload files, store bin in storage and data in database.
      * Without errors checks.
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
      * Save bin and data bd + check if all files was correctly uploaded.
      * Main function to upload files.
      */


    public static function fullGuardado($ficheros,User $user)
    {
        $resultado = false;
        $statusFicherosGuardados = array();
        foreach ($ficheros as $fichero) {
           $guardado =  Fichero::guardar($fichero,$user);
           array_push($statusFicherosGuardados,$guardado);
        }
        //if all status are true, every file was successfully uploaded.
        if (count(array_unique($statusFicherosGuardados)) === 1 && end($statusFicherosGuardados) === true) {
            $resultado = true;
        }

        return $resultado;
    }


    /**
     *  Function to delete bin of storage
     */
    public function deleteBin()
    {
        $rootDir = $this->user->hash_root_dir;
        $pathFile = self::$DIR_FICHEROS.'/'. $rootDir.'/'.$this->nombre_hash;

        $deletedFile = self::defaultDisk()->delete($pathFile);


        return $deletedFile;
    }

    /**
     *  Function to delete file data of database
     */
    public function deleteData()
    {
        return $this->delete();
    }


    /**
     * Function to full delete file (bin and data db)
     */

     public function fullDelete()
     {
         $result = false;

         $deletedBin = $this->deleteBin();

         if ($deletedBin) {
             $deletedData = $this->deleteData();
             if ($deletedData) {
                 $result = true;
             }
         }

         return $result;
     }


    /**
     * Function to update filename (db)
     */
    public function updateFileNameDb($newName)
    {

        $result =  tap($this)->update([
            'nombre_real'=> $newName
        ]);

        return $result;
    }
}
