<?php

namespace Utility\Mapper;

use Doctrine\ORM\EntityManagerInterface;

class DataSourceKeyMapper implements DataSourceKeyMapperInterface
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
     * @param EntityManagerInterface $em
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
        \User\Entity\User                $user,
        \Utility\Entity\DataSourceGlobal $dataSourceGlobal,
        $accessKey,
        $isValid = true
    ) {
        $keyExists = $this->keyExists($user, $dataSourceGlobal);

        $entity = $this->getDataSourceKeyEntity();

        // if app key if not exists
        if (!$keyExists) {
            // add new key
            $sourceKey = new $entity();
            $sourceKey->setAccessKey($accessKey);
            $sourceKey->setIsValid($isValid);
            $sourceKey->setUser($user);
            $sourceKey->setDataSourceGlobal($dataSourceGlobal);

            $this->persistFlush($sourceKey);
        } else {
            // update app key
            $sourceKey = $this->em->getRepository($entity)->findOneBy([
                'user'              => $user,
                'dataSourceGlobal'  => $dataSourceGlobal,
            ]);

            $sourceKey->setAccessKey($accessKey);

            $this->flush();
        }
    }

    /**
     * @param $user
     * @param $dataSourceGlobal
     *
     * @return array
     */
    public function getKey($user, $dataSourceGlobal)
    {
        $entity = $this->getDataSourceKeyEntity();

        $key = $this->em->getRepository($entity)->findOneBy([
            'user'              => $user,
            'dataSourceGlobal'  => $dataSourceGlobal,
            'isValid'           => true,
        ]);

        return isset($key) ? $key->getAccessKey() : null;
    }

    /**
     * @param $user
     * @param $dataSourceGlobal
     *
     * @return bool
     */
    public function keyExists($user, $dataSourceGlobal)
    {
        $entity = $this->getDataSourceKeyEntity();

        $key = $this->em->getRepository($entity)->findOneBy([
            'user'              => $user,
            'dataSourceGlobal'  => $dataSourceGlobal,
        ]);

        return isset($key) ? true : false;
    }

    /**
     * @param $user
     * @param $dataSourceGlobal
     */
    public function setInvalidKeyStatus($user, $dataSourceGlobal)
    {
        $entity = $this->getDataSourceKeyEntity();

        $key = $this->em->getRepository($entity)->findOneBy([
            'user'              => $user,
            'dataSourceGlobal'  => $dataSourceGlobal,
        ]);

        $key->setIsValid(false);

        $this->flush();
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
