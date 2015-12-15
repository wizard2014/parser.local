<?php

namespace Utility\Mapper;

use Doctrine\ORM\EntityManagerInterface;

class SubscriptionPlanMapper
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
    public function getAllPlanes()
    {
        $result = [];

        $entity = $this->getSubscriptionPlan();

        $plans = $this->em->getRepository($entity)->findAll();

        foreach ($plans as $plan) {
            if ($plan->getIsKeyOwner()) {
                $result['key_exists'][] = $plan;
            } else {
                $result['key_not_exists'][] = $plan;
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
