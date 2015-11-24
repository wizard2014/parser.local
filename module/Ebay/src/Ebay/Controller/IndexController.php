<?php

namespace Ebay\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;

use Ebay\Service\FindItems;
use Ebay\Mapper\Category as CategoryMapper;
use Utility\Mapper\DataSourceGlobal as DataSourceGlobalMapper;
use Utility\Mapper\DataSourceRegional as DataSourceRegionalMapper;
use Utility\Helper\Csrf\Csrf;

class IndexController extends AbstractActionController
{
    protected $ebayFindingService;
    protected $categoryMapper;
    protected $dataSourceGlobalMapper;
    protected $dataSourceRegionalMapper;
    protected $session;
    protected $outputPath = './data/output/';

    /**
     * @param FindItems                $ebayFindingService
     * @param CategoryMapper           $categoryMapper
     * @param DataSourceGlobalMapper   $dataSourceGlobalMapper
     * @param DataSourceRegionalMapper $dataSourceRegionalMapper
     */
    public function __construct(
        FindItems                $ebayFindingService,
        CategoryMapper           $categoryMapper,
        DataSourceGlobalMapper   $dataSourceGlobalMapper,
        DataSourceRegionalMapper $dataSourceRegionalMapper
    ) {
        $this->ebayFindingService = $ebayFindingService;

        $this->categoryMapper           = $categoryMapper;
        $this->dataSourceGlobalMapper   = $dataSourceGlobalMapper;
        $this->dataSourceRegionalMapper = $dataSourceRegionalMapper;
    }

    public function indexAction()
    {
        $request = $this->getRequest();

        if ($request->isPost()) {
            $data = $request->getPost()->toArray();

            // validate token
            $token = Csrf::valid($data['token']);

            // clear data
            array_walk_recursive($data, function (&$value) {
                $value = trim(strip_tags($value));
            });

            // validate form data
            $errors = $this->validate($data);

            if (!empty($errors)) {
                $this->flashMessenger()->addMessage($errors);
            } elseif ($token) {
                /**
                 * replace region id to Ebay global id
                 *
                 * @todo Change solution
                 */
                $data['region'] = $this->dataSourceRegionalMapper->getPropertySet($data['region'], 'ebay_global_id');

                $results = $this->ebayFindingService->findItems($data);

                // save result as XML
                $xml = new \SimpleXMLElement('<?xml version="1.0"?><data></data>');
                $this->arrayToXml($results, $xml);
                $xml->asXML($this->outputPath . 'data.xml');
            }
        }

        return $this->redirect()->toRoute('get-started');
    }

    /**
     * @param $data
     * @param $xmlData
     */
    protected function arrayToXml($data, &$xmlData)
    {
        foreach ($data as $key => $value) {
            if (is_array($value)) {
                if (is_numeric($key)) {
                    $key = 'item' . $key; // dealing with <0/>..<n/> issues
                }

                $subnode = $xmlData->addChild($key);

                $this->arrayToXml($value, $subnode);
            } else {
                $xmlData->addChild("$key", htmlspecialchars("$value"));
            }
        }
    }

    /**
     * @param $data
     *
     * @return array
     */
    protected function validate($data)
    {
        $errors = [];

        if (!empty($data['minPrice']) && !is_numeric($data['minPrice'])) {
            $errors[] = '[Min Price] should be a number.';
        }

        if (!empty($data['maxPrice']) && !is_numeric($data['maxPrice'])) {
            $errors[] = '[Max Price] should be a number.';
        }

        if (!$this->dataSourceGlobalMapper->sortOrderExists('eBay', $data['sortOrder'])) {
            $errors[] = 'Invalid [Sort Order].';
        }

        if (!empty($data['listingType']) && !$this->dataSourceGlobalMapper->listingTypeExists('eBay', $data['listingType'])) {
            $errors[] = 'Invalid [Listing Type].';
        }

        if (!in_array($data['itemsQty'], [100, /*10000, 50000, 100000*/])) { // uncomment in future
            $errors[] = 'Invalid [Items qty].';
        }

        if ($this->dataSourceGlobalMapper->regionExists($data['region'])) {
            if (!$this->categoryMapper->categoryExists($data['region'], $data['category'])) {
                $errors[] = 'Invalid [Category].';
            }
        } else {
            $errors[] = 'Invalid [Region].';
        }

        return $errors;
    }
}
