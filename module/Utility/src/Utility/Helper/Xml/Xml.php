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
     */
    public static function saveAsXml($data, $path, $filename)
    {
        $xml = new SimpleXMLElement('<?xml version="1.0"?><data></data>');
        self::arrayToXml($data, $xml);

        // directory exists
        if (!file_exists(self::$basePath . $path)) {
            mkdir(self::$basePath . $path, 0777, true);
        }

        $xml->asXML(self::$basePath . $path . '/' . $filename . '.xml');
    }

    /**
     * @param $data
     * @param $xmlData
     */
    protected static function arrayToXml($data, &$xmlData)
    {
        foreach ($data as $key => $value) {
            if (is_array($value)) {
                if (is_numeric($key)) {
                    $key = 'item' . $key; // dealing with <0/>..<n/> issues
                }

                $subnode = $xmlData->addChild($key);

                self::arrayToXml($value, $subnode);
            } else {
                $xmlData->addChild("$key", htmlspecialchars("$value"));
            }
        }
    }
}
