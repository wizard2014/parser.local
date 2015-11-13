<?php

namespace User\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Authentication\AuthenticationService;
use User\Mapper\UserStatus as UserStatusMapper;

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
        $this->isUser();

        return new ViewModel();
    }

    public function profileAction()
    {
        $userId = $this->user;

        $memberSince = $this->mapper->getMemberSince($userId);

        return new ViewModel([
            'memberSince' => $memberSince,
        ]);
    }

    /**
     * @todo add token
     */
    public function notificationAction()
    {
        $userId = $this->user;

        $isEmailSubscriber = $this->mapper->isEmailSubscriber($userId);

        $request = $this->getRequest();

        if ($request->isXmlHttpRequest()) {
            if ($isEmailSubscriber) {
                $isEmailSubscriber = $this->mapper->unsubscribe($userId);
            } else {
                $isEmailSubscriber = $this->mapper->subscribe($userId);
            }
        }

        return new ViewModel([
            'isEmailSubscriber' => $isEmailSubscriber,
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

    /**
     * Check if is user
     */
    protected function isUser()
    {
        if (null === $this->user) {
            return $this->redirect()->toRoute('zfcuser');
        }
    }
}
