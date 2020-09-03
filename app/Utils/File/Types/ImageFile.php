<?php

namespace App\Utils\File\Types;

use App\Utils\File\Core\PrototypeFile;

/**
 *
 *
 */

class ImageFile extends PrototypeFile
{
    //required attributes
    private static $RDN = 'imagenes';
    private static $allowedExtensions = [
        'png',
        'jpg',
        'jpeg'
    ];


    public function __construct($file = null,$fileName = null,$extension = null) {
        parent::__construct(self::$RDN,$file,$fileName,$extension,self::$allowedExtensions);
    }

    /**
     * Specifics functions for this type of file.
     */


}
