<?php

namespace Utility\Entity;

use Doctrine\ORM\Mapping as ORM;
use Utility\Entity\Traits\TimestampableTrait;

/**
 * SubscriptionPlan
 *
 * @ORM\Table(name="subscription_plan", indexes={@ORM\Index(name="IDX_EA664B6357C6BADE", columns={"subscription_scheme_id"})})
 * @ORM\Entity
 */
class SubscriptionPlan
{
    use TimestampableTrait;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_key_owner", type="boolean", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $isKeyOwner = false;

    /**
     * @var integer
     *
     * @ORM\Column(name="limit_row_per_request", type="integer", nullable=false)
     */
    private $limitRowPerRequest = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="limit_request_daily", type="integer", nullable=false)
     */
    private $limitRequestDaily = '0';

    /**
     * @var \Utility\Entity\SubscriptionScheme
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="Utility\Entity\SubscriptionScheme")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="subscription_scheme_id", referencedColumnName="id")
     * })
     */
    private $subscriptionScheme;

    /**
     * Set isKeyOwner
     *
     * @param boolean $isKeyOwner
     *
     * @return SubscriptionPlan
     */
    public function setIsKeyOwner($isKeyOwner)
    {
        $this->isKeyOwner = $isKeyOwner;

        return $this;
    }

    /**
     * Get isKeyOwner
     *
     * @return boolean
     */
    public function getIsKeyOwner()
    {
        return $this->isKeyOwner;
    }

    /**
     * Set limitRowPerRequest
     *
     * @param integer $limitRowPerRequest
     *
     * @return SubscriptionPlan
     */
    public function setLimitRowPerRequest($limitRowPerRequest)
    {
        $this->limitRowPerRequest = $limitRowPerRequest;

        return $this;
    }

    /**
     * Get limitRowPerRequest
     *
     * @return integer
     */
    public function getLimitRowPerRequest()
    {
        return $this->limitRowPerRequest;
    }

    /**
     * Set limitRequestDaily
     *
     * @param integer $limitRequestDaily
     *
     * @return SubscriptionPlan
     */
    public function setLimitRequestDaily($limitRequestDaily)
    {
        $this->limitRequestDaily = $limitRequestDaily;

        return $this;
    }

    /**
     * Get limitRequestDaily
     *
     * @return integer
     */
    public function getLimitRequestDaily()
    {
        return $this->limitRequestDaily;
    }

    /**
     * Set subscriptionScheme
     *
     * @param \Utility\Entity\SubscriptionScheme $subscriptionScheme
     *
     * @return SubscriptionPlan
     */
    public function setSubscriptionScheme(\Utility\Entity\SubscriptionScheme $subscriptionScheme)
    {
        $this->subscriptionScheme = $subscriptionScheme;

        return $this;
    }

    /**
     * Get subscriptionScheme
     *
     * @return \Utility\Entity\SubscriptionScheme
     */
    public function getSubscriptionScheme()
    {
        return $this->subscriptionScheme;
    }
}
