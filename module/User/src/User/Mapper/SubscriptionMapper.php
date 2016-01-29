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
    public function getActiveSubscription($userId, $vendor)
    {
        $entity = $this->getUserSubscription();

        $qb = $this->em->createQueryBuilder();

        $qb
            ->select('sub')
            ->from($entity, 'sub')
            ->where('sub.user = :userId')
            ->andWhere(
                $qb->expr()->andX(
                    $qb->expr()->lte('sub.dateActivation', ':now'),
                    $qb->expr()->gte('sub.dateExpiration', ':now')
                )
            )
            ->andWhere('sub.subscriptionScheme = :subScheme')
            ->andWhere('sub.isBlocked = false')
            ->andWhere('sub.subscriptionStatus = 7')
            ->setParameter('userId', $userId)
            ->setParameter('now', new \DateTime())
            ->setParameter('subScheme', $vendor)
            ->orderBy('sub.subscriptionStatus', 'DESC')
            ->setMaxResults(1);

        $subscription = $qb->getQuery()->getSingleResult();

        return $subscription;
    }

    public function getActiveSubscriptions($userId)
    {

    }

    public function getBlockedSubscriptions($userId)
    {

    }

    public function getExpiredSubscriptions($userId)
    {

    }

    public function resetCounterDaily($userId)
    {
        $entity = $this->getUserSubscription();

        $qb = $this->em->createQueryBuilder();

        $qu = $qb
            ->update($entity, 'sub')
            ->set('sub.requestCounterDaily', ':counter')
            ->set('sub.isBlocked', ':blocked')
            ->where('sub.user = :userId')
            ->andWhere(
                $qb->expr()->andX(
                    $qb->expr()->lte('sub.dateActivation', ':now'),
                    $qb->expr()->gte('sub.dateExpiration', ':now')
                )
            )
//            ->andWhere(
//                $qb->expr()->lte('sub.dateStartCounter + 24 hours', ':now')
//            )
            ->setParameter('counter', 0)
            ->setParameter('blocked', false)
            ->setParameter('userId', $userId)
            ->setParameter('now', new \DateTime())
            ->getQuery();

        $qu->execute();
    }

    /**
     * {@inheritdoc}
     */
    public function getDateCreation($id)
    {
        $entity = $this->getUserSubscription();

        $dateCreation = $this->em->find($entity, $id)->getDateCreation();

        return $dateCreation;
    }

    /**
     * {@inheritdoc}
     */
    public function getDateActivation($id)
    {
        $entity = $this->getUserSubscription();

        $dateActivation = $this->em->find($entity, $id)->getDateActivation();

        return $dateActivation;
    }

    /**
     * {@inheritdoc}
     */
    public function getDateExpiration($id)
    {
        $entity = $this->getUserSubscription();

        $dateExpiration = $this->em->find($entity, $id)->getDateExpiration();

        return $dateExpiration;
    }

    /**
     * {@inheritdoc}
     */
    public function getIsBlocked($id)
    {
        $entity = $this->getUserSubscription();

        $isBlocked = $this->em->find($entity, $id)->getIsBlocked();

        return $isBlocked;
    }

    /**
     * {@inheritdoc}
     */
    public function getRequestCounterTotal($id)
    {
        $entity = $this->getUserSubscription();

        $requestCounterTotal = $this->em->find($entity, $id)->getRequestCounterTotal();

        return $requestCounterTotal;
    }

    /**
     * {@inheritdoc}
     */
    public function getRequestCounterDaily($id)
    {
        $entity = $this->getUserSubscription();

        $requestCounterDaily = $this->em->find($entity, $id)->getRequestCounterDaily();

        return $requestCounterDaily;
    }

    /**
     * {@inheritdoc}
     */
    public function getDateStartCounter($id)
    {
        $entity = $this->getUserSubscription();

        $dateStartCounter = $this->em->find($entity, $id)->getDateStartCounter();

        return $dateStartCounter;
    }

    /**
     * {@inheritdoc}
     */
    public function getSubscriptionSchemeId($id)
    {
        $entity = $this->getUserSubscription();

        $subscriptionSchemeId = $this->em->find($entity, $id)
                                            ->getSubscriptionScheme()
                                            ->getId();

        return $subscriptionSchemeId;
    }

    /**
     * {@inheritdoc}
     */
    public function getSubscriptionStatusId($id)
    {
        $entity = $this->getUserSubscription();

        $subscriptionStatusId = $this->em->find($entity, $id)
                                            ->getSubscriptionStatus()
                                            ->getId();

        return $subscriptionStatusId;
    }

    /**
     * {@inheritdoc}
     */
    public function isFreeSubUser($id)
    {
        $subTypeId = $this->getSubscriptionSchemeId($id);

        return (bool) ($subTypeId === 1);// Free account
    }

    /**
     * {@inheritdoc}
     */
    public function isActiveUser($id)
    {
        $subStatusId = $this->getSubscriptionStatusId($id);

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
