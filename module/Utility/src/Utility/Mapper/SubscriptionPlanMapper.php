<?php

namespace Utility\Mapper;

use Doctrine\ORM\EntityManagerInterface;

class SubscriptionPlanMapper implements SubscriptionPlanMapperInterface
{
    /**
     * @var EntityManagerInterface
     */
    protected $em;

    /**
     * @var \Utility\Entity\SubscriptionPlan
     */
    protected $subscriptionPlan = \Utility\Entity\SubscriptionPlan::class;

    /**
     * {@inheritdoc}
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @return \Utility\Entity\SubscriptionPlan
     */
    public function getSubscriptionPlan()
    {
        return $this->subscriptionPlan;
    }

    /**
     * @param \Utility\Entity\SubscriptionPlan $subscriptionPlan
     */
    public function setSubscriptionPlan($subscriptionPlan)
    {
        $this->subscriptionPlan = $subscriptionPlan;
    }

    /**
     * Get all subscription plans
     *
     * @return array
     */
    public function getAllSubscriptionPlanes()
    {
        $entity = $this->getSubscriptionPlan();

        $plans = $this->em->getRepository($entity)->findAll();

        return $plans;
    }

    /**
     * @param $subscriptionSchemeId
     *
     * @return array
     */
    public function getPlansBySubscriptionScheme($subscriptionSchemeId)
    {
        $entity = $this->getSubscriptionPlan();

        $plans = $this->em->getRepository($entity)->findBy([
            'subscriptionScheme' => $subscriptionSchemeId
        ]);

        return  $plans;
    }

    /**
     * @param      $subscriptionScheme
     * @param bool $isKeyOwner
     *
     * @return object
     */
    public function getUserSubscriptionPlan($subscriptionScheme, $isKeyOwner)
    {
        $entity = $this->getSubscriptionPlan();

        $currentPlan = $this->em->getRepository($entity)->findOneBy([
            'subscriptionScheme' => $subscriptionScheme,
            'isKeyOwner'         => $isKeyOwner,
        ]);

        return $currentPlan;
    }

    /**
     * @return array
     */
    public function getAllLimitRowPerRequest()
    {
        $result = [];

        $limits = $this->getAllSubscriptionPlanes();

        foreach ($limits as $limit) {
            if (!in_array($currentLimit = $limit->getLimitRowPerRequest(), $result)) {
                $result[] = $currentLimit;
            }
        }
        return $result;
    }

    /**
     * @param $entity
     */
    public function persist($entity)
    {
        $this->em->persist($entity);
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
