<?php

namespace Ebay\Mapper;

interface CategoryMapperInterface
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
     * Get the ids of the categories
     *
     * @param $dataSourceRegional
     * @param $level
     * @param $categoryId
     *
     * @return array
     */
    public function getCategory($dataSourceRegional, $level, $categoryId);
}
