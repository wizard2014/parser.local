<?php

namespace User\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use User\Mapper\UserStatus as UserStatusMapper;

class SettingsController extends AbstractActionController
{
    protected $mapper;
    private $user;

    public function __construct(UserStatusMapper $mapper)
    {
        $this->mapper = $mapper;
    }

    public function indexAction()
    {
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
}
