<?php

namespace Ebay\Options;

use Zend\Stdlib\AbstractOptions;

/**
 * Class ModuleOptions
 *
 * @package Application\Options
 */
class ModuleOptions extends AbstractOptions
{
    protected $appId;
    protected $findingApiVersion  = '1.13.0';
    protected $shoppingApiVersion = '897';
    protected $sortOrder = [
        'BestMatch'                 => 'Best Match',
        'BidCountFewest'            => 'Bid Count Fewest',
        'BidCountMost'              => 'Bid Count Most',
        'CountryAscending'          => 'Country Ascending',
        'CountryDescending'         => 'Country Descending',
        'CurrentPriceHighest'       => 'Current Highest Price',
        'DistanceNearest'           => 'Nearest Distance',
        'EndTimeSoonest'            => 'End Time Soonest',
        'PricePlusShippingHighest'  => 'Price Plus Shipping Highest',
        'PricePlusShippingLowest'   => 'Price Plus Shipping Lowest',
        'StartTimeNewest'           => 'Start Time Newest'
    ];
    protected $postalCode       = '';
    protected $countryCodeType  = [
        'US'
    ];
    protected $categories       = [];
    protected $delimiter        = ',';

    /**
     * @return mixed
     */
    public function getAppId()
    {
        return $this->appId;
    }

    /**
     * @param mixed $appId
     */
    public function setAppId($appId)
    {
        $this->appId = $appId;
    }

    /**
     * @return string
     */
    public function getFindingApiVersion()
    {
        return $this->findingApiVersion;
    }

    /**
     * @param string $findingApiVersion
     */
    public function setFindingApiVersion($findingApiVersion)
    {
        $this->findingApiVersion = $findingApiVersion;
    }

    /**
     * @return string
     */
    public function getShoppingApiVersion()
    {
        return $this->shoppingApiVersion;
    }

    /**
     * @param string $shoppingApiVersion
     */
    public function setShoppingApiVersion($shoppingApiVersion)
    {
        $this->shoppingApiVersion = $shoppingApiVersion;
    }

    /**
     * @return array
     */
    public function getSortOrder()
    {
        return $this->sortOrder;
    }

    /**
     * @param array $sortOrder
     */
    public function setSortOrder($sortOrder)
    {
        $this->sortOrder = $sortOrder;
    }

    /**
     * @return string
     */
    public function getPostalCode()
    {
        return $this->postalCode;
    }

    /**
     * @param string $postalCode
     */
    public function setPostalCode($postalCode)
    {
        $this->postalCode = $postalCode;
    }

    /**
     * @return array
     */
    public function getCountryCodeType()
    {
        return $this->countryCodeType;
    }

    /**
     * @param array $countryCodeType
     */
    public function setCountryCodeType($countryCodeType)
    {
        $this->countryCodeType = $countryCodeType;
    }

    /**
     * @return string
     */
    public function getDelimiter()
    {
        return $this->delimiter;
    }

    /**
     * @param string $delimiter
     */
    public function setDelimiter($delimiter)
    {
        $this->delimiter = $delimiter;
    }
}
