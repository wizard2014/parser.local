<?php

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;
use Zend\View\Model\ViewModel;

use Utility\Helper\Csrf\Csrf;

class GetStartedController extends AbstractActionController
{
    protected $mapper;
    protected $cache;
    protected $session;

    public function __construct($mapper, $cache)
    {
        $this->mapper = $mapper;
        $this->cache  = $cache;
    }

    public function indexAction()
    {
        // get eBay Sort Order & Listing Type
        $ebayDataSourceGlobalEbay = $this->mapper['dataSourceGlobal']->getSourceGlobalByName('eBay');

        return new ViewModel([
            'ebaySourceGlobal' => $ebayDataSourceGlobalEbay,
            'flashMessages'    => $this->flashMessenger()->getMessages(),
            'token'            => Csrf::generate(),
        ]);
    }

    public function getRegionAction()
    {
        $request = $this->getRequest();

        if ($request->isXmlHttpRequest()) {
            $ebayId                 = $this->mapper['dataSourceGlobal']->getIdByName('eBay');
            $ebayDataSourceRegional = $this->mapper['dataSourceRegional']->getRegions($ebayId, 'en', 'ebay'); // ebay in english

            return new JsonModel([
                'ebaySourceRegional' => $ebayDataSourceRegional,
            ]);
        }
    }

    public function getCategoryAction()
    {
        $request = $this->getRequest();

        if ($request->isXmlHttpRequest()) {
            $data = $request->getPost();

            if (!empty($data['parentId'])) {
                $categories = $this->mapper['category']->getCategory($data['region'], $data['level'], $data['parentId']);
            } else {
                $categories = $this->mapper['category']->getMainCategory($data['region'], $data['level']);
            }

            return new JsonModel([
                'categoryList' => $categories,
            ]);
        }

        return $this->redirect()->toRoute('zfcuser');
    }
}
