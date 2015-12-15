<?php

namespace User\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Subscription
 *
 * @ORM\Table(name="subscription", indexes={@ORM\Index(name="IDX_A3C664D3A76ED395", columns={"user_id"}), @ORM\Index(name="IDX_A3C664D357C6BADE", columns={"subscription_scheme_id"}), @ORM\Index(name="IDX_A3C664D35948C201", columns={"subscription_status_id"})})
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
     * @var \DateTime
     *
     * @ORM\Column(name="date_creation", type="datetimetz", nullable=true)
     */
    private $dateCreation;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_activation", type="datetimetz", nullable=true)
     */
    private $dateActivation;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_expiration", type="datetimetz", nullable=true)
     */
    private $dateExpiration;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_blocked", type="boolean", nullable=false)
     */
    private $isBlocked = false;

    /**
     * @var integer
     *
     * @ORM\Column(name="request_counter_total", type="integer", nullable=false)
     */
    private $requestCounterTotal = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="request_counter_daily", type="integer", nullable=false)
     */
    private $requestCounterDaily = '0';

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_start_counter", type="datetimetz", nullable=true)
     */
    private $dateStartCounter;

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
     * @var \Utility\Entity\SubscriptionScheme
     *
     * @ORM\ManyToOne(targetEntity="Utility\Entity\SubscriptionScheme")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="subscription_scheme_id", referencedColumnName="id")
     * })
     */
    private $subscriptionScheme;

    /**
     * @var \Utility\Entity\AttributeValue
     *
     * @ORM\ManyToOne(targetEntity="Utility\Entity\AttributeValue")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="subscription_status_id", referencedColumnName="id")
     * })
     */
    private $subscriptionStatus;

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
     * Set isBlocked
     *
     * @param boolean $isBlocked
     *
     * @return Subscription
     */
    public function setIsBlocked($isBlocked)
    {
        $this->isBlocked = $isBlocked;

        return $this;
    }

    /**
     * Get isBlocked
     *
     * @return boolean
     */
    public function getIsBlocked()
    {
        return $this->isBlocked;
    }

    /**
     * Set requestCounterTotal
     *
     * @param integer $requestCounterTotal
     *
     * @return Subscription
     */
    public function setRequestCounterTotal($requestCounterTotal)
    {
        $this->requestCounterTotal = $requestCounterTotal;

        return $this;
    }

    /**
     * Get requestCounterTotal
     *
     * @return integer
     */
    public function getRequestCounterTotal()
    {
        return $this->requestCounterTotal;
    }

    /**
     * Set requestCounterDaily
     *
     * @param integer $requestCounterDaily
     *
     * @return Subscription
     */
    public function setRequestCounterDaily($requestCounterDaily)
    {
        $this->requestCounterDaily = $requestCounterDaily;

        return $this;
    }

    /**
     * Get requestCounterDaily
     *
     * @return integer
     */
    public function getRequestCounterDaily()
    {
        return $this->requestCounterDaily;
    }

    /**
     * Set dateStartCounter
     *
     * @param \DateTime $dateStartCounter
     *
     * @return Subscription
     */
    public function setDateStartCounter($dateStartCounter)
    {
        $this->dateStartCounter = $dateStartCounter;

        return $this;
    }

    /**
     * Get dateStartCounter
     *
     * @return \DateTime
     */
    public function getDateStartCounter()
    {
        return $this->dateStartCounter;
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
     * Set subscriptionScheme
     *
     * @param \Utility\Entity\SubscriptionScheme $subscriptionScheme
     *
     * @return Subscription
     */
    public function setSubscriptionScheme(\Utility\Entity\SubscriptionScheme $subscriptionScheme = null)
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

    /**
     * Set subscriptionStatus
     *
     * @param \Utility\Entity\AttributeValue $subscriptionStatus
     *
     * @return Subscription
     */
    public function setSubscriptionStatus(\Utility\Entity\AttributeValue $subscriptionStatus = null)
    {
        $this->subscriptionStatus = $subscriptionStatus;

        return $this;
    }

    /**
     * Get subscriptionStatus
     *
     * @return \Utility\Entity\AttributeValue
     */
    public function getSubscriptionStatus()
    {
        return $this->subscriptionStatus;
    }
}
