<?php

namespace App\Utils\File\Types;

use App\Utils\File\Core\PrototypeFile;

/**
 */

class MusicFile extends PrototypeFile
{
    //required attributes
    private static $RDN = 'videos';
    private static $allowedExtensions = [
        'avi',
        'mp4',
        'wma',
    ];


    public function __construct($file = null,$fileName = null,$extension = null) {
        parent::__construct(self::$RDN,$file,$fileName,$extension,self::$allowedExtensions);
    }
    public function __destruct()
    {
        parent::__destruct();
    }


    /**
     * Specifics functions for this type of file.
     */


}
