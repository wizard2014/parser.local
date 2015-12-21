<?php

namespace User\Mapper;

use Doctrine\ORM\EntityManagerInterface;

class UserMapper implements UserMapperInterface
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
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * {@inheritdoc}
     */
    public function getUserEntity()
    {
        return $this->userEntity;
    }

    /**
     * {@inheritdoc}
     */
    public function setUserEntity($userEntity)
    {
        $this->userEntity = $userEntity;
    }

    /**
     * {@inheritdoc}
     */
    public function getUserById($userId)
    {
        $entity = $this->getUserEntity();

        $user = $this->em->find($entity, $userId);

        return $user;
    }

    /**
     * {@inheritdoc}
     */
    public function getUserByEmail($userEmail)
    {
        $entity = $this->getUserEntity();

        $user = $this->em->getRepository($entity)->findOneBy(['email' => $userEmail]);

        return $user;
    }

    /**
     * {@inheritdoc}
     */
    public function userExists($userEmail)
    {
        return (bool)count((array)$this->getUserByEmail($userEmail));
    }
}
