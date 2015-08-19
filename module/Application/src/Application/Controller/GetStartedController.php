<?php

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Authentication\AuthenticationService;

class GetStartedController extends AbstractActionController
{
    private $user;

    public function __construct()
    {
        $auth = new AuthenticationService();
        $this->user = $auth->getIdentity();
    }

    public function indexAction()
    {
        // check for log in
        if (is_null($this->user)) {
            return $this->redirect()->toRoute('zfcuser');
        }

        return new ViewModel();
    }
}
