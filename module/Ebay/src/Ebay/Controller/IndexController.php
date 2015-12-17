<?php

namespace Ebay\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Authentication\AuthenticationService;
use Ebay\Service\CategoryService;
use Ebay\Service\FindItemsService;
use Utility\Service\DataSourceService;
use Utility\Helper\Csrf\Csrf;

class IndexController extends AbstractActionController
{
    /**
     * @var CategoryService
     */
    protected $categoryService;

    /**
     * @var FindItemsService
     */
    protected $findItemsService;

    /**
     * @var DataSourceService
     */
    protected $dataSourceService;

    /**
     * @var int|null
     */
    protected $user;
    protected $outputPath = './data/output/';

    /**
     * @param CategoryService   $categoryService
     * @param FindItemsService  $findItemsService
     * @param DataSourceService $dataSourceService
     */
    public function __construct(
        CategoryService   $categoryService,
        FindItemsService  $findItemsService,
        DataSourceService $dataSourceService
    ) {
        $this->categoryService   = $categoryService;
        $this->findItemsService  = $findItemsService;
        $this->dataSourceService = $dataSourceService;

        $auth = new AuthenticationService();
        $this->user = $auth->getIdentity();
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
                $region = $data['region'];
                // get user app key if exists
                $appId = $this->dataSourceKeyMapper->getKey($this->user, $region);

                /**
                 * replace region id to Ebay global id
                 *
                 * @todo Change solution
                 */
                $data['region'] = $this->dataSourceRegionalMapper->getPropertySet($data['region'], 'ebay_global_id');

                $results = $this->ebayFindingService->findItems($data, $appId);

                // if returns error
                if (500 === $results) {
                    $this->flashMessenger()->addMessage(['Invalid key, please check it out and add again.']);

                    //change key status to Invalid
                    $this->dataSourceKeyMapper->setInvalidKeyStatus($this->user, $region);
                } else {
                    // save result as XML
                    $xml = new \SimpleXMLElement('<?xml version="1.0"?><data></data>');
                    $this->arrayToXml($results, $xml);
                    $xml->asXML($this->outputPath . 'data.xml');
                }
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
