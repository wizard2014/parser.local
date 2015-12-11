<?php

namespace User\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * RequestLog
 *
 * @ORM\Table(name="request_log", indexes={@ORM\Index(name="IDX_421529899A1887DC", columns={"subscription_id"})})
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
     * @ORM\Column(name="request_time", type="datetimetz", nullable=false)
     */
    private $requestTime = 'now()';

    /**
     * @var integer
     *
     * @ORM\Column(name="qty_rows", type="integer", nullable=false)
     */
    private $qtyRows = '0';

    /**
     * @var \User\Entity\Subscription
     *
     * @ORM\ManyToOne(targetEntity="User\Entity\Subscription")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="subscription_id", referencedColumnName="id")
     * })
     */
    private $subscription;

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
     * Set subscription
     *
     * @param \User\Entity\Subscription $subscription
     *
     * @return RequestLog
     */
    public function setSubscription(\User\Entity\Subscription $subscription = null)
    {
        $this->subscription = $subscription;

        return $this;
    }

    /**
     * Get subscription
     *
     * @return \User\Entity\Subscription
     */
    public function getSubscription()
    {
        return $this->subscription;
    }
}
