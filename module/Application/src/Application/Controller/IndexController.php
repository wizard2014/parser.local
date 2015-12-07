<?php

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController
{
    public function indexAction()
    {
        $timezoneIdentifiers = \DateTimeZone::listIdentifiers();

        $zones = [];
        $timestamp = time();

        foreach ($timezoneIdentifiers as $key => $zone) {
            date_default_timezone_set($zone);

            $zones[$key]['zone'] = $zone;
            $zones[$key]['diff_from_GMT'] = 'UTC/GMT ' . date('P', $timestamp);
        }

//        var_dump($zones);

        return new ViewModel();
    }
}
