<?php

namespace App\Utils;

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
//    public function __construct($RDN,$file,$fileName,$extension,$allowedExtensions = []) {

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


     public static function getUserPath($rootDirUser)
     {
        $path = self::getParentDir().'\\'.$rootDirUser.'\\'.self::getRDN().'\\';
        return $path;
     }

     /**
      * ----
      * Getters of object
      */

      public function getFile()
      {
        return $this->file;
      }

      public function getFileName()
      {
        return $this->fileName;
      }

      public function getExtension()
      {
        return $this->extension;
      }

     /**
      * CRUD
      */



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
     /**
      * Object util functions
      */
     public  function isThisType()
     {



        // dd(self::getAllowedExtensions());
        if (sizeof(self::getAllowedExtensions()) === 0) {
            $result = true;
        }
        else if (in_array($this->getExtension(),self::getAllowedExtensions())) {
            $result = true;
        }

        return $result;
    }



}
