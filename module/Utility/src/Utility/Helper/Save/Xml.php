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
    public static function get($writer, $sheetName, $data = [])
    {
        $array2xml = new $writer();

        $array2xml->setRootName('Workbook');
        $array2xml->setRootAttrs([
            'xmlns'      => 'urn:schemas-microsoft-com:office:spreadsheet',
	        'xmlns:ss'   => 'urn:schemas-microsoft-com:office:spreadsheet',
            'xmlns:x'    => 'urn:schemas-microsoft-com:office:excel',
	        'xmlns:o'    => 'urn:schemas-microsoft-com:office:office',
            'xmlns:html' => 'http://www.w3.org/TR/REC-html40',
        ]);

        $xml['Styles']['Style0']['@attributes'] = [
            'ss:Name' => 'Normal',
            'ss:ID'   => 'Default',
        ];

        $xml['Styles']['Style0']['Alignment']    = null;
        $xml['Styles']['Style0']['Borders']      = null;
        $xml['Styles']['Style0']['Font0']        = null;
        $xml['Styles']['Style0']['Interior']     = null;
        $xml['Styles']['Style0']['NumberFormat'] = null;
        $xml['Styles']['Style0']['Protection']   = null;

        $xml['Styles']['Style1']['@attributes'] = [
            'ss:ID' => 's22'
        ];

        $xml['Styles']['Style1']['Font1'] = null;
        $xml['Styles']['Style1']['Font1']['@attributes'] = [
            'ss:Bold' => 1,
            'ss:Size' => 10,
        ];

        $xml['Worksheet']['@attributes'] = [
            'ss:Name' => 'Reporting',
        ];

        // column foreach

        $array2xml->setElementsAttrs([
            'Alignment' => [
                'ss:Vertical' => 'Bottom',
            ],
        ]);

        $array2xml->setFilterNumbersInTags(true);

        return [
            'contentType'   => self::CONTENT_TYPE,
            'fileExtension' => self::FILE_EXTENSION,
            'fileData'      => $array2xml->convert($xml),
        ];
    }
}
