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
    protected $entity = \Ebay\Entity\StructureCategoryEbay::class;

    /**
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function findEbayCategoryBy($level, $idParent = null)
    {

    }

    /**
     * @return \Ebay\Entity\StructureCategoryEbay
     */
    public function getEntity()
    {
        return new $this->entity;
    }

    /**
     * @param \Ebay\Entity\StructureCategoryEbay $entity
     */
    public function setEntity($entity)
    {
        $this->entity = $entity;
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
     * clear
     */
    public function clear()
    {
        $this->em->clear();
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
