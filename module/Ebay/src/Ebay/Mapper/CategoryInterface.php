<?php

namespace Ebay\Mapper;

interface CategoryInterface
{
    public function findEbayCategoryBy($level, $idParent);
}
