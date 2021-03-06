<?php

namespace User\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

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
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(name="request_time", type="datetimetz", nullable=true)
     */
    private $requestTime;

    /**
     * @var array
     *
     * @ORM\Column(name="property_set", type="json_array", nullable=true)
     */
    private $propertySet;

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
     * Set propertySet
     *
     * @param array $propertySet
     *
     * @return RequestLog
     */
    public function setPropertySet($propertySet)
    {
        $this->propertySet = $propertySet;

        return $this;
    }

    /**
     * Get propertySet
     *
     * @return array
     */
    public function getPropertySet()
    {
        return $this->propertySet;
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
