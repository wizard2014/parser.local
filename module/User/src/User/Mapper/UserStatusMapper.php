<?php

namespace User\Mapper;

use Doctrine\ORM\EntityManagerInterface;

class UserStatusMapper implements UserStatusMapperInterface
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
     * {@inheritdoc}
     */
    public function getUserStatusEntity()
    {
        return $this->userStatusEntity;
    }

    /**
     * {@inheritdoc}
     */
    public function setUserStatusEntity($userStatusEntity)
    {
        $this->userStatusEntity = $userStatusEntity;
    }

    /**
     * {@inheritdoc}
     */
    public function getMemberSince($userId)
    {
        $entity = $this->getUserStatusEntity();

        $date = $this->em->find($entity, $userId)->getDateRegistration();

        return $date;
    }

    /**
     * {@inheritdoc}
     */
    public function isEmailSubscriber($userId)
    {
        $entity = $this->getUserStatusEntity();

        $subscriber = $this->em->find($entity, $userId)->getIsEmailSubscriber();

        return $subscriber;
    }

    /**
     * {@inheritdoc}
     */
    public function getQtyTotalFree($userId)
    {
        $entity = $this->getUserStatusEntity();

        $qtyTotalFree = $this->em->find($entity, $userId)->getQtyTotalFree();

        return $qtyTotalFree;
    }

    /**
     * {@inheritdoc}
     */
    public function getQtyTotalSubscriber($userId)
    {
        $entity = $this->getUserStatusEntity();

        $qtyTotalSubscr = $this->em->find($entity, $userId)->getQtyTotalSubscr();

        return $qtyTotalSubscr;
    }

    /**
     * {@inheritdoc}
     */
    public function getQtyTotal($userId)
    {
        $entity = $this->getUserStatusEntity();

        $qtyTotal = $this->em->find($entity, $userId)->getQtyTotal();

        return $qtyTotal;
    }

    /**
     * {@inheritdoc}
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
     * {@inheritdoc}
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
     * {@inheritdoc}
     */
    public function getUserInfo($userId)
    {
        $entity = $this->getUserStatusEntity();

        $qb = $this->em->createQueryBuilder();

        $qb
            ->select('
                us.dateRegistration,
                us.isEmailSubscriber,
                us.qtyTotalFree,
                us.qtyTotalSubscr,
                us.qtyTotal
                ')
            ->from($entity, 'us')
            ->where('us.user = :user')
            ->setParameter('user', $userId);

        $result = $qb->getQuery()->getSingleResult();

        return $result;
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
