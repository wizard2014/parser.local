<?php

namespace User\Mapper;

use Doctrine\ORM\EntityManagerInterface;

class SubscriptionMapper implements SubscriptionMapperInterface
{
    /**
     * @var EntityManagerInterface
     */
    protected $em;

    /**
     * @var \User\Entity\Subscription
     */
    protected $userSubscription = \User\Entity\Subscription::class;

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
    public function getUserSubscription()
    {
        return $this->userSubscription;
    }

    /**
     * {@inheritdoc}
     */
    public function setUserSubscription($userSubscription)
    {
        $this->userSubscription = $userSubscription;
    }

    /**
     * {@inheritdoc}
     */
    public function getDateCreation($userId)
    {
        $entity = $this->getUserSubscription();

        $dateCreation = $this->em->find($entity, $userId)->getDateCreation();

        return $dateCreation;
    }

    /**
     * {@inheritdoc}
     */
    public function getDateActivation($userId)
    {
        $entity = $this->getUserSubscription();

        $dateActivation = $this->em->find($entity, $userId)->getDateActivation();

        return $dateActivation;
    }

    /**
     * {@inheritdoc}
     */
    public function getDateExpiration($userId)
    {
        $entity = $this->getUserSubscription();

        $dateExpiration = $this->em->find($entity, $userId)->getDateExpiration();

        return $dateExpiration;
    }

    /**
     * {@inheritdoc}
     */
    public function getIsBlocked($userId)
    {
        $entity = $this->getUserSubscription();

        $isBlocked = $this->em->find($entity, $userId)->getIsBlocked();

        return $isBlocked;
    }

    /**
     * {@inheritdoc}
     */
    public function getRequestCounterTotal($userId)
    {
        $entity = $this->getUserSubscription();

        $requestCounterTotal = $this->em->find($entity, $userId)->getRequestCounterTotal();

        return $requestCounterTotal;
    }

    /**
     * {@inheritdoc}
     */
    public function getRequestCounterDaily($userId)
    {
        $entity = $this->getUserSubscription();

        $requestCounterDaily = $this->em->find($entity, $userId)->getRequestCounterDaily();

        return $requestCounterDaily;
    }

    /**
     * {@inheritdoc}
     */
    public function getDateStartCounter($userId)
    {
        $entity = $this->getUserSubscription();

        $dateStartCounter = $this->em->find($entity, $userId)->getDateStartCounter();

        return $dateStartCounter;
    }

    /**
     * {@inheritdoc}
     */
    public function getSubscriptionSchemeId($userId)
    {
        $entity = $this->getUserSubscription();

        $subscriptionSchemeId = $this->em->find($entity, $userId)
                                            ->getSubscriptionScheme()
                                            ->getId();

        return $subscriptionSchemeId;
    }

    /**
     * {@inheritdoc}
     */
    public function getSubscriptionStatusId($userId)
    {
        $entity = $this->getUserSubscription();

        $subscriptionStatusId = $this->em->find($entity, $userId)
                                            ->getSubscriptionStatus()
                                            ->getId();

        return $subscriptionStatusId;
    }

    /**
     * {@inheritdoc}
     */
    public function isFreeSubUser($userId)
    {
        $subTypeId = $this->getSubscriptionSchemeId($userId);

        return (bool) ($subTypeId === 1);// Free account
    }

    /**
     * {@inheritdoc}
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
