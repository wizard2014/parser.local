<?php

namespace Ebay\Mapper;

use Doctrine\ORM\EntityManagerInterface;

class CategoryMapper implements CategoryMapperInterface
{
    /**
     * @var EntityManagerInterface
     */
    protected $em;

    /**
     * @var array
     */
    protected $categories = [];

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
     * {@inheritdoc}
     */
    public function getAllCategoriesId()
    {
        $categories = $this->getAllCategories();

        $result = [];

        if (!empty($categories)) {
            foreach ($categories as $category) {
                $result[$category->getDataSourceRegional()->getId()][$category->getCategoryId()] = true;
            }
        }

        return $result;
    }

    /**
     * Check category exists
     *
     * @return bool
     */
    public function categoriesExists()
    {
        $categories = $this->getAllCategories();

        return (bool)count($categories);
    }

    /**
     * Add category
     *
     * categoryLevel, categoryName, categoryId, categoryParentId, region
     *
     * @param $category
     */
    public function add($category)
    {
        $this->categories[] = $category;
    }

    /**
     * Save Category
     *
     * @return bool
     */
    public function save()
    {
        if (empty($this->categories)) {
            return false;
        }

        $entity = $this->getCategoryEntity();

        foreach ($this->categories as $category) {
            $newCategory = new $entity();

            $newCategory->exchangeArray($category);

            $this->persist($newCategory);
        }

        $this->flush();

        return true;
    }

    /**
     * @param $dataSourceRegional
     * @param $categoryId
     *
     * @return bool
     */
    public function categoryExists($dataSourceRegional, $categoryId)
    {
        $entity = $this->getCategoryEntity();

        $category = $this->em->getRepository($entity)->findBy([
            'dataSourceRegional' => $dataSourceRegional,
            'categoryId'         => $categoryId,
        ]);

        return (bool)$category;
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
//    protected function prepareArrayResult(array $data)
//    {
//        $result = [];
//
//        foreach ($data as $i => $item) {
//            $result[$i]['id']    = $item->getCategoryId();
//            $result[$i]['level'] = $item->getCategoryLevel();
//            $result[$i]['name']  = $item->getCategoryName();
//        }
//
//        return $result;
//    }
}
