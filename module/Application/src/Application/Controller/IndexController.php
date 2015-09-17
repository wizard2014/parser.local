<?php

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController
{
    public function indexAction()
    {
        $em = $this->getServiceLocator()->get(\Doctrine\ORM\EntityManager::class);

        $dataSourceGlobal = $em->find(\Utility\Entity\DataSourceGlobal::class, 1);

        $dataSourceGlobalId = $dataSourceGlobal->getId();

        $regions = $em->getRepository(\Utility\Entity\DataSourceRegional::class)->findAll();

        $result = [];

        foreach ($regions as $region) {
            $lang = $region->getPropertySet()['ebay_language'];
            $currentDataSourceGlobalId = $region->getDataSourceGlobal()->getId();

            if (strpos($lang, 'en') !== false && $currentDataSourceGlobalId == $dataSourceGlobalId) {
                $result[] = $region;
            }
        }

        var_dump($result);


        return new ViewModel();
    }
}
