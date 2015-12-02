<?php

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

use Utility\Mapper\SubscriptionPlan as SubscriptionPlanMapper;

class PriceController extends AbstractActionController
{
    protected $subscriptionPlanMapper;

    public function __construct(SubscriptionPlanMapper $subscriptionPlanMapper)
    {
        $this->subscriptionPlanMapper = $subscriptionPlanMapper;
    }

    public function indexAction()
    {
        $plans = $this->subscriptionPlanMapper->getAllPlanes();

        return new ViewModel([
            'plans' => $plans,
        ]);
    }
}
