<?php

namespace User\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UserRegistration
 *
 * @ORM\Table(name="user_registration", uniqueConstraints={@ORM\UniqueConstraint(name="token_unique", columns={"token"})})
 * @ORM\Entity
 */
class UserRegistration
{
    /**
     * @var string
     *
     * @ORM\Column(name="token", type="string", length=16, nullable=false)
     */
    private $token;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="request_time", type="datetime", nullable=false)
     */
    private $requestTime;

    /**
     * @var integer
     *
     * @ORM\Column(name="responded", type="smallint", nullable=false)
     */
    private $responded = '0';

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
     * Set token
     *
     * @param string $token
     *
     * @return UserRegistration
     */
    public function setToken($token)
    {
        $this->token = $token;

        return $this;
    }

    /**
     * Get token
     *
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * Set requestTime
     *
     * @param \DateTime $requestTime
     *
     * @return UserRegistration
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
     * Set responded
     *
     * @param integer $responded
     *
     * @return UserRegistration
     */
    public function setResponded($responded)
    {
        $this->responded = $responded;

        return $this;
    }

    /**
     * Get responded
     *
     * @return integer
     */
    public function getResponded()
    {
        return $this->responded;
    }

    /**
     * Set user
     *
     * @param \User\Entity\User $user
     *
     * @return UserRegistration
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
