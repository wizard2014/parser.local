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
                $result[$region->getId()] = $region->getRegion();
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