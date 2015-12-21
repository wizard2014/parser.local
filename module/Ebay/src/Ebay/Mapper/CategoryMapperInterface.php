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

    /**
     * Get all categoryId group by region
     *
     * @return array
     */
    public function getAllCategoriesId();

    /**
     * Check category exists
     *
     * @return bool
     */
    public function categoriesExists();

    /**
     * @param $dataSourceRegional
     * @param $categoryId
     *
     * @return bool
     */
    public function categoryExists($dataSourceRegional, $categoryId);

    /**
     * Add category
     *
     * categoryLevel, categoryName, categoryId, categoryParentId, region
     *
     * @param $category
     */
    public function add($category);

    /**
     * Save Category
     *
     * @return bool
     */
    public function save();

    /**
     * @param $dataSourceRegional
     * @param $categoryLevel
     *
     * @return array
     */
    public function getMainCategory($dataSourceRegional, $categoryLevel);
}
