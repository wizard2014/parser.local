<?php

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController
{
    public function indexAction()
    {
//        $em = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
//
//        $users = $em->getRepository(\User\Entity\UserAddition::class);
//
//        var_dump($users->findAll());

        return new ViewModel();
    }
}
