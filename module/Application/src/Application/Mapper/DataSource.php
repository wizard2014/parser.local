<?php

namespace Ebay\Mapper;

use Doctrine\ORM\EntityManagerInterface;

class DataSource implements CategoryInterface
{
    /**
     * @var EntityManagerInterface
     */
    protected $em;

    /**
     * @var \Application\Entity\DataSourceGlobal
     */
    protected $dataSourceGlobalEntity = \Application\Entity\DataSourceGlobal::class;

    /**
     * @var \Application\Entity\DataSourceRegional
     */
    protected $dataSourceRegionalEntity = \Application\Entity\DataSourceRegional::class;

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
     * @return \Application\Entity\DataSourceRegional
     */
    public function getDataSourceRegionalEntity()
    {
        return $this->dataSourceRegionalEntity;
    }

    /**
     * @param \Application\Entity\DataSourceRegional $dataSourceRegionalEntity
     */
    public function setDataSourceRegionalEntity($dataSourceRegionalEntity)
    {
        $this->dataSourceRegionalEntity = $dataSourceRegionalEntity;
    }
}
