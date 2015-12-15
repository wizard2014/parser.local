<?php

namespace Utility\Mapper;

use Doctrine\ORM\EntityManagerInterface;

class DataSourceGlobalMapper
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
     * Get all DataSourceGlobal
     *
     * @return array
     */
    public function getAll()
    {
        $result = [];

        $entity = $this->getDataSourceGlobalEntity();

        $all = $this->em->getRepository($entity)->findAll();

        foreach ($all as $item) {
            $result[$item->getId()] = $item->getName();
        }

        return $result;
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
     * @return $id
     */
    public function getIdByName($name)
    {
        $entity = $this->getDataSourceGlobalEntity();

        $dataSourceGlobal = $this->em->getRepository($entity)->findOneBy(['name' => $name]);

        return isset($dataSourceGlobal) ?  $dataSourceGlobal->getId() : null;
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

        $result['Sort Order']   = $dataSourceGlobal->getFilterSet()['Sort Order'];
        $result['Listing Type'] = $dataSourceGlobal->getFilterSet()['Listing Type'];

        return $result;
    }

    /**
     * @param $name
     * @param $sortOrderFromForm
     *
     * @return bool
     */
    public function sortOrderExists($name, $sortOrderFromForm)
    {
        $sortOrder = $this->getSourceGlobalByName($name)['Sort Order'];

        return in_array($sortOrderFromForm, $sortOrder);
    }

    /**
     * @param $name
     * @param $listingTypeFromForm
     *
     * @return bool
     */
    public function listingTypeExists($name, $listingTypeFromForm)
    {
        $listingType = $this->getSourceGlobalByName($name)['Listing Type'];

        foreach ($listingTypeFromForm as $item) {
            if (!in_array($item, $listingType)) {
                return false;
            }
        }

        return true;
    }

    /**
     * @param $regionId
     *
     * @return bool
     */
    public function regionExists($regionId)
    {
        $entity = $this->getDataSourceGlobalEntity();

        try {
            $region = $this->em->find($entity, $regionId);
        } catch(\Exception $e) {
            return false;
        }

        return !empty($region);
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
