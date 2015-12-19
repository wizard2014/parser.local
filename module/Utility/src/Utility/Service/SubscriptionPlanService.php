<?php

namespace Utility\Service;

use Utility\Mapper\SubscriptionPlanMapper;

class SubscriptionPlanService implements SubscriptionPlanServiceInterface
{
    /**
     * @var SubscriptionPlanMapper
     */
    protected  $subscriptionPlanMapper;

    /**
     * @param SubscriptionPlanMapper $subscriptionPlanMapper
     */
    public function __construct(SubscriptionPlanMapper $subscriptionPlanMapper)
    {
        $this->subscriptionPlanMapper = $subscriptionPlanMapper;
    }
}
