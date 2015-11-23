<?php

namespace User\Mapper;

use Doctrine\ORM\EntityManagerInterface;

class User
{
    /**
     * @var EntityManagerInterface
     */
    protected $em;

    /**
     * @var \User\Entity\User
     */
    protected $userEntity = \User\Entity\User::class;

    /**
     * {@inheritdoc}
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @return \User\Entity\User
     */
    public function getUserEntity()
    {
        return $this->userEntity;
    }

    /**
     * @param \User\Entity\User $userEntity
     */
    public function setUserEntity($userEntity)
    {
        $this->userEntity = $userEntity;
    }

    /**
     * @param $userId
     *
     * @return \User\Entity\User
     */
    public function getUserById($userId)
    {
        $entity = $this->getUserEntity();

        $user = $this->em->find($entity, $userId);

        return $user;
    }

    /**
     * @param $userEmail
     *
     * @return \ZfcUser\Entity\UserInterface
     */
    public function getUserByEmail($userEmail)
    {
        $entity = $this->getUserEntity();

        $user = $this->em->getRepository($entity)->findOneBy(['email' => $userEmail]);

        return $user;
    }

    /**
     * @param $userEmail
     *
     * @return bool
     */
    public function userExists($userEmail)
    {
        return (bool)count((array)$this->getUserByEmail($userEmail));
    }
}
