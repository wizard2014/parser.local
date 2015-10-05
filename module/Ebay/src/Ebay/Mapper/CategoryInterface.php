<?php

namespace Ebay\Mapper;

interface CategoryInterface
{
    /**
     * @return \Ebay\Entity\StructureCategoryEbay
     */
    public function getCategoryEntity();

    /**
     * @param $entity
     *
     * @return void
     */
    public function setCategoryEntity($entity);

    /**
     * Get all categories
     *
     * @return \Ebay\Entity\StructureCategoryEbay
     */
    public function getAllCategories();

    /**
     * @param $dataSourceRegional
     * @param $level
     * @param $categoryId
     *
     * @return \Ebay\Entity\StructureCategoryEbay
     */
    public function getCategory($dataSourceRegional, $level, $categoryId);
}
