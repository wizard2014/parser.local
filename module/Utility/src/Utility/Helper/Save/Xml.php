<?php

namespace Utility\Helper\Save;

class Xml
{
    /**
     * Content type for XML
     */
    const CONTENT_TYPE   = 'text/xml';
    const FILE_EXTENSION = '.xml';

    /**
     * @param array $data
     *
     * @return array|bool
     */
    public static function get($data = [])
    {
        return [
            'contentType'   => self::CONTENT_TYPE,
            'fileExtension' => self::FILE_EXTENSION,
            'fileData'      => file_get_contents($filePath),
        ];
    }
}
