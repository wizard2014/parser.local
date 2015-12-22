<?php

namespace Utility\Service;

use Utility\Mapper\SubscriptionPlanMapper;
use Utility\Mapper\SubscriptionSchemeMapper;

class SubscriptionService implements SubscriptionServiceInterface
{
    /**
     * @var SubscriptionPlanMapper
     */
    protected  $subscriptionPlanMapper;

    /**
     * @var SubscriptionSchemeMapper
     */
    protected $subscriptionSchemeMapper;

    /**
     * @param SubscriptionPlanMapper   $subscriptionPlanMapper
     * @param SubscriptionSchemeMapper $subscriptionSchemeMapper
     */
    public function __construct(
        SubscriptionPlanMapper   $subscriptionPlanMapper,
        SubscriptionSchemeMapper $subscriptionSchemeMapper
    ) {
        $this->subscriptionPlanMapper   = $subscriptionPlanMapper;
        $this->subscriptionSchemeMapper = $subscriptionSchemeMapper;
    }

    /**
     * @return array
     */
    public function getAllSubscriptionSchemes()
    {
        return $this->subscriptionSchemeMapper->getAllSubscriptionScheme();

    }

    /**
     * @param $schemaBySubscriptionTypeId
     *
     * @return object
     */
    public function getSubscriptionScheme($schemaBySubscriptionTypeId)
    {
        return $this->subscriptionSchemeMapper->getSchemaBySubscriptionTypeId($schemaBySubscriptionTypeId);
    }

    /**
     * @param $subscriptionTypeId
     *
     * @return string|null
     */
    public function getSubscriptionType($subscriptionTypeId)
    {
        return $this->subscriptionSchemeMapper->getSubscriptionType($subscriptionTypeId);
    }
}
