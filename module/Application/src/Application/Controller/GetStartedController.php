<?php

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;
use Zend\View\Model\ViewModel;
use Zend\Authentication\AuthenticationService;

use Ebay\Mapper\Category as CategoryMapper;
use Utility\Mapper\DataSourceGlobal as DataSourceGlobalMapper;
use Utility\Mapper\DataSourceRegional as DataSourceRegionalMapper;
use Utility\Helper\Csrf\Csrf;

class GetStartedController extends AbstractActionController
{
    protected $cache;
    protected $session;
    protected $categoryMapper;
    protected $dataSourceGlobalMapper;
    protected $dataSourceRegionalMapper;
    protected $user;

    public function __construct(
        $cache,
        CategoryMapper           $categoryMapper,
        DataSourceGlobalMapper   $dataSourceGlobalMapper,
        DataSourceRegionalMapper $dataSourceRegionalMapper
    ) {
        $this->cache  = $cache;

        $this->categoryMapper           = $categoryMapper;
        $this->dataSourceGlobalMapper   = $dataSourceGlobalMapper;
        $this->dataSourceRegionalMapper = $dataSourceRegionalMapper;

        $auth = new AuthenticationService();
        $this->user = $auth->getIdentity();
    }

    public function indexAction()
    {
        // get eBay Sort Order & Listing Type
        $ebayDataSourceGlobalEbay = $this->dataSourceGlobalMapper->getSourceGlobalByName('eBay');

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
            $ebayId                 = $this->dataSourceGlobalMapper->getIdByName('eBay');
            $ebayDataSourceRegional = $this->dataSourceRegionalMapper->getRegions($ebayId, 'en', 'ebay'); // ebay in english

            return new JsonModel([
                'ebaySourceRegional' => $ebayDataSourceRegional,
            ]);
        }

        return $this->redirect()->toRoute('get-started');
    }

    public function getCategoryAction()
    {
        $request = $this->getRequest();

        if ($request->isXmlHttpRequest()) {
            $data = $request->getPost();

            if (!empty($data['parentId'])) {
                $categories = $this->categoryMapper->getCategory($data['region'], $data['level'], $data['parentId']);
            } else {
                $categories = $this->categoryMapper->getMainCategory($data['region'], $data['level']);
            }

            return new JsonModel([
                'categoryList' => $categories,
            ]);
        }

        return $this->redirect()->toRoute('get-started');
    }
}
