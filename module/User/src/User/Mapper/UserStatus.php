<?php

namespace User\Mapper;

use Doctrine\ORM\EntityManagerInterface;

class UserStatus
{
    /**
     * @var EntityManagerInterface
     */
    protected $em;

    /**
     * @var \User\Entity\UserStatus
     */
    protected $userStatusEntity = \User\Entity\UserStatus::class;

    /**
     * {@inheritdoc}
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @return \User\Entity\UserStatus
     */
    public function getUserStatusEntity()
    {
        return $this->userStatusEntity;
    }

    /**
     * @param \User\Entity\UserStatus $userStatusEntity
     */
    public function setUserStatusEntity($userStatusEntity)
    {
        $this->userStatusEntity = $userStatusEntity;
    }


}
