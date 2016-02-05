<?php

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;
use Zend\View\Model\ViewModel;
use Zend\Authentication\AuthenticationService;
use Ebay\Service\CategoryService;
use Utility\Service\DataSourceService;
use User\Service\UserService;
use Utility\Service\SubscriptionService;
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
     * @var SubscriptionService
     */
    protected $subscriptionService;

    /**
     * @var int|null
     */
    protected $user;

    /**
     * GetStartedController constructor.
     *
     * @param CategoryService     $categoryService
     * @param DataSourceService   $dataSourceService
     * @param UserService         $userService
     * @param SubscriptionService $subscriptionService
     */
    public function __construct(
        CategoryService     $categoryService,
        DataSourceService   $dataSourceService,
        UserService         $userService,
        SubscriptionService $subscriptionService
    ) {
        $this->categoryService      = $categoryService;
        $this->dataSourceService    = $dataSourceService;
        $this->userService          = $userService;
        $this->subscriptionService  = $subscriptionService;

        $auth = new AuthenticationService();
        $this->user = $auth->getIdentity();
    }

    public function indexAction()
    {
        // get eBay Sort Order & Listing Type
        $ebayFilterSet = $this->dataSourceService->getEbayFilterSet();

        // change subscription status if expired
        $this->userService->updateSubscriptionStatus($this->user);

        // reset daily counter
        $this->userService->userCheckout($this->user);

        // active user subscription info
        $sub = $this->userService->getActiveSubscription($this->user, 1); // ebay

        $subInfo = [];
        if (!is_null($sub)) {
            $subscriptionPlan = $this->subscriptionService->getUserSubscriptionPlan(
                $sub->getSubscriptionScheme(),
                $this->dataSourceService->keyExists($this->user, 1) // ebay
            );

            $subInfo = $this->getSubscriptionInfo($sub, $subscriptionPlan);
        }

        return new ViewModel([
            'ebayFilterSet'    => $ebayFilterSet,
            'subInfo'          => $subInfo,
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

    protected function getSubscriptionInfo($subscription, $subscriptionPlan)
    {
        $result = [];

        $result['current']['requestCounterDaily']   = $subscription->getRequestCounterDaily();
        $result['current']['subscriptionType']      = $subscription->getSubscriptionScheme()->getSubscriptionType();

        $result['available']['limitRequestDaily']   = $subscriptionPlan->getLimitRequestDaily();
        $result['available']['limitRowPerRequest']  = $subscriptionPlan->getLimitRowPerRequest();
        $result['allLimitsRowPerRequest']           = [100, 1000, 10000, 50000, 100000];
//        $result['allLimitsRowPerRequest']           = $this->subscriptionService->getAllLimitRowPerRequest();

        return $result;
    }
}
