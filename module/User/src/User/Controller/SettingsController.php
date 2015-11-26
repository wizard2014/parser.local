<?php

namespace User\Controller;

use Utility\Mapper\SubscriptionPlan;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;
use Zend\View\Model\ViewModel;
use Zend\Authentication\AuthenticationService;

use User\Mapper\UserStatus as UserStatusMapper;
use Utility\Mapper\AttributeValue as AttributeValueMapper;
use Utility\Mapper\DataSourceGlobal as DataSourceGlobalMapper;
use User\Mapper\User as UserMapper;
use Utility\Mapper\DataSourceKey as DataSourceKeyMapper;
use Utility\Mapper\SubscriptionPlan as SubscriptionPlanMapper;
use Utility\Helper\Csrf\Csrf;

class SettingsController extends AbstractActionController
{
    protected $userStatusMapper;
    protected $attributeValueMapper;
    protected $dataSourceGlobalMapper;
    protected $userMapper;
    protected $subscriptionPlanMapper;
    protected $dataSourceKey;
    private $user;

    public function __construct(
        UserStatusMapper        $userStatusMapper,
        AttributeValueMapper    $attributeValueMapper,
        DataSourceGlobalMapper  $dataSourceGlobalMapper,
        UserMapper              $userMapper,
        SubscriptionPlan        $subscriptionPlanMapper,
        DataSourceKeyMapper     $dataSourceKey
    )
    {
        $auth = new AuthenticationService();
        $this->user = $auth->getIdentity();

        $this->userStatusMapper       = $userStatusMapper;
        $this->attributeValueMapper   = $attributeValueMapper;
        $this->dataSourceGlobalMapper = $dataSourceGlobalMapper;
        $this->userMapper             = $userMapper;
        $this->subscriptionPlanMapper = $subscriptionPlanMapper;
        $this->dataSourceKey          = $dataSourceKey;
    }

    public function indexAction()
    {
        $userId = $this->user;

        $isFreeUser     = $this->userStatusMapper->isFreeSubUser($userId);
        $isActiveUser   = $this->userStatusMapper->isActiveUser($userId);

        if ($isFreeUser || !$isActiveUser) {
            return $this->redirect()->toRoute('settings/default', ['action' => 'subscription']);
        }

        return $this->redirect()->toRoute('settings/default', ['action' => 'profile']);
    }

    public function profileAction()
    {
        $userId = $this->user;

        $memberSince = $this->userStatusMapper->getMemberSince($userId);

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

        $isEmailSubscriber = $this->userStatusMapper->isEmailSubscriber($userId);

        $request = $this->getRequest();

        if ($request->isXmlHttpRequest()) {
            $token = $request->getPost('token');

            if (isset($token) && Csrf::valid($token)) {
                if ($isEmailSubscriber) {
                    $this->userStatusMapper->unsubscribe($userId);
                } else {
                    $this->userStatusMapper->subscribe($userId);
                }
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
        $plans = $this->subscriptionPlanMapper->getAllPlanes();

        return new ViewModel([
            'plans' => $plans,
        ]);
    }

    public function statisticsAction()
    {
        return new ViewModel();
    }
}
