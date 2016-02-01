<?php

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;
use Zend\View\Model\ViewModel;
use Zend\Authentication\AuthenticationService;
use Ebay\Service\CategoryService;
use Utility\Service\DataSourceService;
use User\Service\UserService;
use Utility\Helper\Csrf\Csrf;

class GetStartedController extends AbstractActionController
{
    /**
     * @var CategoryService
     */
    protected $categoryService;

    /**
     * @var DataSourceService
     */
    protected $dataSourceService;

    /**
     * @var UserService
     */
    protected $userService;

    /**
     * @var int|null
     */
    protected $user;

    /**
     * GetStartedController constructor.
     *
     * @param CategoryService   $categoryService
     * @param DataSourceService $dataSourceService
     * @param UserService       $userService
     */
    public function __construct(
        CategoryService     $categoryService,
        DataSourceService   $dataSourceService,
        UserService         $userService
    ) {
        $this->categoryService   = $categoryService;
        $this->dataSourceService = $dataSourceService;
        $this->userService       = $userService;

        $auth = new AuthenticationService();
        $this->user = $auth->getIdentity();
    }

    public function indexAction()
    {
        // get eBay Sort Order & Listing Type
        $ebayFilterSet = $this->dataSourceService->getEbayFilterSet();

        // reset daily counter
        $this->userService->userCheckout($this->user);

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
            $ebayDataSourceRegional = $this->dataSourceService->getRegions('ebay', 'en', false); // ebay in english

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

            $categories = $this->categoryService->getCategory($data['region'], $data['level'], $data['parentId']);

            return new JsonModel([
                'categoryList' => $categories,
            ]);
        }

        return $this->redirect()->toRoute('get-started');
    }
}
