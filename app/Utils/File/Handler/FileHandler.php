<?php

namespace App\Utils\File\Handler;

use App\Fichero;
use App\User;
use App\Utils\File\Types\ImageFile;
use Facade\Ignition\Support\ComposerClassMap;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\File;
use Symfony\Component\ClassLoader\ClassMapGenerator;


/**
 * This class is which interact with File Model (eloquent)
 *
 */

class FileHandler
{

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
        private static function getFileTypesList()
        {
            $path =self::getUtilsDir().'\\Types';
            $list = glob($path.'\\*.php');
            return $list;
        }

        //return simulated full path class as string by import classes.
        //Starting from 'App\' directory.
        private static function fixPath($path)
        {
            $filePathWithOutExtension = str_replace('.php','',$path);
            $splitedPathByApp = explode('\\app',$filePathWithOutExtension);
            $fixedPath = 'App'.$splitedPathByApp[1];

            return $fixedPath;
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
        $fileTypesList = self::getFileTypesList();
        $class = null;
        $extension = $file->extension();
        $fileName = $file->getClientOriginalName();

        $class = self::findClassType($extension,$file,$fileName);
        // while ($class === null and $index <= ($maxIndex-1)) {
        //     $path = $fileTypesList[$index];
        //     $fixedPath = self::fixPath($path);
        //     $fixedClass = new $fixedPath($file,$fileName,$extension);

        //     if ($fixedClass->isThisType()) {
        //         $class = $fixedClass;
        //     }

        //     $index++;
        // }

        return $class;

    }

    //mechanic to find class
    public static function findClassType($extension,$file = null,$fileName = null)
    {
        $fileTypesList = self::getFileTypesList();

        $class = null;
        $index = 0;
        $maxIndex = sizeof($fileTypesList);


        while ($class === null and $index <= ($maxIndex-1)) {
            $path = $fileTypesList[$index];
            $fixedPath = self::fixPath($path);
            $fixedClass = new $fixedPath($file,$fileName,$extension);
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
     * Return string path to show in any view
     */

     public static function getPath(Fichero $file)
     {
        $class = self::findClassType($file->extension);
        $typeClass = new $class();
        $path = $typeClass->getPublicPathOfFile($file);
        return $path;
    }

    public static function getPublicPath(Fichero $file)
    {
        $path = self::getPath($file);
        return public_path($path);
    }

}
