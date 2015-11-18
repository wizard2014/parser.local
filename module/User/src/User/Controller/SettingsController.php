<?php

namespace User\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;
use Zend\View\Model\ViewModel;
use Zend\Authentication\AuthenticationService;

use User\Mapper\UserStatus as UserStatusMapper;
use Utility\Helper\Csrf\Csrf;

class SettingsController extends AbstractActionController
{
    protected $mapper;
    private $user;

    public function __construct(UserStatusMapper $mapper)
    {
        $auth = new AuthenticationService();
        $this->user = $auth->getIdentity();

        $this->mapper = $mapper;
    }

    public function indexAction()
    {
        $userId = $this->user;

        $isFreeUser     = $this->mapper->isFreeSubUser($userId);
        $isActiveUser   = $this->mapper->isActiveUser($userId);

        if ($isFreeUser || !$isActiveUser) {
            return $this->redirect()->toRoute('settings/default', ['action' => 'subscription']);
        }

        return $this->redirect()->toRoute('settings/default', ['action' => 'profile']);
    }

    public function profileAction()
    {
        $userId = $this->user;

        $memberSince = $this->mapper->getMemberSince($userId);

        return new ViewModel([
            'memberSince' => $memberSince,
        ]);
    }

    public function notificationAction()
    {
        $userId = $this->user;

        $isEmailSubscriber = $this->mapper->isEmailSubscriber($userId);

        $request = $this->getRequest();

        if ($request->isXmlHttpRequest()) {
            $token = $request->getPost('token');

            if (isset($token) && Csrf::valid($token)) {
                if ($isEmailSubscriber) {
                    $this->mapper->unsubscribe($userId);
                } else {
                    $this->mapper->subscribe($userId);
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
