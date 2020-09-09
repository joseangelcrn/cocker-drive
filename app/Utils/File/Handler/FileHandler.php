<?php

namespace App\Utils\File\Handler;

use App\Fichero;
use App\Seguridad;
use App\User;
use App\Utils\File\Types\ImageFile;
use Carbon\Carbon;
use Facade\Ignition\Support\ComposerClassMap;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use PhpParser\Builder\Namespace_;
use Symfony\Component\ClassLoader\ClassMapGenerator;
use ZipArchive;


/**
 * This class is which interact with File Model (eloquent)
 *
 */

class FileHandler
{
    private const PREFIX_DOWNLOADED_FILE = 'cocker-drive';

    public function __construct() {
    }

    /**
     * Getters
     */
    //return root dir where is all utils features
    public static function getUtilsDir()
    {
        $path = dirname(dirname(__FILE__));
        return $path;
    }

    //return existing custom types of files classes directory
        public static function getFileTypesList()
        {
            $path =self::getUtilsDir().'/Types';
            $list = glob($path.'/*.php');
            return $list;
        }

        //return simulated full path class as string by import classes.
        //Starting from 'App\' directory.
        public static function fixPath($path)
        {
            // $filePathWithOutExtension = str_replace('.php','',$path);
            $splitedPathByApp = explode('/app',$path);
            $fixedPath = 'App'.$splitedPathByApp[1];
            $fixedPath = str_replace('.php','',$fixedPath);
            $className =str_replace('.php','',explode('/',$fixedPath)[sizeof(explode('/',$fixedPath))-1]);

            $result['path'] = $fixedPath;
            $result['className'] = $className;

            // dd($result);
            return $result;
        }

        //this function work like 'fixPath' but for path array
        // instead of unique path string
        public  static function fixPathList($pathArray)
        {

            $fixedNSArray = array();
            foreach ($pathArray  as $path) {
              $fixedPath =  self::fixPath($path);
              if (in_array($fixedPath['path'],$fixedNSArray)) {
                array_push($fixedNSArray,$fixedPath['className']);
              }
              else{
               array_push($fixedNSArray,$fixedPath['path']);
              }
            }

            return $fixedNSArray;

        }
     /**
      * Functions
      */
      /**
       * This function try to parse $file param in one of Types of files included in App\Utils\File\Type directory.
       * One way to detect which custom file class is.
       *
       * @param $file = must be a File Object
       */

    public static function discoverClassByFile($file)
    {
        $class = null;
        $extension = $file->extension();
        $fileName = $file->getClientOriginalName();

        $class = self::findClassType($extension,$file,$fileName);

        return $class;

    }

    //mechanism to find class
    public static function findClassType($extension,$file = null,$fileName = null)
    {
        $fileTypesList = self::getFileTypesList();

        $class = null;
        $index = 0;
        $maxIndex = sizeof($fileTypesList);

        while ($class === null and $index <= ($maxIndex-1)) {
            $path = $fileTypesList[$index];

            $fixedPath = self::fixPath($path);

            $fixedClass = new $fixedPath['className']($file,$fileName,$extension);

            if ($fixedClass->isThisType()) {
                $class = $fixedClass;
            }

            $index++;
        }
        return $class;
    }

    /**
     * Store current file on current user directory
     */

    public static function store($file,User $user,$fileName = null)
    {
        $class = self::discoverClassByFile($file);

        if ($fileName === null) {
            $fileName = $file->getClientOriginalName();
        }

        $result = false;

        if ($class != null) {
            $result = $class->storeBin($user);
        }

        return $result;
    }

    /**
     * Function to delete file from storage
     */

    public static function delete(Fichero $file)
    {
        $hashedName = $file->nombre_hash;
        $extension = $file->extension;
        $user = $file->user;

        $class = self::findClassType($extension);
        $prototypeClass = new $class();
        $deletedFile = $prototypeClass->deleteBin($user,$hashedName);

        return $deletedFile;
    }

    /**
     * Return string path to show in any view
     */

     private static function getPath(Fichero $file)
     {
        $class = self::findClassType($file->extension);
        $typeClass = new $class();
        $path = $typeClass->getPublicPathOfFile($file);
        return $path;
    }

    /**
     * This function is used to display file in browser by it  stringfy path
     */
    public static function getPublicPath(Fichero $file)
    {
        $path = self::getPath($file);
        return public_path($path);
    }


    public static function parseToMB($bytesAmount)
    {
        return $bytesAmount/1048576;
    }

    /**
    * Returns total used disk space from a directory (MB).
    * DB searching level !! (reworked function)
    */
    public static function getStorageInfoByUser(User $user)
    {
        $files = $user->ficheros()->where('active',1)->get();

        $data = array();


        foreach ($files as $file) {

          $sizeMb = self::parseToMB($file->size);
          $sizeMb = number_format($sizeMb,2);

          //extension
          if (!isset($data['ext'][$file->extension])) {
              $data['ext'][$file->extension] = $sizeMb;
          }
          else{
              $data['ext'][$file->extension] += $sizeMb;
          }


          //total
          if (!isset($data['total'])) {
              $data['total'] = $sizeMb;
          } else {
              $data['total'] += $sizeMb;
          }

        }


        return $data;
    }

    /**
     * Compress all files by user and return path of zip file which contains his/her files.
     */
    public static function compressAndDownloadAllFilesByUser(User $user)
    {
        $files = $user->ficheros;
        $ddMmYyyyToday = Carbon::now()->format('d-m-Y');
        $nameSpaceArray = [];

        $zip = new ZipArchive;
        $zipFilename  = self::PREFIX_DOWNLOADED_FILE.'_my_files_'.Seguridad::uniqueId().'_'.$ddMmYyyyToday.'.zip';


        if ( $zip->open(public_path('storage\\temp\\'.$zipFilename), ZipArchive::CREATE) === TRUE){

            foreach ($files as $file) {

                $hashedName = $file->nombre_hash;
                $realName = $file->nombre_real;
                $extension = $file->extension;

                $class = self::findClassType($extension,null,null,$nameSpaceArray);
                //aqui deberia estar corregido
                //-->
                // dd('compress files',$class);
                // dd($class);
                $typeClass = new $class(null,$hashedName,$extension);
                $userPathOfThisFileType = $typeClass->getUserPath($user->getRootDir());
                $filePath = $userPathOfThisFileType."\\$hashedName";

                $fullRealName = $realName.".".$extension;
                $zip->addFile($filePath, $fullRealName);

            }


            $zip->close();
            $path = public_path('storage\\temp\\'.$zipFilename);

            return response()->download($path);
        }
        //-----------------------------------------------------
        // $pathUserFiles = public_path('storage\\ficheros\\'.$user->getRootDir());
        // $path = null;

        // //first check if exist path
        // if (file_exists($pathUserFiles)) {
        //     //creating zip
        //     $zip = new ZipArchive;
        //     $ddMmYyyyToday = Carbon::now()->format('d-m-Y');

        //     $fileName = self::PREFIX_DOWNLOADED_FILE.'_mis_archivos_'.Seguridad::uniqueId().'_'.$ddMmYyyyToday.'.zip';

        //     if ( $zip->open(public_path('storage\\temp\\'.$fileName), ZipArchive::CREATE) === TRUE)
        //     {

        //         $files = File::files($pathUserFiles);

        //         foreach ($files as $key => $value) {
        //             $relativeNameInZipFile = basename($value);
        //             $dbDataFile = Fichero::select('nombre_hash','nombre_real','extension')->where('nombre_hash',$relativeNameInZipFile)->where('user_id',$user->id)->first();
        //             $realFileName = $dbDataFile->nombre_real;
        //             $realExtensionFile = $dbDataFile->extension;

        //             $fullRealName = $realFileName.".".$realExtensionFile;
        //             $zip->addFile($value, $fullRealName);
        //         }

        //         $zip->close();
        //         $path = public_path('storage\\temp\\'.$fileName);
        //         // return response()->download(public_path('storage\\temp\\'.$fileName));

        //     }
        // }

        // return $path;

    }


}
