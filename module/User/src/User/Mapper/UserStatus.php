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

        $user = $this->em->find($entity, $userId);

        $user->setIsEmailSubscriber(true);

        $this->persistFlush($user);

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

        $user = $this->em->find($entity, $userId);

        $user->setIsEmailSubscriber(false);

        $this->persistFlush($user);

        return false;
    }

    /**
     * @param $userId
     *
     * @return int
     */
    public function getSubscriptionTypeId($userId)
    {
        $entity = $this->getUserStatusEntity();

        $user = $this->em->find($entity, $userId);

        return $user->getSubscriptionType2()->getId();
    }

    /**
     * @param $userId
     *
     * @return int
     */
    public function getSubscriptionStatusId($userId)
    {
        $entity = $this->getUserStatusEntity();

        $user = $this->em->find($entity, $userId);

        return $user->getSubscriptionStatus2()->getId();
    }


    /**
     * @param $userId
     *
     * @return bool
     */
    public function isFreeSubUser($userId)
    {
        $subTypeId = $this->getSubscriptionTypeId($userId);

        return (bool) ($subTypeId === 1);// Free account
    }

    /**
     * @param $userId
     *
     * @return bool
     */
    public function isActiveUser($userId)
    {
        $subStatusId = $this->getSubscriptionStatusId($userId);

        return (bool) ($subStatusId === 7) || ($subStatusId === 10); // Active or In Progress account
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
