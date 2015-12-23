<?php

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Utility\Service\SubscriptionService;
use Utility\Service\DataSourceService;

class PriceController extends AbstractActionController
{
    /**
     * @var SubscriptionService
     */
    protected $subscriptionService;

    /**
     * @var DataSourceService
     */
    protected $dataSourceService;

    /**
     * @param SubscriptionService $subscriptionService
     * @param DataSourceService   $dataSourceService
     */
    public function __construct(
        SubscriptionService $subscriptionService,
        DataSourceService   $dataSourceService
    ) {
        $this->subscriptionService = $subscriptionService;
        $this->dataSourceService   = $dataSourceService;
    }

    public function indexAction()
    {
        $allVendors = $this->dataSourceService->getVendors();

        $plans = $this->subscriptionService->getPlans(array_flip($allVendors));

        return new ViewModel([
            'plans' => $plans,
        ]);
    }
}
