<?php

namespace App\Utils\File\Handler;

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

    public static function discoverClass($file)
    {
        $fileTypesList = self::getFileTypesList();
        $class = null;
        $index = 0;
        $maxIndex = sizeof($fileTypesList);
        $extension = $file->extension();
        $fileName = $file->getClientOriginalName();

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
        $class = self::discoverClass($file);

        if ($fileName === null) {
            $fileName = $file->getClientOriginalName();
        }

        $result = false;

        if ($class != null) {
            $result = $class->storeBin($user);
        }

        return $result;
    }


}
