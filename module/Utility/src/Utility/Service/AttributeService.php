<?php

namespace Utility\Service;

use Utility\Mapper\AttributeMapper;
use Utility\Mapper\AttributeValueMapper;

class AttributeService implements AttributeServiceInterface
{
    /**
     * @var AttributeMapper
     */
    protected $attributeMapper;

    /**
     * @var AttributeValueMapper
     */
    protected $attributeValueMapper;

    /**
     * @param AttributeMapper      $attributeMapper
     * @param AttributeValueMapper $attributeValueMapper
     */
    public function __construct(
        AttributeMapper      $attributeMapper,
        AttributeValueMapper $attributeValueMapper
    ) {
        $this->attributeMapper      = $attributeMapper;
        $this->attributeValueMapper = $attributeValueMapper;
    }

    public function getAllAttribute()
    {
        return $this->attributeMapper->getAllAttribute();
    }

    public function getAttributeValueById($id)
    {
        return $this->attributeValueMapper->getAttributeValueById($id);
    }
}
