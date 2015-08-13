<?php

namespace Ebay\Mapper;

interface ConsoleCategoryInterface
{
    public function findEbayCategoryBy($level, $idParent);
}
