<?php

namespace Utility\Helper\Save;

class Csv
{
    /**
     * Content type for CSV
     */
    const CONTENT_TYPE   = 'text/csv';
    const FILE_EXTENSION = '.csv';

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
            'fileData'      => 'data',
        ];
    }
}
