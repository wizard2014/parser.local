<?php

namespace User\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;
use Zend\View\Model\ViewModel;
use Zend\Authentication\AuthenticationService;

use User\Mapper\UserStatus as UserStatusMapper;
use Utility\Mapper\AttributeValue as AttributeValueMapper;
use Utility\Helper\Csrf\Csrf;

class SettingsController extends AbstractActionController
{
    protected $userStatusMapper;
    protected $attributeValueMapper;
    private $user;

    public function __construct(UserStatusMapper $userStatusMapper, AttributeValueMapper $attributeValueMapper)
    {
        $auth = new AuthenticationService();
        $this->user = $auth->getIdentity();

        $this->userStatusMapper     = $userStatusMapper;
        $this->attributeValueMapper = $attributeValueMapper;
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

        $subTypeId   = $this->userStatusMapper->getSubscriptionTypeId($userId);
        $subStatusId = $this->userStatusMapper->getSubscriptionStatusId($userId);

        $subType    = $this->attributeValueMapper->getAttributeValueById($subTypeId);
        $subStatus  = $this->attributeValueMapper->getAttributeValueById($subStatusId);

        return new ViewModel([
            'memberSince'   => $memberSince,
            'subType'       => $subType,
            'subStatus'     => $subStatus,
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
        return new ViewModel();
    }

    public function statisticsAction()
    {
        return new ViewModel();
    }
}
