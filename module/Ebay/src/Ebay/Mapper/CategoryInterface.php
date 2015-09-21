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
     * @param $id
     *
     * @return \Ebay\Entity\StructureCategoryEbay
     */
//    public function getCategoryById($id);

    /**
     * @param $categoryId
     *
     * @return \Ebay\Entity\StructureCategoryEbay
     */
//    public function getCategoryByCategoryId($categoryId);

    /**
     * @param $categoryLevel
     *
     * @return \Ebay\Entity\StructureCategoryEbay
     */
//    public function getCategoriesByLevel($categoryLevel);
}
