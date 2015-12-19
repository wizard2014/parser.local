<?php

namespace Utility\Service;

use Utility\Mapper\AttributeMapper;
use Utility\Mapper\AttributeValueMapper;

class AttributeValueService implements AttributeValueServiceInterface
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
}
