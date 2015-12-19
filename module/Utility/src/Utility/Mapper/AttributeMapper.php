<?php

namespace Utility\Mapper;

use Doctrine\ORM\EntityManagerInterface;

class AttributeMapper implements AttributeMapperInterface
{
    /**
     * @var EntityManagerInterface
     */
    protected $em;

    /**
     * @var \Utility\Entity\Attribute
     */
    protected $attributeEntity = \Utility\Entity\Attribute::class;

    /**
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @return \Utility\Entity\Attribute
     */
    public function getAttributeEntity()
    {
        return $this->attributeEntity;
    }

    /**
     * @param \Utility\Entity\Attribute $attributeEntity
     */
    public function setAttributeEntity($attributeEntity)
    {
        $this->attributeEntity = $attributeEntity;
    }
}
