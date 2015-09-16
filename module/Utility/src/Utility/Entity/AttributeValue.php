<?php

namespace Utility\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AttributeValue
 *
 * @ORM\Table(name="attribute_value", uniqueConstraints={@ORM\UniqueConstraint(name="attribute_value_unique", columns={"attribute_name", "attribute_value"})}, indexes={@ORM\Index(name="IDX_FE4FBB825CBDA8E", columns={"attribute_name"})})
 * @ORM\Entity
 */
class AttributeValue
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="attribute_value_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="attribute_value", type="string", length=50, nullable=false)
     */
    private $attributeValue;

    /**
     * @var \Utility\Entity\Attribute
     *
     * @ORM\ManyToOne(targetEntity="Utility\Entity\Attribute")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="attribute_name", referencedColumnName="name")
     * })
     */
    private $attributeName;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set attributeValue
     *
     * @param string $attributeValue
     *
     * @return AttributeValue
     */
    public function setAttributeValue($attributeValue)
    {
        $this->attributeValue = $attributeValue;

        return $this;
    }

    /**
     * Get attributeValue
     *
     * @return string
     */
    public function getAttributeValue()
    {
        return $this->attributeValue;
    }

    /**
     * Set attributeName
     *
     * @param \Utility\Entity\Attribute $attributeName
     *
     * @return AttributeValue
     */
    public function setAttributeName(\Utility\Entity\Attribute $attributeName = null)
    {
        $this->attributeName = $attributeName;

        return $this;
    }

    /**
     * Get attributeName
     *
     * @return \Utility\Entity\Attribute
     */
    public function getAttributeName()
    {
        return $this->attributeName;
    }
}
