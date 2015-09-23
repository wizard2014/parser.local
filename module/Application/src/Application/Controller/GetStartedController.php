<?php

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;
use Zend\View\Model\ViewModel;
use Zend\Authentication\AuthenticationService;

class GetStartedController extends AbstractActionController
{
    protected $mapper;
    protected $cache;
    private $user;

    public function __construct($mapper, $cache)
    {
        $auth = new AuthenticationService();
        $this->user = $auth->getIdentity();

        $this->mapper = $mapper;
        $this->cache  = $cache;
    }

    public function indexAction()
    {
        // check for log in
        if (null === $this->user) {
            return $this->redirect()->toRoute('zfcuser');
        }

        $ebayDataSourceGlobalEbay = $this->mapper['dataSourceGlobal']->getSourceGlobalByName('eBay');
        $ebayDataSourceRegional   = $this->mapper['dataSourceRegional']->getDataByRegion($ebayDataSourceGlobalEbay->getId(), 'en', 'ebay'); // ebay in english

        return new ViewModel([
            'ebaySourceGlobal'   => $ebayDataSourceGlobalEbay,
            'ebaySourceRegional' => $ebayDataSourceRegional,
        ]);
    }

    public function getCatalogItemAction()
    {
        // region
        // level

        $request = $this->getRequest();

        if ($request->isXmlHttpRequest()) {
            $data = $request->getPost();

            $region   = $data['region'];
            $level    = $data['level'];
            $parentId = $data['parentId'];

            $categories = $this->cache->getItem($region)[$region]['level_' . $level];

            return new JsonModel([
                'catalogList' => $categories,
            ]);
        }

        return $this->redirect()->toRoute('zfcuser');
    }
}
