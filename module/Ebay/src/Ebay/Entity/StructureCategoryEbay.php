<?php

namespace Ebay\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * StructureCategoryEbay
 *
 * @ORM\Table(name="structure_category_ebay", uniqueConstraints={@ORM\UniqueConstraint(name="category_id_unique", columns={"category_id"})}, indexes={@ORM\Index(name="idx_category_parent_id", columns={"category_parent_id"})})
 * @ORM\Entity
 */
class StructureCategoryEbay
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="structure_category_ebay_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var integer
     *
     * @ORM\Column(name="category_id", type="integer", nullable=true)
     */
    private $categoryId = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="category_parent_id", type="integer", nullable=true)
     */
    private $categoryParentId = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="category_level", type="integer", nullable=true)
     */
    private $categoryLevel = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="category_name", type="string", length=255, nullable=false)
     */
    private $categoryName;

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
     * Set categoryId
     *
     * @param integer $categoryId
     *
     * @return StructureCategoryEbay
     */
    public function setCategoryId($categoryId)
    {
        $this->categoryId = $categoryId;

        return $this;
    }

    /**
     * Get categoryId
     *
     * @return integer
     */
    public function getCategoryId()
    {
        return $this->categoryId;
    }

    /**
     * Set categoryParentId
     *
     * @param integer $categoryParentId
     *
     * @return StructureCategoryEbay
     */
    public function setCategoryParentId($categoryParentId)
    {
        $this->categoryParentId = $categoryParentId;

        return $this;
    }

    /**
     * Get categoryParentId
     *
     * @return integer
     */
    public function getCategoryParentId()
    {
        return $this->categoryParentId;
    }

    /**
     * Set categoryLevel
     *
     * @param integer $categoryLevel
     *
     * @return StructureCategoryEbay
     */
    public function setCategoryLevel($categoryLevel)
    {
        $this->categoryLevel = $categoryLevel;

        return $this;
    }

    /**
     * Get categoryLevel
     *
     * @return integer
     */
    public function getCategoryLevel()
    {
        return $this->categoryLevel;
    }

    /**
     * Set categoryName
     *
     * @param string $categoryName
     *
     * @return StructureCategoryEbay
     */
    public function setCategoryName($categoryName)
    {
        $this->categoryName = $categoryName;

        return $this;
    }

    /**
     * Get categoryName
     *
     * @return string
     */
    public function getCategoryName()
    {
        return $this->categoryName;
    }

    /**
     * @param array $data
     */
    public function populate(array $data)
    {
        foreach ($data as $key => $val) {
            $this->$key = $val;
        }
    }
}
