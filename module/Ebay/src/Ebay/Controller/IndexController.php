<?php

namespace Ebay\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;
use Zend\Session\Container;

class IndexController extends AbstractActionController
{
    protected $ebayFindingService;
    protected $mapper;
    protected $session;
    protected $outputPath = './data/output/';

    /**
     * @param $ebayFindingService
     * @param $mapper
     */
    public function __construct($ebayFindingService, $mapper)
    {
        $this->ebayFindingService = $ebayFindingService;

        $this->session = new Container('token');

        $this->mapper = $mapper;
    }

    public function indexAction()
    {
        $request = $this->getRequest();

        if ($request->isPost()) {
            $data = $request->getPost()->toArray();

            // validate token
            $token = $this->tokenValidate($data['token']);

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
                $data['region'] = $this->mapper['dataSourceRegional']->getPropertySet($data['region'], 'ebay_global_id');

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
    protected function arrayToXml($data, &$xmlData) {
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

        if (!$this->mapper['dataSourceGlobal']->sortOrderExists('eBay', $data['sortOrder'])) {
            $errors[] = 'Invalid [Sort Order].';
        }

        if (!empty($data['listingType']) && !$this->mapper['dataSourceGlobal']->listingTypeExists('eBay', $data['listingType'])) {
            $errors[] = 'Invalid [Listing Type].';
        }

        if (!in_array($data['itemsQty'], [100, /*10000, 50000, 100000*/])) { // uncomment in future
            $errors[] = 'Invalid [Items qty].';
        }

        if ($this->mapper['dataSourceGlobal']->regionExists($data['region'])) {
            if (!$this->mapper['category']->categoryExists($data['region'], $data['category'])) {
                $errors[] = 'Invalid [Category].';
            }
        } else {
            $errors[] = 'Invalid [Region].';
        }

        return $errors;
    }

    /**
     * @param $token
     *
     * @return bool
     */
    protected function tokenValidate($token) {
        $sessionToken = $this->session->offsetGet('token');

        if (!empty($token) && $token === $sessionToken) {
            return true;
        }

        return false;
    }
}
