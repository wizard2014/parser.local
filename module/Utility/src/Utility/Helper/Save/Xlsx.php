<?php

namespace Utility\Helper\Save;

use ZipArchive;
use RecursiveIteratorIterator;
use RecursiveDirectoryIterator;

class Xlsx
{
    /**
     * Content type for Excel (xlsx)
     */
    const CONTENT_TYPE    = 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet';
    const FILE_EXTENSION  = '.xlsx';


    public static function get($path, $addedData)
    {
        $rootPath = realpath('./data/pattern/ebay');

        // Initialize archive object
        $zip = new ZipArchive();
        $zip->open($tempfile = tempnam(sys_get_temp_dir(), 'xlsx_'), ZipArchive::CREATE);

        $files = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($rootPath)
        );

        foreach ($files as $name => $file) {
            // skip directories (they would be added automatically)
            if (!$file->isDir()) {
                // get real and relative path for current file
                $filePath     = $file->getRealPath();
                $relativePath = substr($filePath, strlen($rootPath) + 1);

                // add current file to archive
                $zip->addFile($filePath, $relativePath);
            }
        }

        // create archive
        $zip->close();

        $data = [
            'contentType'   => self::CONTENT_TYPE,
            'fileExtension' => self::FILE_EXTENSION,
            'contentLength' => filesize($tempfile),
            'fileData'      => file_get_contents($tempfile),
        ];

        unlink($tempfile);

        return $data;
    }
}
