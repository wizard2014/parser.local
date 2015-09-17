<?php

namespace Ebay\Mapper;

interface CategoryInterface
{
    /**
     * @return mixed
     */
    public function getCategoryEntity();

    /**
     * @param $entity
     *
     * @return void
     */
    public function setCategoryEntity($entity);
}
