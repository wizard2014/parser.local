<?php

namespace Ebay\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController
{
    public function indexAction()
    {
        $em = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');

        $categories = $em->getRepository(\Ebay\Entity\View\MvwCategoryEbayLvl1::class);

        var_dump($categories->findAll());

        return new ViewModel();
    }
}
