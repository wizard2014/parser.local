<?php

namespace Utility\Helper\Xml;

class Xlsx
{
    /**
     * @param $writer
     *
     * @return string
     */
    public static function getPsmdcp($writer)
    {
        $array2xml = new $writer();

        $array2xml->setRootName('coreProperties');
        $array2xml->setRootAttrs([
            'xmlns:dc' 		=> 'http://purl.org/dc/elements/1.1/',
            'xmlns:dcterms' => 'http://purl.org/dc/terms/',
            'xmlns:xsi' 	=> 'http://www.w3.org/2001/XMLSchema-instance',
            'xmlns' 		=> 'http://schemas.openxmlformats.org/package/2006/metadata/core-properties',
        ]);

        $data['dcterms:created']['@content'] = (new \DateTime())->format('c');
        $data['dcterms:modified']['@content'] = (new \DateTime())->format('c');

        $data['dcterms:created']['@attributes'] = [
            'xsi:type' => 'dcterms:W3CDTF',
        ];
        $data['dcterms:modified']['@attributes'] = [
            'xsi:type' => 'dcterms:W3CDTF',
        ];

        return self::result($array2xml->convert($data));
    }

    /**
     * @param       $writer
     * @param array $fieldsName
     *
     * @return string
     */
    public static function getTable($writer, $fieldsName = [])
    {
        $array2xml = new $writer();

        $array2xml->setRootName('x:table');
        $array2xml->setRootAttrs([
            'id' 			 => 1,
            'name' 			 => 'Table1',
            'displayName' 	 => 'Table1',
            'ref' 			 => 'A1:AF101',
            'totalsRowShown' => 0,
            'xmlns:x' 		 => 'http://schemas.openxmlformats.org/spreadsheetml/2006/main',
        ]);

        $attrCounter  = 1;

        $data['x:autoFilter'] = null;
        foreach ($fieldsName as $i => $value) {
            $data['x:tableColumns']['x:tableColumn' . $i] = null;

            $data['x:tableColumns']['x:tableColumn' . $i]['@attributes'] = [
                'id' 	=> $attrCounter,
                'name' 	=> $fieldsName[$i],
            ];

            $attrCounter++;
        }
        $data['x:tableStyleInfo'] = null;

        $array2xml->setElementsAttrs([
            'x:autoFilter' => [
                'ref' => 'A1:AF101',                // <---- make dynamic
            ],
            'x:tableColumns' => [
                'count' => 32,                      // <---- make dynamic
            ],
            'x:tableStyleInfo' => [
                'name' 				=> 'TableStyleLight9',
                'showFirstColumn' 	=> 0,
                'showLastColumn' 	=> 0,
                'showRowStripes' 	=> 1,
                'showColumnStripes' => 0,
            ],
        ]);

        $array2xml->setFilterNumbersInTags(['x:tableColumn']);

        return self::result($array2xml->convert($data));
    }

    /**
     * @param       $writer
     * @param array $fieldsName
     *
     * @return string
     */
    public static function getSharedSettings($writer, $fieldsName = [])
    {
        $array2xml = new $writer();

        $array2xml->setRootName('x:sst');
        $array2xml->setRootAttrs([
            'count' 		=> 1081,            // <---- make dynamic
            'uniqueCount' 	=> 1081,            // <---- make dynamic
            'xmlns:x' 		=> 'http://schemas.openxmlformats.org/spreadsheetml/2006/main',
        ]);

        foreach ($fieldsName as $i => $value) {
            $data['x:si' . $i]['x:t'] = $value;
        }

        $array2xml->setFilterNumbersInTags(['x:si']);

        return self::result($array2xml->convert($data));
    }

    /**
     * @param        $writer
     * @param string $sheetName
     *
     * @return mixed
     */
    public static function getWorkbook($writer, $sheetName = 'sheet')
    {
        $array2xml = new $writer();

        $array2xml->setRootName('x:workbook');
        $array2xml->setRootAttrs([
            'xmlns:r' => 'http://schemas.openxmlformats.org/officeDocument/2006/relationships',
            'xmlns:x' => 'http://schemas.openxmlformats.org/spreadsheetml/2006/main',
        ]);

        $data['x:workbookPr'] 					= null;
        $data['x:bookViews']['x:workbookView']  = null;
        $data['x:sheets']['x:sheet'] 			= null;
        $data['x:definedNames'] 				= null;
        $data['x:calcPr'] 						= null;

        $array2xml->setElementsAttrs([
            'x:workbookPr' => [
                'codeName' => 'ThisWorkbook'
            ],
            'x:workbookView' => [
                'firstSheet' => 0,
                'activeTab'  => 0,
            ],
            'x:sheet' => [
                'name' 		=> $sheetName,
                'sheetId' 	=> 2,
                'r:id' 		=> 'rId2',
            ],
            'x:calcPr' => [
                'calcId' => 125725
            ],
        ]);

        return self::result($array2xml->convert($data));
    }

    /**
     * @param        $writer
     * @param array  $fieldsName
     * @param string $sheetName
     *
     * @return array
     */
    public static function getAllFiles($writer, $fieldsName = [], $sheetName = 'sheet')
    {
        return [
            'psmdcp'         => self::getPsmdcp($writer),
            'table'          => self::getTable($writer, $fieldsName),
            'sharedSettings' => self::getSharedSettings($writer, $fieldsName),
            'workbook'       => self::getWorkbook($writer, $sheetName),
        ];
    }

    protected static function result($data)
    {
        return preg_replace('/>\s+/', '>',$data);
    }
}
