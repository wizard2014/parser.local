<?php

namespace User\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UserStatus
 *
 * @ORM\Table(name="user_status")
 * @ORM\Entity
 */
class UserStatus
{
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_registration", type="datetimetz", nullable=false)
     */
    private $dateRegistration = 'now()';

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_email_subscriber", type="boolean", nullable=false)
     */
    private $isEmailSubscriber = false;

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
     * @var \User\Entity\User
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="User\Entity\User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user_id", referencedColumnName="user_id")
     * })
     */
    private $user;

    /**
     * Set dateRegistration
     *
     * @param \DateTime $dateRegistration
     *
     * @return UserStatus
     */
    public function setDateRegistration($dateRegistration)
    {
        $this->dateRegistration = $dateRegistration;

        return $this;
    }

    /**
     * Get dateRegistration
     *
     * @return \DateTime
     */
    public function getDateRegistration()
    {
        return $this->dateRegistration;
    }

    /**
     * Set isEmailSubscriber
     *
     * @param boolean $isEmailSubscriber
     *
     * @return UserStatus
     */
    public function setIsEmailSubscriber($isEmailSubscriber)
    {
        $this->isEmailSubscriber = $isEmailSubscriber;

        return $this;
    }

    /**
     * Get isEmailSubscriber
     *
     * @return boolean
     */
    public function getIsEmailSubscriber()
    {
        return $this->isEmailSubscriber;
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
     * Set user
     *
     * @param \User\Entity\User $user
     *
     * @return UserStatus
     */
    public function setUser(\User\Entity\User $user)
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
}
