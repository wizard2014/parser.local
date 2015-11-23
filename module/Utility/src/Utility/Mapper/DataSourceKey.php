<?php

namespace Utility\Mapper;

use Doctrine\ORM\EntityManagerInterface;

class DataSourceKey
{
    /**
     * @var EntityManagerInterface
     */
    protected $em;

    /**
     * @var \Utility\Entity\DataSourceKey
     */
    protected $dataSourceKeyEntity = \Utility\Entity\DataSourceKey::class;

    /**
     * {@inheritdoc}
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @return \Utility\Entity\DataSourceKey
     */
    public function getDataSourceKeyEntity()
    {
        return $this->dataSourceKeyEntity;
    }

    /**
     * @param \Utility\Entity\DataSourceKey $dataSourceKeyEntity
     */
    public function setDataSourceKeyEntity($dataSourceKeyEntity)
    {
        $this->dataSourceKeyEntity = $dataSourceKeyEntity;
    }

    /**
     * Set Access Key
     *
     * @param \User\Entity\User                $user
     * @param \Utility\Entity\DataSourceGlobal $dataSourceGlobal
     * @param                                  $accessKey
     * @param bool|true                        $isValid
     */
    public function setKey(
        \User\Entity\User $user,
        \Utility\Entity\DataSourceGlobal $dataSourceGlobal,
        $accessKey,
        $isValid = true
    ) {
        $entity = $this->getDataSourceKeyEntity();

        $sourceKey = new $entity();
        $sourceKey->setAccessKey($accessKey);
        $sourceKey->setIsValid($isValid);
        $sourceKey->setUser($user);
        $sourceKey->setDataSourceGlobal($dataSourceGlobal);

        try {
            $this->persistFlush($sourceKey);
        } catch (\Exception $e) {
            // duplicate key
        }
    }

    /**
     * Get Access Keys
     *
     * @param $userId
     *
     * @return array
     */
    public function getKey($userId)
    {
        $entity = $this->getDataSourceKeyEntity();

        $qb = $this->em->createQueryBuilder();

        $qb
            ->select('k')
            ->from($entity, 'k')
            ->where('k.user = ?1')
            ->andWhere('k.isValid = ?2')
//            ->groupBy('')
//            ->orderBy('k.dataSourceGlobal', 'DESC')
            ->setParameter(1, $userId)
            ->setParameter(2, true);

        $qs = $qb->getQuery()->getArrayResult();

        return $qs;
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
