<?php

namespace User\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UserAddition
 *
 * @ORM\Table(name="user_addition")
 * @ORM\Entity
 */
class UserAddition
{
    /**
     * @var boolean
     *
     * @ORM\Column(name="is_subscriber", type="boolean", precision=0, scale=0, nullable=false, unique=false)
     */
    private $isSubscriber;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_key_owner", type="boolean", precision=0, scale=0, nullable=false, unique=false)
     */
    private $isKeyOwner;

    /**
     * @var \User\Entity\User
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="User\Entity\User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user_id", referencedColumnName="user_id", nullable=true)
     * })
     */
    private $user;

    /**
     * Set isSubscriber
     *
     * @param boolean $isSubscriber
     *
     * @return UserAddition
     */
    public function setIsSubscriber($isSubscriber)
    {
        $this->isSubscriber = $isSubscriber;

        return $this;
    }

    /**
     * Get isSubscriber
     *
     * @return boolean
     */
    public function getIsSubscriber()
    {
        return $this->isSubscriber;
    }

    /**
     * Set isKeyOwner
     *
     * @param boolean $isKeyOwner
     *
     * @return UserAddition
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
     * Set user
     *
     * @param \User\Entity\User $user
     *
     * @return UserAddition
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
