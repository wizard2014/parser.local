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
     * @param array  $data
     * @param string $delimiter
     * @param string $enclosure
     *
     * @return array
     */
    public static function get($data = [], $delimiter = ',', $enclosure = '"')
    {
        $fp = fopen('php://temp', 'r+b');

        // set first row
        $firstRow = array_keys($data[0]);
        $out = self::insertRow($fp, $firstRow, $delimiter, $enclosure);

        foreach ($data as $fields) {
            $out = self::insertRow($fp, $fields, $delimiter, $enclosure);
        }

        fclose($fp);

        return [
            'contentType'   => self::CONTENT_TYPE,
            'fileExtension' => self::FILE_EXTENSION,
            'fileData'      => $out,
        ];
    }

    /**
     * @param $fp
     * @param $data
     * @param $delimiter
     * @param $enclosure
     *
     * @return string
     */
    protected static function insertRow($fp, $data, $delimiter, $enclosure)
    {
        fputcsv($fp, $data, $delimiter, $enclosure);
        rewind($fp);

        return rtrim(stream_get_contents($fp), "\n");
    }
}
