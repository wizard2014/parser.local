<?php

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;
use Zend\View\Model\ViewModel;
use Zend\Authentication\AuthenticationService;
use Ebay\Service\CategoryService;
use Utility\Service\DataSourceService;
use Utility\Helper\Csrf\Csrf;

class GetStartedController extends AbstractActionController
{
    /**
     * @var $cache
     */
    protected $cache;

    /**
     * @var CategoryService
     */
    protected $categoryService;

    /**
     * @var DataSourceService
     */
    protected $dataSourceService;

    /**
     * @var int|null
     */
    protected $user;

    /**
     * @param                   $cache
     * @param CategoryService   $categoryService
     * @param DataSourceService $dataSourceService
     */
    public function __construct(
        $cache,
        CategoryService     $categoryService,
        DataSourceService   $dataSourceService
    ) {
        $this->cache  = $cache;

        $this->categoryService   = $categoryService;
        $this->dataSourceService = $dataSourceService;

        $auth = new AuthenticationService();
        $this->user = $auth->getIdentity();
    }

    public function indexAction()
    {
        // get eBay Sort Order & Listing Type
        $ebayFilterSet = $this->dataSourceService->getEbayFilterSet();

        return new ViewModel([
            'ebayFilterSet'    => $ebayFilterSet,
            'flashMessages'    => $this->flashMessenger()->getMessages(),
            'token'            => Csrf::generate(),
        ]);
    }

    public function getRegionAction()
    {
        $request = $this->getRequest();

        if ($request->isXmlHttpRequest()) {
//            $ebayId                 = $this->dataSourceGlobalMapper->getIdByName('eBay');
//            $ebayDataSourceRegional = $this->dataSourceRegionalMapper->getRegions($ebayId, 'en', 'ebay'); // ebay in english

            $ebayDataSourceRegional = $this->dataSourceService->getRegions('ebay'); // ebay in english

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
