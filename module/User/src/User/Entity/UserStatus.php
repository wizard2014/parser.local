<?php

namespace User\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UserStatus
 *
 * @ORM\Table(name="user_status", uniqueConstraints={@ORM\UniqueConstraint(name="user_status_unique", columns={"user_id", "data_source_global_id"})}, indexes={@ORM\Index(name="IDX_1E527E21A76ED395", columns={"user_id"}), @ORM\Index(name="IDX_1E527E21C61772EE", columns={"data_source_global_id"}), @ORM\Index(name="IDX_1E527E21B6596C08", columns={"subscription_type_id"}), @ORM\Index(name="IDX_1E527E215948C201", columns={"subscription_status_id"})})
 * @ORM\Entity
 */
class UserStatus
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="user_status_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var integer
     *
     * @ORM\Column(name="timezone", type="integer", nullable=true)
     */
    private $timezone = '0';

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_key_owner", type="boolean", nullable=false)
     */
    private $isKeyOwner = false;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_valid_key", type="boolean", nullable=false)
     */
    private $isValidKey = true;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_blocked_free", type="boolean", nullable=false)
     */
    private $isBlockedFree = false;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_blocked_subscr", type="boolean", nullable=false)
     */
    private $isBlockedSubscr = true;

    /**
     * @var integer
     *
     * @ORM\Column(name="limit_daily_free", type="integer", nullable=false)
     */
    private $limitDailyFree = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="limit_daily_subscr", type="integer", nullable=false)
     */
    private $limitDailySubscr = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="qty_daily_free", type="integer", nullable=false)
     */
    private $qtyDailyFree = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="qty_daily_subscr", type="integer", nullable=false)
     */
    private $qtyDailySubscr = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="qty_total_free", type="integer", nullable=false)
     */
    private $qtyTotalFree = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="qty_total_subscr", type="integer", nullable=false)
     */
    private $qtyTotalSubscr = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="qty_total", type="integer", nullable=false)
     */
    private $qtyTotal = '0';

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
     * @ORM\Column(name="subscription_date_creation", type="datetime", nullable=true)
     */
    private $subscriptionDateCreation = '1970-01-01 00:00:00';

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="subscription_date_activation", type="datetime", nullable=true)
     */
    private $subscriptionDateActivation = '1970-01-01 00:00:00';

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="subscription_date_expiration", type="datetime", nullable=true)
     */
    private $subscriptionDateExpiration = '1970-01-01 00:00:00';

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
     * Set timezone
     *
     * @param integer $timezone
     *
     * @return UserStatus
     */
    public function setTimezone($timezone)
    {
        $this->timezone = $timezone;

        return $this;
    }

    /**
     * Get timezone
     *
     * @return integer
     */
    public function getTimezone()
    {
        return $this->timezone;
    }

    /**
     * Set isKeyOwner
     *
     * @param boolean $isKeyOwner
     *
     * @return UserStatus
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
     * Set isValidKey
     *
     * @param boolean $isValidKey
     *
     * @return UserStatus
     */
    public function setIsValidKey($isValidKey)
    {
        $this->isValidKey = $isValidKey;

        return $this;
    }

    /**
     * Get isValidKey
     *
     * @return boolean
     */
    public function getIsValidKey()
    {
        return $this->isValidKey;
    }

    /**
     * Set isBlockedFree
     *
     * @param boolean $isBlockedFree
     *
     * @return UserStatus
     */
    public function setIsBlockedFree($isBlockedFree)
    {
        $this->isBlockedFree = $isBlockedFree;

        return $this;
    }

    /**
     * Get isBlockedFree
     *
     * @return boolean
     */
    public function getIsBlockedFree()
    {
        return $this->isBlockedFree;
    }

    /**
     * Set isBlockedSubscr
     *
     * @param boolean $isBlockedSubscr
     *
     * @return UserStatus
     */
    public function setIsBlockedSubscr($isBlockedSubscr)
    {
        $this->isBlockedSubscr = $isBlockedSubscr;

        return $this;
    }

    /**
     * Get isBlockedSubscr
     *
     * @return boolean
     */
    public function getIsBlockedSubscr()
    {
        return $this->isBlockedSubscr;
    }

    /**
     * Set limitDailyFree
     *
     * @param integer $limitDailyFree
     *
     * @return UserStatus
     */
    public function setLimitDailyFree($limitDailyFree)
    {
        $this->limitDailyFree = $limitDailyFree;

        return $this;
    }

    /**
     * Get limitDailyFree
     *
     * @return integer
     */
    public function getLimitDailyFree()
    {
        return $this->limitDailyFree;
    }

    /**
     * Set limitDailySubscr
     *
     * @param integer $limitDailySubscr
     *
     * @return UserStatus
     */
    public function setLimitDailySubscr($limitDailySubscr)
    {
        $this->limitDailySubscr = $limitDailySubscr;

        return $this;
    }

    /**
     * Get limitDailySubscr
     *
     * @return integer
     */
    public function getLimitDailySubscr()
    {
        return $this->limitDailySubscr;
    }

    /**
     * Set qtyDailyFree
     *
     * @param integer $qtyDailyFree
     *
     * @return UserStatus
     */
    public function setQtyDailyFree($qtyDailyFree)
    {
        $this->qtyDailyFree = $qtyDailyFree;

        return $this;
    }

    /**
     * Get qtyDailyFree
     *
     * @return integer
     */
    public function getQtyDailyFree()
    {
        return $this->qtyDailyFree;
    }

    /**
     * Set qtyDailySubscr
     *
     * @param integer $qtyDailySubscr
     *
     * @return UserStatus
     */
    public function setQtyDailySubscr($qtyDailySubscr)
    {
        $this->qtyDailySubscr = $qtyDailySubscr;

        return $this;
    }

    /**
     * Get qtyDailySubscr
     *
     * @return integer
     */
    public function getQtyDailySubscr()
    {
        return $this->qtyDailySubscr;
    }

    /**
     * Set qtyTotalFree
     *
     * @param integer $qtyTotalFree
     *
     * @return UserStatus
     */
    public function setQtyTotalFree($qtyTotalFree)
    {
        $this->qtyTotalFree = $qtyTotalFree;

        return $this;
    }

    /**
     * Get qtyTotalFree
     *
     * @return integer
     */
    public function getQtyTotalFree()
    {
        return $this->qtyTotalFree;
    }

    /**
     * Set qtyTotalSubscr
     *
     * @param integer $qtyTotalSubscr
     *
     * @return UserStatus
     */
    public function setQtyTotalSubscr($qtyTotalSubscr)
    {
        $this->qtyTotalSubscr = $qtyTotalSubscr;

        return $this;
    }

    /**
     * Get qtyTotalSubscr
     *
     * @return integer
     */
    public function getQtyTotalSubscr()
    {
        return $this->qtyTotalSubscr;
    }

    /**
     * Set qtyTotal
     *
     * @param integer $qtyTotal
     *
     * @return UserStatus
     */
    public function setQtyTotal($qtyTotal)
    {
        $this->qtyTotal = $qtyTotal;

        return $this;
    }

    /**
     * Get qtyTotal
     *
     * @return integer
     */
    public function getQtyTotal()
    {
        return $this->qtyTotal;
    }

    /**
     * Set subscriptionType
     *
     * @param string $subscriptionType
     *
     * @return UserStatus
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
     * @return UserStatus
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
     * Set subscriptionDateCreation
     *
     * @param \DateTime $subscriptionDateCreation
     *
     * @return UserStatus
     */
    public function setSubscriptionDateCreation($subscriptionDateCreation)
    {
        $this->subscriptionDateCreation = $subscriptionDateCreation;

        return $this;
    }

    /**
     * Get subscriptionDateCreation
     *
     * @return \DateTime
     */
    public function getSubscriptionDateCreation()
    {
        return $this->subscriptionDateCreation;
    }

    /**
     * Set subscriptionDateActivation
     *
     * @param \DateTime $subscriptionDateActivation
     *
     * @return UserStatus
     */
    public function setSubscriptionDateActivation($subscriptionDateActivation)
    {
        $this->subscriptionDateActivation = $subscriptionDateActivation;

        return $this;
    }

    /**
     * Get subscriptionDateActivation
     *
     * @return \DateTime
     */
    public function getSubscriptionDateActivation()
    {
        return $this->subscriptionDateActivation;
    }

    /**
     * Set subscriptionDateExpiration
     *
     * @param \DateTime $subscriptionDateExpiration
     *
     * @return UserStatus
     */
    public function setSubscriptionDateExpiration($subscriptionDateExpiration)
    {
        $this->subscriptionDateExpiration = $subscriptionDateExpiration;

        return $this;
    }

    /**
     * Get subscriptionDateExpiration
     *
     * @return \DateTime
     */
    public function getSubscriptionDateExpiration()
    {
        return $this->subscriptionDateExpiration;
    }

    /**
     * Set user
     *
     * @param \User\Entity\User $user
     *
     * @return UserStatus
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
     * @return UserStatus
     */
    public function setDataSourceGlobal(\Utility\Entity\DataSourceGlobal $dataSourceGlobal = null)
    {
        $this->dataSourceGlobal = $dataSourceGlobal;

        return $this;
    }

    /**
     * Get dataSourceGlobal
     *
     * @return \User\Entity\DataSourceGlobal
     */
    public function getDataSourceGlobal()
    {
        return $this->dataSourceGlobal;
    }

    /**
     * Set subscriptionType2
     *
     * @param \User\Entity\AttributeValue $subscriptionType2
     *
     * @return UserStatus
     */
    public function setSubscriptionType2(\User\Entity\AttributeValue $subscriptionType2 = null)
    {
        $this->subscriptionType2 = $subscriptionType2;

        return $this;
    }

    /**
     * Get subscriptionType2
     *
     * @return \User\Entity\AttributeValue
     */
    public function getSubscriptionType2()
    {
        return $this->subscriptionType2;
    }

    /**
     * Set subscriptionStatus2
     *
     * @param \User\Entity\AttributeValue $subscriptionStatus2
     *
     * @return UserStatus
     */
    public function setSubscriptionStatus2(\User\Entity\AttributeValue $subscriptionStatus2 = null)
    {
        $this->subscriptionStatus2 = $subscriptionStatus2;

        return $this;
    }

    /**
     * Get subscriptionStatus2
     *
     * @return \User\Entity\AttributeValue
     */
    public function getSubscriptionStatus2()
    {
        return $this->subscriptionStatus2;
    }
}
