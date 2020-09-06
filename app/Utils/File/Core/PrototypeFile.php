<?php

namespace App\Utils\File\Core;

use App\Fichero;
use App\User;
use Illuminate\Support\Facades\Storage;

/**
 * Here is all basic configurations about files:
 *
 * Properties and getters about essential part of managing files.
 *
 *
 */

class  PrototypeFile
{

    //static attributes
    //directiry where start everything
    private  static  $parentDir = 'ficheros';
    //R(oot) D(irectory) N(ame)
    private static $RDN;
    //allowed extensions of uploaded files.
    private static  $allowedExtensions;


    //attributes
    private $file;
    private $fileName;
    private $extension;


    public function __construct($RDN,$file,$fileName,$extension,$allowedExtensions = []) {
        self::$RDN = $RDN;
        self::$allowedExtensions = $allowedExtensions;
        $this->file =$file;
        $this->fileName = $fileName;
        $this->extension= $extension;
    }

    public function __destruct()
    {
        // dd('destruyendo prototipo');
    }

    /**##############################
     *  Default disk.
     * ##############################
     */

    public static function getDefaultDisk()
    {
        return self::getPublicDisk();
    }

    /**##############################
     * Avaliabled disks
     * ##############################
     */

    public static function getPublicDisk()
    {
        return Storage::disk('public');
    }

    /**##############################
     * Static Getters
     * ##############################
     */

    public static function getRDN()
    {
       return self::$RDN;
    }

    public static function getParentDir()
     {
        return self::$parentDir;
     }


     public static function getAllowedExtensions()
     {
        return self::$allowedExtensions;
     }

     //return user path related to 'user dir' + 'type file dir'
     public static function getUserPath($rootDirUser)
     {
        $path = self::getParentDir().'\\'.$rootDirUser.'\\'.self::getRDN().'\\';
        return $path;
     }



     /**
      * ----
      * Getters of object
      */

      //return bin file
      public function getFile()
      {
        return $this->file;
      }

      //return custom filename written by user on upload-time
      public function getFileName()
      {
        return $this->fileName;
      }

      //return extension as attribute
      public function getExtension()
      {
        return $this->extension;
      }

     /**
      * CRUD
      */


      //store binary of file in default disk
      public  function storeBin(User $owner)
    {
        $userPath =self::getUserPath($owner->getRootDir());

        $path =self::getDefaultDisk()->put($userPath,$this->getFile());

        if ($path != false) {
            $fileNameHashed = self::getFileNameByPath($path);
            return $fileNameHashed;
        }

        return $path;
    }

    //delete binary file in default disk
    public function deleteBin(User $owner,$hashedFileName)
    {
        $userPath = self::getUserPath($owner->getRootDir());
        $filePath = $userPath.$hashedFileName;
        // dd($filePath);

        $deletedFile = self::getDefaultDisk()->delete($filePath);

        return $deletedFile;
    }

    /**
     * Util functions
     */

     /**
      * Static util functions
      */
    public static function getFileNameByPath($path)
    {
        return substr($path, strrpos($path, '/') + 1);
    }

    public static function getUsedDiskOnByte($userPath = '')
    {
        $path = public_path('storage\\');
        dd($path);
    }


     /**
      * Object util functions
      */
      //return true if $extension param  is in $allowedExtensions array
     public   function isThisType()
     {
        $result = false;

        if (self::getAllowedExtensions()!= null) {
            if (sizeof(self::getAllowedExtensions()) === 0) {
                $result = true;
            }
            else if (in_array($this->getExtension(),self::getAllowedExtensions())) {
                $result = true;
            }
        }

        return $result;
    }



    //return true if exist file on this user directory
    public static function exist(User $user, $hashedFileName)
    {
        $path = self::getUserPath($user->getRootDir()).'\\'.$hashedFileName;
        $exist = self::getDefaultDisk()->exists($path);

        return $exist;
    }

    //this function is used to show file in any view
    public  function getPublicPathOfFile(Fichero $file)
    {
        $userPath =self::getUserPath($file->user->getRootDir()).$file->nombre_hash;
        $publicPath = public_path("storage\\$userPath");
        return $publicPath;
    }
}
