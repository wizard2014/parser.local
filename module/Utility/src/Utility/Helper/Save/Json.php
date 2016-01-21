<?php

namespace Utility\Helper\Save;

class Json
{
    /**
     * Content type for XML
     */
    const CONTENT_TYPE   = 'application/json';
    const FILE_EXTENSION = '.json';

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
            'fileData'      => json_encode($data),
        ];
    }
}
