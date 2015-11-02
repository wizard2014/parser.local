<?php

namespace User\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\Math\Rand;
use ZfcUser\Entity\UserInterface;
use HtUserRegistration\Entity\UserRegistrationInterface;

/**
 * UserRegistration
 *
 * @ORM\Table(name="user_registration", uniqueConstraints={@ORM\UniqueConstraint(name="token_unique", columns={"token"})})
 * @ORM\Entity
 */
class UserRegistration implements UserRegistrationInterface
{
    // length of request key
    const REQUEST_KEY_LENGTH = 16;

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
     * Constructor
     * Intiliazes the entity
     *
     * @param UserInterface|null $user
     */
    public function __construct(UserInterface $user = null)
    {
        $this->requestTime = new \DateTime;
        if ($user) {
            $this->setUser($user);
        }
    }

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
     * {@inheritDoc}
     */
    public function generateToken()
    {
        $this->setToken(Rand::getString(static::REQUEST_KEY_LENGTH, 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789', true));
    }

    /**
     * Set requestTime
     *
     * @param \DateTime $requestTime
     *
     * @return UserRegistration
     */
    public function setRequestTime(\DateTime $requestTime)
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
     * {@inheritDoc}
     */
    public function isResponded()
    {
        return $this->responded;
    }

    /**
     * @param UserInterface $user
     *
     * @return $this
     */
    public function setUser(UserInterface $user)
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
