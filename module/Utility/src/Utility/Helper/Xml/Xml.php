<?php

namespace Utility\Helper\Xml;

use SimpleXMLElement;

class Xml
{
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

        return file_get_contents($filePath);
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
}
