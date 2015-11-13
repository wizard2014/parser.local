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

    /**
     * @param $userId
     *
     * @return \DateTime
     */
    public function getMemberSince($userId)
    {
        $entity = $this->getUserStatusEntity();

        $date = $this->em->find($entity, $userId)->getRegistrationDate();

        return $date;
    }

    /**
     * @param $userId
     *
     * @return bool
     */
    public function isEmailSubscriber($userId)
    {
        $entity = $this->getUserStatusEntity();

        $subscriber = $this->em->find($entity, $userId)->getIsEmailSubscriber();

        return $subscriber;
    }

    /**
     * Set email Subscriber
     *
     * @param $userId
     *
     * @return bool
     */
    public function subscribe($userId)
    {
        $entity = $this->getUserStatusEntity();

        $subscribe = $this->em->find($entity, $userId);

        $subscribe->setIsEmailSubscriber(true);

        $this->persistFlush($subscribe);

        return true;
    }

    /**
     * Unset email Subscriber
     *
     * @param $userId
     *
     * @return bool
     */
    public function unsubscribe($userId)
    {
        $entity = $this->getUserStatusEntity();

        $subscribe = $this->em->find($entity, $userId);

        $subscribe->setIsEmailSubscriber(false);

        $this->persistFlush($subscribe);

        return false;
    }

    /**
     * flush
     */
    public function flush()
    {
        $this->em->flush();
    }

    /**
     * @param $entity
     *
     * @return mixed
     */
    public function persistFlush($entity)
    {
        $this->em->persist($entity);
        $this->em->flush();

        return $entity;
    }

    /**
     * @param $entity
     */
    public function remove($entity)
    {
        $this->em->remove($entity);
        $this->em->flush();
    }
}
