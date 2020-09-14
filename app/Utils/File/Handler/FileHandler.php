<?php

namespace App\Utils\File\Handler;


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
     * Directory getter
     */

     //return root dir where is all utils features
     // 'app\Utils'
     public static function getUtilsDir(...$subDirs)
     {
        $path = app_path('Utils'.DIRECTORY_SEPARATOR.join(DIRECTORY_SEPARATOR,$subDirs));
        return $path;
    }

    //return 'app\Utils\File'
    public static function getUtilsFileDir()
    {
        $path = self::getUtilsDir('File');
        return $path;
    }

    //return 'app\Utils\File\Core'
    public static function getUtilsFileCoreDir()
    {
        $path = self::getUtilsFileDir().DIRECTORY_SEPARATOR.'Core';
        return $path;
    }

    //return 'app\Utils\File\Types'
    public static function getUtilsFileTypeDir()
    {
        $path = self::getUtilsFileDir().DIRECTORY_SEPARATOR.'Types';
        return $path;
    }



    /**
     * Return list of path of every files inside in app/Utils/File/Types
     */
    public static function getFileTypes()
    {
        $path =self::getUtilsFileTypeDir();
        $types = glob($path.DIRECTORY_SEPARATOR.'*.php');
        return $types;
    }

    /**
     * Fixers
     */

    //  //Return fixed path(namespace) , it mean: from App/
     public static function fixPath($path)
     {
        $splitedPathByApp = explode(DIRECTORY_SEPARATOR.'app'.DIRECTORY_SEPARATOR,$path);

        $fixedNameSpace = 'App'.DIRECTORY_SEPARATOR.$splitedPathByApp[1];
        $fixedNameSpace = str_replace('.php','',$fixedNameSpace);

        $className =str_replace('.php','',explode(DIRECTORY_SEPARATOR,$fixedNameSpace)[sizeof(explode(DIRECTORY_SEPARATOR,$fixedNameSpace))-1]);

        $result['nameSpace'] = '\\'.str_replace(DIRECTORY_SEPARATOR,'\\',$fixedNameSpace);//here im doing replace because of not found class eror in Linux envs
        $result['className'] = $className;

        return $result;
     }

     //Return fixed path(namespace) by an array
     //
    //  public static function fixPathList($pathArray)
    //  {
    //     $fixedPathArray = array();
    //     foreach ($pathArray  as $path) {
    //         $fixedPath =  self::fixPath($path);
    //         if (in_array($fixedPath['path'],$fixedPathArray)) {
    //           array_push($fixedPathArray,$fixedPath['className']);
    //         }
    //         else{
    //          array_push($fixedPathArray,$fixedPath['path']);
    //         }
    //       }

    //     return $fixedPathArray;
    // }

    /**
     * Finders
     */

    public static function findClass($extension)
    {

        $fileTypes = self::getFileTypes();
        $index = 0;
        $max = sizeof($fileTypes)-1;
        $foundClass = null;

        $imports  = array();

        $result = array();

        while ($foundClass === null or $index <=$max) {


            $class = $fileTypes[$index];
            $fixedClass  =self::fixPath($class);
            // dd($fixedClass);
            //if namespace exist
            if (in_array($fixedClass['nameSpace'],$imports)) {
                $initClass = new $fixedClass['className'](null,null,$extension);
            }
            //if namespace not exist
            else{
                array_push($imports,$fixedClass['nameSpace']);
                $initClass = new $fixedClass['nameSpace'](null,null,$extension);
            }
// dd($imports);
            // array_push($result,$initClass);

            // if ($initClass->isThisType()) {
            //     // $foundClass = $initClass;
            //     // $tokenWay = $fixedClass[$fixPathRresultIndex];
            //     array_push($result,$initClass);
            // }

            $index++;
        }


        // $result['foundClass'] = $foundClass;
        // $result['way'] = $tokenWay;

        dd($result,123);
        return $result;

    }

}
