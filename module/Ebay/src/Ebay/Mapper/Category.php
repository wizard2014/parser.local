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
     * @param $categoryParentId
     *
     * @return array
     */
    public function getCategory($dataSourceRegional, $categoryLevel, $categoryParentId)
    {
        $result = [];

        $entity = $this->getCategoryEntity();

        $categories = $this->em->getRepository($entity)->findBy([
            'dataSourceRegional' => $dataSourceRegional,
            'categoryLevel'      => $categoryLevel,
            'categoryParentId'   => $categoryParentId,
        ]);

        foreach ($categories as $i => $category) {
            $result[$i]['categoryId']       = $category->getCategoryId();
            $result[$i]['categoryParentId'] = $category->getCategoryParentId();
            $result[$i]['categoryName']     = $category->getCategoryName();
            $result[$i]['categoryLevel']    = $category->getCategoryLevel();
            $result[$i]['categoryName']     = $category->getCategoryName();
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
