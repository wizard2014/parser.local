<?php

namespace Utility\Mapper;

use Doctrine\ORM\EntityManagerInterface;

class DataSourceGlobal
{
    /**
     * @var EntityManagerInterface
     */
    protected $em;

    /**
     * @var \Utility\Entity\DataSourceGlobal
     */
    protected $dataSourceGlobalEntity = \Utility\Entity\DataSourceGlobal::class;

    /**
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @return \Utility\Entity\DataSourceGlobal
     */
    public function getDataSourceGlobalEntity()
    {
        return $this->dataSourceGlobalEntity;
    }

    /**
     * @param $entity
     */
    public function setDataSourceGlobalEntity($entity)
    {
        $this->dataSourceGlobalEntity = $entity;
    }

    /**
     * @param $id
     *
     * @return \Utility\Entity\DataSourceGlobal
     */
    public function getSourceGlobalById($id)
    {
        $entity = $this->getDataSourceGlobalEntity();

        $dataSourceGlobal = $this->em->find($entity, $id);

        return $dataSourceGlobal;
    }

    /**
     * @param $name
     *
     * @return array
     */
    public function getSourceGlobalByName($name)
    {
        $result = [];

        $entity = $this->getDataSourceGlobalEntity();

        $dataSourceGlobal = $this->em->getRepository($entity)->findOneBy(['name' => $name]);

        $result['id']           = $dataSourceGlobal->getId();
        $result['Sort Order']   = $dataSourceGlobal->getFilterSet()['Sort Order'];
        $result['Listing Type'] = $dataSourceGlobal->getFilterSet()['Listing Type'];

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
