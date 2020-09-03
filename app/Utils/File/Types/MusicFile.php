<?php

namespace App\Utils\File\Types;

use App\Utils\File\Core\PrototypeFile;

/**
 */

class MusicFile extends PrototypeFile
{
    //required attributes
    private static $RDN = 'musicas';
    private static $allowedExtensions = [
        'mp3',
        'mp4',
        'wma',
    ];


    public function __construct($file = null,$fileName = null,$extension = null) {
        parent::__construct(self::$RDN,$file,$fileName,$extension,self::$allowedExtensions);
    }

    /**
     * Specifics functions for this type of file.
     */


}
