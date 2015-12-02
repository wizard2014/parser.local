<?php

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class SecurityController extends AbstractActionController
{
    public function indexAction()
    {
        return $this->redirect()->toRoute('security/default', ['action' => 'privacy-policy']);
    }

    public function PrivacyPolicyAction()
    {
        return new ViewModel();
    }

    public function TermsOfServiceAction()
    {
        return new ViewModel();
    }
}
