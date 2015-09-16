<?php

namespace User\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * RequestLog
 *
 * @ORM\Table(name="request_log", indexes={@ORM\Index(name="IDX_42152989A76ED395", columns={"user_id"}), @ORM\Index(name="IDX_42152989C61772EE", columns={"data_source_global_id"}), @ORM\Index(name="IDX_4215298918CFB4CA", columns={"data_source_regional_id"}), @ORM\Index(name="IDX_42152989B6596C08", columns={"subscription_type_id"}), @ORM\Index(name="IDX_42152989EF68FEC4", columns={"request_type_id"})})
 * @ORM\Entity
 */
class RequestLog
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="request_log_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="request_time", type="datetime", nullable=false)
     */
    private $requestTime = 'now()';

    /**
     * @var integer
     *
     * @ORM\Column(name="qty_rows", type="integer", nullable=false)
     */
    private $qtyRows = '0';

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
     * @var \Utility\Entity\DataSourceRegional
     *
     * @ORM\ManyToOne(targetEntity="Utility\Entity\DataSourceRegional")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="data_source_regional_id", referencedColumnName="id")
     * })
     */
    private $dataSourceRegional;

    /**
     * @var \Utility\Entity\AttributeValue
     *
     * @ORM\ManyToOne(targetEntity="Utility\Entity\AttributeValue")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="subscription_type_id", referencedColumnName="id")
     * })
     */
    private $subscriptionType;

    /**
     * @var \Utility\Entity\AttributeValue
     *
     * @ORM\ManyToOne(targetEntity="Utility\Entity\AttributeValue")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="request_type_id", referencedColumnName="id")
     * })
     */
    private $requestType;

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
     * Set requestTime
     *
     * @param \DateTime $requestTime
     *
     * @return RequestLog
     */
    public function setRequestTime($requestTime)
    {
        $this->requestTime = $requestTime;

        return $this;
    }

    /**
     * Get requestTime
     *
     * @return \DateTime
     */
    public function getRequestTime()
    {
        return $this->requestTime;
    }

    /**
     * Set qtyRows
     *
     * @param integer $qtyRows
     *
     * @return RequestLog
     */
    public function setQtyRows($qtyRows)
    {
        $this->qtyRows = $qtyRows;

        return $this;
    }

    /**
     * Get qtyRows
     *
     * @return integer
     */
    public function getQtyRows()
    {
        return $this->qtyRows;
    }

    /**
     * Set user
     *
     * @param \User\Entity\User $user
     *
     * @return RequestLog
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
     * @return RequestLog
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
     * Set dataSourceRegional
     *
     * @param \Utility\Entity\DataSourceRegional $dataSourceRegional
     *
     * @return RequestLog
     */
    public function setDataSourceRegional(\Utility\Entity\DataSourceRegional $dataSourceRegional = null)
    {
        $this->dataSourceRegional = $dataSourceRegional;

        return $this;
    }

    /**
     * Get dataSourceRegional
     *
     * @return \Utility\Entity\DataSourceRegional
     */
    public function getDataSourceRegional()
    {
        return $this->dataSourceRegional;
    }

    /**
     * Set subscriptionType
     *
     * @param \Utility\Entity\AttributeValue $subscriptionType
     *
     * @return RequestLog
     */
    public function setSubscriptionType(\Utility\Entity\AttributeValue $subscriptionType = null)
    {
        $this->subscriptionType = $subscriptionType;

        return $this;
    }

    /**
     * Get subscriptionType
     *
     * @return \Utility\Entity\AttributeValue
     */
    public function getSubscriptionType()
    {
        return $this->subscriptionType;
    }

    /**
     * Set requestType
     *
     * @param \Utility\Entity\AttributeValue $requestType
     *
     * @return RequestLog
     */
    public function setRequestType(\Utility\Entity\AttributeValue $requestType = null)
    {
        $this->requestType = $requestType;

        return $this;
    }

    /**
     * Get requestType
     *
     * @return \Utility\Entity\AttributeValue
     */
    public function getRequestType()
    {
        return $this->requestType;
    }
}
