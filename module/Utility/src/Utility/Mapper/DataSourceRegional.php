<?php

namespace Utility\Mapper;

use Doctrine\ORM\EntityManagerInterface;

class DataSourceRegional
{
    /**
     * @var EntityManagerInterface
     */
    protected $em;

    /**
     * @var \Utility\Entity\DataSourceRegional
     */
    protected $dataSourceRegional = \Utility\Entity\DataSourceRegional::class;

    /**
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @return \Utility\Entity\DataSourceRegional
     */
    public function getDataSourceRegionalEntity()
    {
        return $this->dataSourceRegional;
    }

    /**
     * @param $entity
     */
    public function setDataSourceGlobalEntity($entity)
    {
        $this->dataSourceRegional = $entity;
    }

    /**
     * @param        $dataSourceGlobalId
     * @param string $selectLang
     * @param string $vendor
     *
     * @return array
     *
     * @todo refactor duplicate
     */
    public function getRegions($dataSourceGlobalId, $selectLang, $vendor)
    {
        $entity = $this->getDataSourceRegionalEntity();

        $regions = $this->em->getRepository($entity)->findAll();

        $result = [];

        foreach ($regions as $region) {
            $language                  = $region->getPropertySet()[strtolower($vendor) . '_language'];
            $currentDataSourceGlobalId = $region->getDataSourceGlobal()->getId();

            if ($currentDataSourceGlobalId === $dataSourceGlobalId && strpos($language, $selectLang) !== false) {
                $result[$region->getId()] = $region->getRegion();
            }
        }

        return $result;
    }

    /**
     * @param        $dataSourceGlobalId
     * @param string $selectLang
     * @param string $vendor
     *
     * @return array
     *
     * @todo refactor duplicate
     */
    public function getDataByRegion($dataSourceGlobalId, $selectLang, $vendor)
    {
        $entity = $this->getDataSourceRegionalEntity();

        $regions = $this->em->getRepository($entity)->findAll();

        $result = [];

        foreach ($regions as $region) {
            $language                  = $region->getPropertySet()[strtolower($vendor) . '_language'];
            $currentDataSourceGlobalId = $region->getDataSourceGlobal()->getId();

            if ($currentDataSourceGlobalId === $dataSourceGlobalId && strpos($language, $selectLang) !== false) {
                $result[] = $region;
            }
        }

        return $result;
    }

    /**
     * @param      $id
     * @param null $prop
     *
     * @return mixed
     */
    public function getPropertySet($id, $prop = null)
    {
        $entity = $this->getDataSourceRegionalEntity();

        if (is_null($prop)) {
            $prop = $this->em->find($entity, $id)->getPropertySet();
        } else {
            $prop = $this->em->find($entity, $id)->getPropertySet()[$prop];
        }

        return $prop;
    }

    /**
     * @param      $dataSourceGlobalId
     * @param null $prop
     *
     * @return array
     */
    public function getPropertiesSet($dataSourceGlobalId, $prop = null)
    {
        $result = [];

        $entity = $this->getDataSourceRegionalEntity();

        $props = $this->em->getRepository($entity)->findBy(['dataSourceGlobal' => $dataSourceGlobalId]);

        foreach ($props as $item) {
            $result[] = !is_null($prop) ? $item->getPropertySet()[$prop] : $item->getPropertySet();
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