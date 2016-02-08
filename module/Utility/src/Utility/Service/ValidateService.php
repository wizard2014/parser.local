<?php

namespace Utility\Service;

use Utility\Mapper\DataSourceKeyMapper;
use Utility\Mapper\DataSourceGlobalMapper;
use Utility\Mapper\DataSourceRegionalMapper;
use User\Mapper\SubscriptionMapper;
use Utility\Mapper\SubscriptionPlanMapper;

class ValidateService implements ValidateServiceInterface
{
    /**
     * @var DataSourceKeyMapper
     */
    protected $dataSourceKeyMapper;

    /**
     * @var DataSourceGlobalMapper
     */
    protected $dataSourceGlobalMapper;

    /**
     * @var DataSourceRegionalMapper
     */
    protected $dataSourceRegionalMapper;

    /**
     * @var SubscriptionMapper
     */
    protected $subscriptionMapper;

    /**
     * @var SubscriptionPlanMapper
     */
    protected $subscriptionPlanMapper;

    /**
     * ValidateService constructor.
     *
     * @param DataSourceKeyMapper      $dataSourceKeyMapper
     * @param DataSourceGlobalMapper   $dataSourceGlobalMapper
     * @param DataSourceRegionalMapper $dataSourceRegionalMapper
     * @param SubscriptionMapper       $subscriptionMapper
     * @param SubscriptionPlanMapper   $subscriptionPlanMapper
     */
    public function __construct(
        DataSourceKeyMapper      $dataSourceKeyMapper,
        DataSourceGlobalMapper   $dataSourceGlobalMapper,
        DataSourceRegionalMapper $dataSourceRegionalMapper,
        SubscriptionMapper       $subscriptionMapper,
        SubscriptionPlanMapper   $subscriptionPlanMapper
    ) {
        $this->dataSourceKeyMapper      = $dataSourceKeyMapper;
        $this->dataSourceGlobalMapper   = $dataSourceGlobalMapper;
        $this->dataSourceRegionalMapper = $dataSourceRegionalMapper;
        $this->subscriptionMapper       = $subscriptionMapper;
        $this->subscriptionPlanMapper   = $subscriptionPlanMapper;
    }

    public function validateFormData($vendor, $data, $userId)
    {
        $errors = [];

        if (!empty($data['minPrice']) && !is_numeric($data['minPrice'])) {
            $errors['minPrice'] = '[Min Price] should be a number.';
        }

        if (!empty($data['maxPrice']) && !is_numeric($data['maxPrice'])) {
            $errors['maxPrice'] = '[Max Price] should be a number.';
        }

        if (!$this->dataSourceGlobalMapper->sortOrderExists($vendor, $data['sortOrder'])) {
            $errors['sortOrder'] = 'Invalid [Sort Order].';
        }

        if (!empty($data['listingType']) && !$this->dataSourceGlobalMapper->listingTypeExists($vendor, $data['listingType'])) {
            $errors['listingType'] = 'Invalid [Listing Type].';
        }

        if (!$this->dataSourceGlobalMapper->regionExists($data['region'])) {
            $errors['region'] = 'Invalid [Region].';
        } else {
            // seb info
            $sub = $this->subscriptionMapper->getActiveSubscription($userId, $data['region']);

            $subscriptionPlan = $this->subscriptionPlanMapper->getUserSubscriptionPlan(
                $sub->getSubscriptionScheme(),
                $this->dataSourceKeyMapper->keyExists($userId, $data['region'])
            );

            $limitPerRequest = $subscriptionPlan->getLimitRowPerRequest();

            if ($data['itemsQty'] > $limitPerRequest) {
                $errors['itemsQty'] = 'Invalid [Items qty].';
            }
        }

        return $errors;
    }
}
