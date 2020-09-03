<?php

namespace App\Utils\File\Types;

use App\Utils\File\Core\PrototypeFile;

/**
 */

class DocumentFile extends PrototypeFile
{
    //required attributes
    private static $RDN = 'documentos';
    private static $allowedExtensions = [
        'txt',
        'doc',
        'docx',
        'pdf'
    ];


    public function __construct($file = null,$fileName = null,$extension = null) {
        parent::__construct(self::$RDN,$file,$fileName,$extension,self::$allowedExtensions);
    }

    /**
     * Specifics functions for this type of file.
     */


}
