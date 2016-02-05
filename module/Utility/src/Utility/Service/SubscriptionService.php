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

    /**
     * @param array $dataSourceGlobalIds
     *
     * @return array
     */
    public function getPlans($dataSourceGlobalIds = [])
    {
        $plans = [];

        $subSchemes = $this->subscriptionSchemeMapper->getAllSubscriptionPlanesByDataSourceGlobal($dataSourceGlobalIds);

        foreach ($subSchemes as $scheme) {
            $subPlans = $this->subscriptionPlanMapper->getPlansBySubscriptionScheme($scheme->getId());

            foreach ($subPlans as $plan) {
                $currentPlan = [
                    'id'                 => $scheme->getId(),
                    'title'              => $scheme->getSubscriptionType(),
                    'price'              => $scheme->getPrice(),
                    'limitRowPerRequest' => $plan->getLimitRowPerRequest(),
                    'limitRequestDaily'  => $plan->getLimitRequestDaily(),
                ];

                if ($plan->getIsKeyOwner()) {
                    $plans[$scheme->getDataSourceGlobal()->getName()]['withKey'][]    = $currentPlan;
                } else {
                    $plans[$scheme->getDataSourceGlobal()->getName()]['withoutKey'][] = $currentPlan;
                }
            }
        }

        return $plans;
    }

    /**
     * @param      $subscriptionScheme
     * @param bool $isKeyOwner
     *
     * @return object
     */
    public function getUserSubscriptionPlan($subscriptionScheme, $isKeyOwner)
    {
        return $this->subscriptionPlanMapper->getUserSubscriptionPlan($subscriptionScheme, $isKeyOwner);
    }

    /**
     * @return array
     */
    public function getAllLimitRowPerRequest()
    {
        return $this->subscriptionPlanMapper->getAllLimitRowPerRequest();
    }
}
