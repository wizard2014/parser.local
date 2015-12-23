<?php

namespace Utility\Mapper;

use Doctrine\ORM\EntityManagerInterface;

class SubscriptionSchemeMapper implements SubscriptionSchemeMapperInterface
{
    /**
     * @var EntityManagerInterface
     */
    protected $em;

    /**
     * @var \Utility\Entity\SubscriptionScheme
     */
    protected $subscriptionScheme = \Utility\Entity\SubscriptionScheme::class;

    /**
     * {@inheritdoc}
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @return \Utility\Entity\SubscriptionScheme
     */
    public function getSubscriptionScheme()
    {
        return $this->subscriptionScheme;
    }

    /**
     * @param \Utility\Entity\SubscriptionScheme $subscriptionScheme
     */
    public function setSubscriptionScheme($subscriptionScheme)
    {
        $this->subscriptionScheme = $subscriptionScheme;
    }

    /**
     * @return array
     */
    public function getAllSubscriptionScheme()
    {
        $entity = $this->getSubscriptionScheme();

        $schemes = $this->em->getRepository($entity)->findAll();

        return $schemes;
    }

    /**
     * Get all subscription plans by vendor
     *
     * @param $dataSourceGlobalId
     *
     * @return array
     */
    public function getAllSubscriptionPlanesByDataSourceGlobal($dataSourceGlobalId)
    {
        $entity = $this->getSubscriptionScheme();

        $schemes = $this->em->getRepository($entity)->findBy(['dataSourceGlobal' => $dataSourceGlobalId]);

        return $schemes;
    }

    /**
     * @param $subscriptionTypeId
     *
     * @return object
     */
    public function getSchemaBySubscriptionTypeId($subscriptionTypeId)
    {
        $entity = $this->getSubscriptionScheme();

        $scheme = $this->em->getRepository($entity)->findOneBy(['subscriptionType2' => $subscriptionTypeId]);

        return $scheme;
    }

    /**
     * @param $subscriptionTypeId
     *
     * @return object
     */
    public function getSubscriptionType($subscriptionTypeId)
    {
        $scheme = $this->getSchemaBySubscriptionTypeId($subscriptionTypeId);

        return isset($scheme) ? $scheme->getSubscriptionType() : null;
    }
}
