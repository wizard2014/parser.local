<?php

namespace User\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;
use Zend\View\Model\ViewModel;
use Zend\Authentication\AuthenticationService;
use User\Service\UserService;
use Utility\Service\DataSourceService;
use Utility\Service\SubscriptionPlanService;
use Utility\Service\AttributeValueService;
use Utility\Helper\Csrf\Csrf;

class SettingsController extends AbstractActionController
{
    /**
     * @var UserService
     */
    protected $userService;

    /**
     * @var DataSourceService
     */
    protected $dataSourceService;

    /**
     * @var SubscriptionPlanService
     */
    protected $subscriptionPlanService;

    /**
     * @var AttributeValueService
     */
    protected $attributeValueService;

    /**
     * @var int|null
     */
    private $user;

    /**
     * @param UserService             $userService
     * @param DataSourceService       $dataSourceService
     * @param SubscriptionPlanService $subscriptionPlanService
     * @param AttributeValueService   $attributeValueService
     */
    public function __construct(
        UserService             $userService,
        DataSourceService       $dataSourceService,
        SubscriptionPlanService $subscriptionPlanService,
        AttributeValueService   $attributeValueService
    ) {
        $this->userService              = $userService;
        $this->dataSourceService        = $dataSourceService;
        $this->subscriptionPlanService  = $subscriptionPlanService;
        $this->attributeValueService    = $attributeValueService;

        $auth = new AuthenticationService();
        $this->user = $auth->getIdentity();
    }

    public function indexAction()
    {
        $redirect = $this->userService->getRedirectRule($this->user);

        if (!$redirect) {
            return $this->redirect()->toRoute('settings/default', ['action' => 'subscription']);
        }

        return $this->redirect()->toRoute('settings/default', ['action' => 'profile']);
    }

    public function profileAction()
    {
        $userId = $this->user;

        $userInfo = $this->userService->getUserInfo($userId);

        var_dump($userInfo); exit;

        /** @todo refactor */
        $subTypeId   = $this->userStatusMapper->getSubscriptionTypeId($userId);
        $subStatusId = $this->userStatusMapper->getSubscriptionStatusId($userId);

        $subType    = $this->attributeValueMapper->getAttributeValueById($subTypeId);
        $subStatus  = $this->attributeValueMapper->getAttributeValueById($subStatusId);

        // data source keys
        $dataSourceKeys = $this->dataSourceGlobalMapper->getAll(); // form for Ebay, Amazon, etc...

        $request = $this->getRequest();

        if ($request->isXmlHttpRequest()) {
            $token = $request->getPost('token');

            if (isset($token) && Csrf::valid($token)) {
                $data = $request->getPost()->toArray();

                // clear data
                array_walk_recursive($data, function (&$value) {
                    $value = trim(strip_tags($value));
                });

                if ($dataSourceGlobal = $this->dataSourceGlobalMapper->getSourceGlobalById($data['vendor'])) {
                    $user = $this->userMapper->getUserById($this->user);

                    // set app key
                    $this->dataSourceKey->setKey($user, $dataSourceGlobal, $data['key']);
                }
            }

            return new JsonModel([
                'token' => Csrf::generate(),
            ]);
        }

        return new ViewModel([
            'memberSince'    => $memberSince,
            'subType'        => $subType,
            'subStatus'      => $subStatus,
            'dataSourceKeys' => $dataSourceKeys,
            'token'          => Csrf::generate(),
        ]);
    }

    public function notificationAction()
    {
        $userId = $this->user;

        $isEmailSubscriber = $this->userService->isEmailSubscriber($userId);

        $request = $this->getRequest();

        if ($request->isXmlHttpRequest()) {
            $token = $request->getPost('token');

            if (isset($token) && Csrf::valid($token)) {
                $this->userService->changeSubscription($userId, $isEmailSubscriber);
            }

            return new JsonModel([
                'token' => Csrf::generate(),
            ]);
        }

        return new ViewModel([
            'isEmailSubscriber' => $isEmailSubscriber,
            'token'             => Csrf::generate(),
        ]);
    }

    public function subscriptionAction()
    {
        return new ViewModel();
    }

    public function statisticsAction()
    {
        return new ViewModel();
    }
}
