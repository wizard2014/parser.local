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
