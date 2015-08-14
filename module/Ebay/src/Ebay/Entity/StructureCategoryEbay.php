<?php

namespace Ebay\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * StructureCategoryEbay
 *
 * @ORM\Table(name="structure_category_ebay", uniqueConstraints={@ORM\UniqueConstraint(name="category_unique", columns={"data_source_regional_id", "category_id"})}, indexes={@ORM\Index(name="idx_category_parent_id", columns={"category_parent_id"}), @ORM\Index(name="idx_data_source_regional_id", columns={"data_source_regional_id"}), @ORM\Index(name="idx_category_level", columns={"category_level"})})
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
     * @ORM\Column(name="category_id", type="integer", nullable=false)
     */
    private $categoryId = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="category_parent_id", type="integer", nullable=false)
     */
    private $categoryParentId = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="category_level", type="integer", nullable=false)
     */
    private $categoryLevel = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="category_name", type="string", length=255, nullable=false)
     */
    private $categoryName;

    /**
     * @var \Ebay\Entity\DataSourceRegional
     *
     * @ORM\ManyToOne(targetEntity="Ebay\Entity\DataSourceRegional")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="data_source_regional_id", referencedColumnName="id")
     * })
     */
    private $dataSourceRegional;

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
     * Set dataSourceRegional
     *
     * @param \Ebay\Entity\DataSourceRegional $dataSourceRegional
     *
     * @return StructureCategoryEbay
     */
    public function setDataSourceRegional(\Ebay\Entity\DataSourceRegional $dataSourceRegional = null)
    {
        $this->dataSourceRegional = $dataSourceRegional;

        return $this;
    }

    /**
     * Get dataSourceRegional
     *
     * @return \Ebay\Entity\DataSourceRegional
     */
    public function getDataSourceRegional()
    {
        return $this->dataSourceRegional;
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
