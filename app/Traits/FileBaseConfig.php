<?php

namespace App\Traits;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

/**
 * Here is all basic configurations about files:
 *
 * Properties and getters about essential part of managing files.
 *
 *
 */

trait FileBaseConfig
{

    private static $filesRootDirectory = 'ficheros';
    private static $downloadPrefix = 'cocker-drive';
    private static  $allowedExtensions = [
        'img' => [
            'jpg',
            'jpeg',
            'png',
            'gif',
            'webp',
            'tiff',
            'psd',
            'raw',
            'bmp',
            'heif',
            'indd'
        ]
    ];


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
     * Getters
     * ##############################
     */

    public static function getFilesRootDirectory()
    {
       return self::$filesRootDirectory;
    }

    public static function getDownloadPrefix()
    {
       return self::$downloadPrefix;
    }

    public static function getAllowedExtensions()
    {
       return self::$allowedExtensions;
    }


}
