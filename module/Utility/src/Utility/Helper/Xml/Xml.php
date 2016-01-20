<?php

namespace Utility\Helper\Xml;

use SimpleXMLElement;
use ZipArchive;
use RecursiveIteratorIterator;
use RecursiveDirectoryIterator;

class Xml
{
    /**
     * Content type for XML
     */
    const XML_CONTENT_TYPE   = 'text/xml';
    const XML_FILE_EXTENSION = '.xml';

    /**
     * Content type for Excel (xlsx)
     */
    const EXCEL_CONTENT_TYPE    = 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet';
    const EXCEL_FILE_EXTENSION  = '.xlsx';

    /**
     * @var string 'base file path'
     */
    private static $basePath = './data/output/';

    /**
     * @param $data
     * @param $path
     * @param $filename
     *
     * @return bool
     */
    public static function saveAsXml($data, $path, $filename)
    {
        $xml = new SimpleXMLElement('<?xml version="1.0"?><data></data>');
        self::arrayToXml($data, $xml);

        // directory exists
        if (!file_exists(self::$basePath . $path)) {
            mkdir(self::$basePath . $path, 0777, true);
        }

        try {
            return $xml->asXML(self::$basePath . $path . '/' . $filename . '.xml');
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * @param $path
     *
     * @return bool|string
     */
    public static function getAsXml($path)
    {
        $filePath = self::$basePath . $path . '.xml';

        if (!is_file($filePath)) {
            return false;
        }

        return [
            'contentType'   => self::XML_CONTENT_TYPE,
            'fileExtension' => self::XML_FILE_EXTENSION,
            'contentLength' => filesize($filePath),
            'fileData'      => self::getFileData($filePath),
        ];
    }

    public static function getAsXlsx($path)
    {
        $rootPath = realpath('./data/pattern/ebay');

        // Initialize archive object
        $zip = new ZipArchive();
        $zip->open($tempfile = tempnam(sys_get_temp_dir(), 'xlsx_'), ZipArchive::CREATE);

        $files = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($rootPath),
            RecursiveIteratorIterator::LEAVES_ONLY
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
            'contentType'   => self::EXCEL_CONTENT_TYPE,
            'fileExtension' => self::EXCEL_FILE_EXTENSION,
            'contentLength' => filesize($tempfile),
            'fileData'      => file_get_contents($tempfile),
        ];

        unlink($tempfile);

        return $data;
    }

    /**
     * @param            $data
     * @param            $xmlData
     * @param bool|false $numItems
     */
    protected static function arrayToXml($data, &$xmlData, $numItems = false)
    {
        foreach ($data as $key => $value) {
            if (is_array($value)) {
                if ($numItems) {
                    if (is_numeric($key)) {
                        $key = 'item' . $key; // dealing with <0/>..<n/> issues
                    }
                } else {
                    $key = 'item';
                }

                $subnode = $xmlData->addChild($key);

                self::arrayToXml($value, $subnode, $numItems);
            } else {
                $xmlData->addChild("$key", htmlspecialchars("$value"));
            }
        }
    }

    /**
     * @param $filePath
     *
     * @return string
     */
    protected static function getFileData($filePath)
    {
        return file_get_contents($filePath);
    }
}
