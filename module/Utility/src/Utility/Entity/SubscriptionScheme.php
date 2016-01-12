<?php

namespace Utility\Entity;

use Doctrine\ORM\Mapping as ORM;
use Utility\Entity\Traits\TimestampableTrait;

/**
 * SubscriptionScheme
 *
 * @ORM\Table(name="subscription_scheme", uniqueConstraints={@ORM\UniqueConstraint(name="subscription_scheme_unique", columns={"data_source_global_id", "subscription_type_id"})}, indexes={@ORM\Index(name="IDX_76159DCCC61772EE", columns={"data_source_global_id"}), @ORM\Index(name="IDX_76159DCCB6596C08", columns={"subscription_type_id"})})
 * @ORM\Entity
 */
class SubscriptionScheme
{
    use TimestampableTrait;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="subscription_scheme_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="subscription_type", type="string", length=50, nullable=true)
     */
    private $subscriptionType;

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
     * @return SubscriptionScheme
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
     * Set price
     *
     * @param string $price
     *
     * @return SubscriptionScheme
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
     * @return SubscriptionScheme
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
     * @return SubscriptionScheme
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
