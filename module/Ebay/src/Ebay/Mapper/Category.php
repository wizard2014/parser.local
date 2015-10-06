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
     * {@inheritdoc}
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * {@inheritdoc}
     */
    public function getCategoryEntity()
    {
        return $this->categoryEntity;
    }

    /**
     * {@inheritdoc}
     */
    public function setCategoryEntity($entity)
    {
        $this->categoryEntity = $entity;
    }

    /**
     * {@inheritdoc}
     */
    public function getAllCategories()
    {
        $entity = $this->getCategoryEntity();

        $categories = $this->em->getRepository($entity)->findAll();

        return $categories;
    }

    /**
     * Check category exists
     *
     * @return bool
     */
    public function categoryExists()
    {
        $categories = $this->getAllCategories();

        return (bool)count($categories);
    }

    /**
     * @param $dataSourceRegional
     * @param $categoryLevel
     *
     * @return array
     */
    public function getMainCategory($dataSourceRegional, $categoryLevel)
    {
        $entity = $this->getCategoryEntity();

        $categories = $this->em->getRepository($entity)->findBy([
            'dataSourceRegional' => $dataSourceRegional,
            'categoryLevel'      => $categoryLevel,
        ]);

        return $this->prepareArrayResult($categories);
    }

    /**
     * @param $dataSourceRegional
     * @param $categoryLevel
     * @param $categoryParentId
     *
     * @return array
     */
    public function getCategory($dataSourceRegional, $categoryLevel, $categoryParentId)
    {
        $entity = $this->getCategoryEntity();

        $categories = $this->em->getRepository($entity)->findBy([
            'dataSourceRegional' => $dataSourceRegional,
            'categoryLevel'      => $categoryLevel,
            'categoryParentId'   => $categoryParentId,
        ]);

        return $this->prepareArrayResult($categories);
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

    /**
     * @param array $data
     *
     * @return array
     */
    protected function prepareArrayResult(array $data)
    {
        $result = [];

        foreach ($data as $i => $item) {
            $result[$i]['id']    = $item->getCategoryId();
            $result[$i]['level'] = $item->getCategoryLevel();
            $result[$i]['name']  = $item->getCategoryName();
        }

        return $result;
    }
}
