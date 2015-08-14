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
    protected $tradingApiVersion  = '933';
    protected $token              = '';
    protected $region = [
        'EBAY-US',      // United States
        'EBAY-ENCA',    // Canada (English)
        'EBAY-GB',      // UK
        'EBAY-AU',      // Australia
        'EBAY-IN',      // India
        'EBAY-IE',      // Ireland
        'EBAY-MY',      // Malaysia
        'EBAY-PH',      // Philippines
        'EBAY-SG',      // Singapore
    ];
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
    protected $countryCodeType  = [
        'US'
    ];
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
     * @return string
     */
    public function getTradingApiVersion()
    {
        return $this->tradingApiVersion;
    }

    /**
     * @param string $tradingApiVersion
     */
    public function setTradingApiVersion($tradingApiVersion)
    {
        $this->tradingApiVersion = $tradingApiVersion;
    }

    /**
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * @param string $token
     */
    public function setToken($token)
    {
        $this->token = $token;
    }

    /**
     * @return array
     */
    public function getRegion()
    {
        return $this->region;
    }

    /**
     * @param array $region
     */
    public function setRegion($region)
    {
        $this->region = $region;
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
