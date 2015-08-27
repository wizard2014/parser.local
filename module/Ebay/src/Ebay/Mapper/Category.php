<?php

namespace Ebay\Mapper;

use Doctrine\ORM\EntityManagerInterface;

class Category implements CategoryInterface
{
    /**
     * @var EntityManagerInterface
     */
    protected $em;
    /**
     * @var \Ebay\Entity\StructureCategoryEbay
     */
    protected $categoryEntity = \Ebay\Entity\StructureCategoryEbay::class;

    /**
     * @var \Ebay\Entity\DataSourceRegional
     */
    protected $dataSourceRegionalEntity = \Ebay\Entity\DataSourceRegional::class;

    /**
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @param $idRegion
     *
     * @return object
     */
    public function getRegionById($idRegion)
    {
        $entity = $this->getDataSourceRegionalEntity();

        $regionObj = $this->em->getRepository($entity)->findOneBy(['ebaySiteId' => $idRegion]);

        return $regionObj;
    }

    /**
     * @return array
     */
    public function getAllEnRegions()
    {
        $result = [];

        $entity = $this->getDataSourceRegionalEntity();

        $enRegionsObj = $this->em->getRepository($entity)->findAll();

        foreach ($enRegionsObj as $i => $regionItem) {
            if (strpos($regionItem->getEbayLanguage(), 'en') !== false) {
                $result[$i]['id']               = $regionItem->getId();
                $result[$i]['region']           = $regionItem->getRegion();
                $result[$i]['url']              = $regionItem->getUrl();
                $result[$i]['ebayGlobalId']     = $regionItem->getEbayGlobalId();
                $result[$i]['ebayLanguage']     = $regionItem->getEbayLanguage();
                $result[$i]['ebayTerritory']    = $regionItem->getEbayTerritory();
                $result[$i]['ebaySiteName']     = $regionItem->getEbaySiteName();
                $result[$i]['ebaySiteId']       = $regionItem->getEbaySiteId();
            }
        }

        return array_values($result);
    }

    /**
     * @return \Ebay\Entity\StructureCategoryEbay
     */
    public function getCategoryEntity()
    {
        return new $this->categoryEntity;
    }

    /**
     * @param \Ebay\Entity\StructureCategoryEbay $entity
     */
    public function setCategoryEntity($entity)
    {
        $this->categoryEntity = $entity;
    }

    /**
     * @return \Ebay\Entity\DataSourceRegional
     */
    public function getDataSourceRegionalEntity()
    {
        return $this->dataSourceRegionalEntity;
    }

    /**
     * @param \Ebay\Entity\DataSourceRegional $dataSourceRegionalEntity
     */
    public function setDataSourceRegionalEntity($dataSourceRegionalEntity)
    {
        $this->dataSourceRegionalEntity = $dataSourceRegionalEntity;
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
