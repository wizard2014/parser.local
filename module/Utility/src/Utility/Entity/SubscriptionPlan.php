<?php

namespace Utility\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SubscriptionPlan
 *
 * @ORM\Table(name="subscription_plan", uniqueConstraints={@ORM\UniqueConstraint(name="subscription_plan_unique", columns={"data_source_global_id", "subscription_type_id", "is_key_owner"})}, indexes={@ORM\Index(name="IDX_EA664B63C61772EE", columns={"data_source_global_id"}), @ORM\Index(name="IDX_EA664B63B6596C08", columns={"subscription_type_id"})})
 * @ORM\Entity
 */
class SubscriptionPlan
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="subscription_plan_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="subscription_type", type="string", length=50, nullable=true)
     */
    private $subscriptionType;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_key_owner", type="boolean", nullable=false)
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
     * @var string
     *
     * @ORM\Column(name="price", type="decimal", precision=10, scale=0, nullable=false)
     */
    private $price = '0';

    /**
     * @var \Utility\Entity\DataSourceGlobal
     *
     * @ORM\ManyToOne(targetEntity="Utility\Entity\DataSourceGlobal")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="data_source_global_id", referencedColumnName="id")
     * })
     */
    private $dataSourceGlobal;

    /**
     * @var \Utility\Entity\AttributeValue
     *
     * @ORM\ManyToOne(targetEntity="Utility\Entity\AttributeValue")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="subscription_type_id", referencedColumnName="id")
     * })
     */
    private $subscriptionType2;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set subscriptionType
     *
     * @param string $subscriptionType
     *
     * @return SubscriptionPlan
     */
    public function setSubscriptionType($subscriptionType)
    {
        $this->subscriptionType = $subscriptionType;

        return $this;
    }

    /**
     * Get subscriptionType
     *
     * @return string
     */
    public function getSubscriptionType()
    {
        return $this->subscriptionType;
    }

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
     * Set price
     *
     * @param string $price
     *
     * @return SubscriptionPlan
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return string
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set dataSourceGlobal
     *
     * @param \Utility\Entity\DataSourceGlobal $dataSourceGlobal
     *
     * @return SubscriptionPlan
     */
    public function setDataSourceGlobal(\Utility\Entity\DataSourceGlobal $dataSourceGlobal = null)
    {
        $this->dataSourceGlobal = $dataSourceGlobal;

        return $this;
    }

    /**
     * Get dataSourceGlobal
     *
     * @return \Utility\Entity\DataSourceGlobal
     */
    public function getDataSourceGlobal()
    {
        return $this->dataSourceGlobal;
    }

    /**
     * Set subscriptionType2
     *
     * @param \Utility\Entity\AttributeValue $subscriptionType2
     *
     * @return SubscriptionPlan
     */
    public function setSubscriptionType2(\Utility\Entity\AttributeValue $subscriptionType2 = null)
    {
        $this->subscriptionType2 = $subscriptionType2;

        return $this;
    }

    /**
     * Get subscriptionType2
     *
     * @return \Utility\Entity\AttributeValue
     */
    public function getSubscriptionType2()
    {
        return $this->subscriptionType2;
    }
}
