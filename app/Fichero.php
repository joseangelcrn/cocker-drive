<?php

namespace App;

use App\Traits\FileBinManager;
use App\Traits\FileInfoManager;
use App\Traits\ImageFile;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use ZipArchive;

class Fichero extends Model
{


    //
    protected $table = "ficheros";
    protected $fillable = ['nombre_real','nombre_hash','user_id','extension','size','width','height','active'];

    // // private static  $extensions = [
    // //     'img'=>[
    // //         'jpg',
    // //         'jpeg',
    // //         'png',
    // //         'gif',
    // //         'webp',
    // //         'tiff',
    // //         'psd',
    // //         'raw',
    // //         'bmp',
    // //         'heif',
    // //         'indd'
    // //     ]
    // // ];
    // // private const PREFIX_DOWNLOADED_FILE = 'cocker-drive';

    // // public static  $DIR_FICHEROS = '/ficheros';



    // /**
    //  * Relations
    //  */

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function logs()
    {
        return $this->hasMany(Log::class,'file_id');
    }

    // /**
    //  * Functions
    //  */

    //  /**
    //   * Return the default disk we are going to use, in this case: public disk
    //   */

    //  public static function defaultDisk()
    //  {
    //     return Storage::disk('public');
    //  }

     /**
      * Enable data (database level)
      */
      public function enable()
      {
        $disabled =   $this->update([
            'active' => true
        ]);
        return $disabled;
      }
      /**
       * Enable data (database level)
       */
      public function disable()
      {
        $disabled =   $this->update([
            'active' => false
        ]);
        return $disabled;
      }

    //  /**
    //   * Returns total used disk space from a directory (MB).
    //   * File searching level !! (Not used right now)

    //   XXXXXXXXXXX
    //   */
    // //   public static function getEspacioUsado($rootDir = '')
    // //   {
    // //     $path = public_path('storage\\ficheros\\'.$rootDir);

    // //     $infoFile = array();

    // //     if (file_exists($path)) {

    // //         foreach( File::allFiles($path) as $file)
    // //         {
    // //             //parsed file size to MB
    // //             $fileSize = number_format($file->getSize()/1048576,2);
    // //             $fileExtension = $file->getExtension();

    // //             //sum all filesize
    // //             if (!isset($infoFile['total'])) {
    // //                 $infoFile['total'] = $fileSize;
    // //             } else {
    // //                 $infoFile['total'] += $fileSize;
    // //             }

    // //             //grouping size by file extension

    // //             if (!isset($infoFile['ext'][$fileExtension])) {
    // //                 $infoFile['ext'][$fileExtension] = $fileSize;
    // //             } else {
    // //                 $infoFile['ext'][$fileExtension] += $fileSize;
    // //             }

    // //         }

    // //     }

    // //     return $infoFile;
    // //   }



    //   /**
    //    * Parse bytes to MB
    //    XXXXXXXXXXXXXXXXXXX
    //    */

    // // public static function parseToMB($bytesAmount)
    // // {
    // //     return $bytesAmount/1048576;
    // // }

    // /**
    // * Check if file is image
    // xxxxxxxxx
    // */

    // // public static function isImage($extension)
    // // {
    // //     return in_array($extension,self::$extensions['img']);
    // // }

    // /**
    //  * Function to get files with specifics parameters(extension,size,width,height...) which was selected
    //  * by user on file searcher view.
    //  */

    public static function applyFilters($preSearching,$filters)
    {
        $extensionsFilter = $filters->extensions;
        $sortFilter = $filters->sort;
        $widthHeight = $filters->widthHeight;

        if (sizeof($extensionsFilter) > 0) {

        }

        //width - height
        // $widthHeigt->width != '' ? $preSearching->where('width',$widthHeigt->width) : null;
        // $widthHeigt->height != '' ? $preSearching->where('height',$widthHeigt->height) : null;

        if ($widthHeight->width != '') {
            $minAllowedWidth = self::getMinSearchingRangeValue($widthHeight->width);
            $preSearching->whereBetween('width',[$minAllowedWidth,$widthHeight->width]);
        }
        if ($widthHeight->height != '') {
            $minAllowedHeight  = self::getMinSearchingRangeValue($widthHeight->height);
            $preSearching->whereBetween('height',[$minAllowedHeight,$widthHeight->height]);
        }

        //order conditions must be last one
        $sortFilter->field != '' ? $preSearching->orderBy($sortFilter->field,$sortFilter->type) : null;


        return $preSearching;
    }

    // /**
    //  * return minimal searching range value allowed to find file by 'width' value
    //  */
    public static function getMinSearchingRangeValue($value)
    {

        switch ($value) {
                case 144:
                    $minAllowedValue = 0;
                    break;
                case 240:
                    $minAllowedValue = 144.001;
                    break;
                case 360:
                    $minAllowedValue = 240.001;
                    break;
                case 480:
                    $minAllowedValue = 360.001;
                    break;
                case 720:
                    $minAllowedValue = 480.001;
                    break;
                case 1080:
                    $minAllowedValue = 720.001;
                break;
                case 1920:
                    $minAllowedValue = 1080.001;
                    break;
                default:
                    $minAllowedValue = 0;
                break;
        }

        return $minAllowedValue;
    }


    // /**
    //  * Return filename (and its extension) from path
    //  XXXXXXXXXXXXXXXXXX
    //  */
    // public static  function getNombreFicheroByPath($path)
    // {
    //     return substr($path, strrpos($path, '/') + 1);
    // }

    // /**
    //  * Compress all files by user and return path of zip file which contains his/her files.
    //  XXXXXXXXXXXXXXXXXXX
    //  */
    // public static function compressAllFilesByUser(User $user)
    // {

    //     $pathUserFiles = public_path('storage\\ficheros\\'.$user->getRootDir());
    //     $path = null;

    //     //first check if exist path
    //     if (file_exists($pathUserFiles)) {
    //         //creating zip
    //         $zip = new ZipArchive;
    //         $ddMmYyyyToday = Carbon::now()->format('d-m-Y');

    //         $fileName = self::PREFIX_DOWNLOADED_FILE.'_mis_archivos_'.Seguridad::uniqueId().'_'.$ddMmYyyyToday.'.zip';

    //         if ( $zip->open(public_path('storage\\temp\\'.$fileName), ZipArchive::CREATE) === TRUE)
    //         {

    //             $files = File::files($pathUserFiles);

    //             foreach ($files as $key => $value) {
    //                 $relativeNameInZipFile = basename($value);
    //                 $dbDataFile = Fichero::select('nombre_hash','nombre_real','extension')->where('nombre_hash',$relativeNameInZipFile)->where('user_id',$user->id)->first();
    //                 $realFileName = $dbDataFile->nombre_real;
    //                 $realExtensionFile = $dbDataFile->extension;

    //                 $fullRealName = $realFileName.".".$realExtensionFile;
    //                 $zip->addFile($value, $fullRealName);
    //             }

    //             $zip->close();
    //             $path = public_path('storage\\temp\\'.$fileName);
    //             // return response()->download(public_path('storage\\temp\\'.$fileName));

    //         }
    //     }

    //     return $path;

    // }

    //  /**
    //   * Create bin of file in default disk
    //   XXXXXXXXXXXXXXXX
    //   */
    //  public static function crearBin($fichero,$hashRootDir)
    //  {
    //     $nombreReal = $fichero->getClientOriginalName();
    //     $extension = $fichero->extension();
    //     $size = $fichero->getSize();//in Bytes
    //     $width = 0;
    //     $height = 0;

    //     $path = self::defaultDisk()->put(self::$DIR_FICHEROS.'/'.$hashRootDir.'/',$fichero);
    //     $nombreHash = self::getNombreFicheroByPath($path);

    //     //if is an image file I will save its width/height
    //     if (self::isImage($extension)) {
    //         $widthHeight = getimagesize($fichero);
    //         $width = $widthHeight[0];
    //         $height = $widthHeight[1];
    //     }

    //     $resultado = array(
    //         'nombre_hash'=> $nombreHash,
    //         'nombre_real'=> $nombreReal,
    //         'extension'=>$extension,
    //         'size'=>$size, //MB
    //         'width'=>$width,
    //         'height'=>$height,

    //     );

    //     return $resultado;
    //  }

    //  /**
    //   * Store info of file on the  database
    //   */

    //  public static function storeData($nombreReal,$nombreHash,$extension,$size,$width,$height,$userId)
    //  {
    //     $nuevoFichero = self::create(
    //         [
    //         'nombre_real'=>$nombreReal,
    //         'nombre_hash'=>$nombreHash,
    //         'extension'=>$extension,
    //         'size'=>$size,
    //         'width'=>$width,
    //         'height'=>$height,
    //         'user_id'=>$userId,
    //         ]

    //     );

    //     return $nuevoFichero;
    //  }

    //  /**
    //   * General function to upload files, store bin in storage and data in database.
    //   * Without errors checks.
    //   */

    //  public static function guardar($fichero,$user)
    //  {
    //     $resultado = false;
    //     $resultBin = self::crearBin($fichero,$user->hash_root_dir);

    //     $nombreReal = $resultBin['nombre_real'];
    //     $nombreHash = $resultBin['nombre_hash'];
    //     $extension = $resultBin['extension'];
    //     $size = $resultBin['size'];
    //     $width = $resultBin['width'];
    //     $height = $resultBin['height'];

    //     if ($nombreReal != null and $nombreHash != null and $size != null) {
    //         $resultado = self::crearData($nombreReal,$nombreHash,$extension,$size,$width,$height,$user->id);
    //     }

    //     return $resultado;
    //  }

    //  /**
    //   * Save bin and data bd + check. if all files was correctly uploaded will return true.
    //   *
    //   * -- Main function to upload files. --
    //   */


    // public static function fullGuardado($ficheros,User $user)
    // {
    //     $result = array();
    //     $savedFiles = new Collection();
    //     foreach ($ficheros as $fichero) {
    //        $savedFile =  Fichero::guardar($fichero,$user);
    //        $savedFiles->push($savedFile);
    //     }
    //     //if all status are true, every file was successfully uploaded.
    //     // if (count(array_unique($result['files'])) === 1 && end($result['files']) != null) {
    //     //     $result['all_files_saved'] = true;
    //     // }
    //    $someNullItem =  $savedFiles->contains(function($file, $key) {
    //         return (
    //                    $file->id === null &&
    //                    $file->nombre_real === null &&
    //                    $file->nombre_hash === null &&
    //                    $file->extension === null &&
    //                    $file->size === null &&
    //                    $file->active === null &&
    //                 //    $file->width === null &&
    //                 //    $file->height === null &&
    //                    $file->user_id === null

    //                );
    //     });

    //     $result['savedFiles'] = $savedFiles;
    //     $result['someNullItem'] = $someNullItem;

    //     return $result;
    // }

    // /**
    //  * Prepare data to Circle Chart Usage.
    //  *
    //  * Example structure:
    //  * sections: [
    //  *    { label: 'Red section', value: 25 },
    //  *    { label: 'Green section', value: 25},
    //  *    { label: 'Blue section', value: 25}
    //  * ]
    //  * ---------------------------------------
    //  *
    //  * $infoFiles: must be a returned value of function =  getEspacioUsado()
    //  */
    // public static function parseToCircleChart($infoFiles)
    // {
    //     $parsedData = array();
    //     //if not exist this array key mean user still doesnt upload any file, so value is 0.
    //     $totalDiskUsed = isset($infoFiles['total']) ? $infoFiles['total'] : 0;

    //     if (isset($infoFiles['ext'])) {
    //         foreach ($infoFiles['ext'] as $extension=>$size) {

    //             $tempArray = array(
    //                 'label' => $extension,
    //                 // 'value' => floatval(number_format((floatval($size) /number_format($totalDiskUsed,2)) * 100,2))
    //                 'value' => ($size/$totalDiskUsed) * 100
    //             );
    //             array_push($parsedData,$tempArray);
    //         }
    //     }

    //     // dd($parsedData);
    //     return $parsedData;

    // }


    // /**
    //  *  Function to delete bin of storage
    //  */
    // public function deleteBin()
    // {
    //     $rootDir = $this->user->getRootDir();
    //     $pathFile = self::$DIR_FICHEROS.'/'. $rootDir.'/'.$this->nombre_hash;

    //     $deletedFile = self::defaultDisk()->delete($pathFile);


    //     return $deletedFile;
    // }

    // /**
    //  *  Function to delete file data of database
    //  */
    // public function deleteData()
    // {
    //     $disabled = $this->disable();
    //     return $disabled;
    // }


    // /**
    //  * Function to full delete file (bin and data db)
    //  */

    //  public function fullDelete()
    //  {
    //      $result = false;

    //      $deletedBin = $this->deleteBin();

    //      if ($deletedBin) {
    //          $deletedData = $this->deleteData();
    //          if ($deletedData) {
    //             $result = true;
    //          }
    //      }

    //      return $result;
    //  }


    // /**
    //  * Function to update filename (db)
    //  */
    // public function updateFileNameDb($newName)
    // {

    //     $result =  tap($this)->update([
    //         'nombre_real'=> $newName
    //     ]);

    //     return $result;
    // }


    // /**
    //  * Return public path where is saved this file
    //  */

    // public function getPublicPath()
    // {
    //    $path =  public_path('storage\\ficheros\\'.$this->user->getRootDir().'\\'.$this->nombre_hash);
    //    return $path;
    // }

}
