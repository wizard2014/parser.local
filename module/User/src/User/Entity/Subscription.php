<?php

namespace User\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Subscription
 *
 * @ORM\Table(name="subscription", indexes={@ORM\Index(name="IDX_A3C664D3A76ED395", columns={"user_id"}), @ORM\Index(name="IDX_A3C664D3C61772EE", columns={"data_source_global_id"}), @ORM\Index(name="IDX_A3C664D3B6596C08", columns={"subscription_type_id"}), @ORM\Index(name="IDX_A3C664D35948C201", columns={"subscription_status_id"})})
 * @ORM\Entity
 */
class Subscription
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="subscription_id_seq", allocationSize=1, initialValue=1)
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
     * @ORM\Column(name="subscription_status", type="string", length=50, nullable=true)
     */
    private $subscriptionStatus;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_creation", type="datetime", nullable=false)
     */
    private $dateCreation = 'now()';

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_activation", type="datetime", nullable=false)
     */
    private $dateActivation = 'now()';

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_expiration", type="datetime", nullable=false)
     */
    private $dateExpiration = '1 mon';

    /**
     * @var \User\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="User\Entity\User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user_id", referencedColumnName="user_id")
     * })
     */
    private $user;

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
     * @var \Utility\Entity\AttributeValue
     *
     * @ORM\ManyToOne(targetEntity="Utility\Entity\AttributeValue")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="subscription_status_id", referencedColumnName="id")
     * })
     */
    private $subscriptionStatus2;

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
     * @return Subscription
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
     * Set subscriptionStatus
     *
     * @param string $subscriptionStatus
     *
     * @return Subscription
     */
    public function setSubscriptionStatus($subscriptionStatus)
    {
        $this->subscriptionStatus = $subscriptionStatus;

        return $this;
    }

    /**
     * Get subscriptionStatus
     *
     * @return string
     */
    public function getSubscriptionStatus()
    {
        return $this->subscriptionStatus;
    }

    /**
     * Set dateCreation
     *
     * @param \DateTime $dateCreation
     *
     * @return Subscription
     */
    public function setDateCreation($dateCreation)
    {
        $this->dateCreation = $dateCreation;

        return $this;
    }

    /**
     * Get dateCreation
     *
     * @return \DateTime
     */
    public function getDateCreation()
    {
        return $this->dateCreation;
    }

    /**
     * Set dateActivation
     *
     * @param \DateTime $dateActivation
     *
     * @return Subscription
     */
    public function setDateActivation($dateActivation)
    {
        $this->dateActivation = $dateActivation;

        return $this;
    }

    /**
     * Get dateActivation
     *
     * @return \DateTime
     */
    public function getDateActivation()
    {
        return $this->dateActivation;
    }

    /**
     * Set dateExpiration
     *
     * @param \DateTime $dateExpiration
     *
     * @return Subscription
     */
    public function setDateExpiration($dateExpiration)
    {
        $this->dateExpiration = $dateExpiration;

        return $this;
    }

    /**
     * Get dateExpiration
     *
     * @return \DateTime
     */
    public function getDateExpiration()
    {
        return $this->dateExpiration;
    }

    /**
     * Set user
     *
     * @param \User\Entity\User $user
     *
     * @return Subscription
     */
    public function setUser(\User\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \User\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set dataSourceGlobal
     *
     * @param \Utility\Entity\DataSourceGlobal $dataSourceGlobal
     *
     * @return Subscription
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
     * @return Subscription
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

    /**
     * Set subscriptionStatus2
     *
     * @param \Utility\Entity\AttributeValue $subscriptionStatus2
     *
     * @return Subscription
     */
    public function setSubscriptionStatus2(\Utility\Entity\AttributeValue $subscriptionStatus2 = null)
    {
        $this->subscriptionStatus2 = $subscriptionStatus2;

        return $this;
    }

    /**
     * Get subscriptionStatus2
     *
     * @return \Utility\Entity\AttributeValue
     */
    public function getSubscriptionStatus2()
    {
        return $this->subscriptionStatus2;
    }
}
