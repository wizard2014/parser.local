<?php

namespace Ebay\Entity;

use Doctrine\ORM\Mapping as ORM;
use Utility\Entity\Traits\ArraySerializableTrait;

/**
 * StructureCategoryEbay
 *
 * @ORM\Table(name="structure_category_ebay", uniqueConstraints={@ORM\UniqueConstraint(name="category_unique", columns={"data_source_regional_id", "category_id"})}, indexes={@ORM\Index(name="idx_category_parent_id", columns={"category_parent_id"}), @ORM\Index(name="idx_category_level", columns={"category_level"}), @ORM\Index(name="idx_data_source_regional_id", columns={"data_source_regional_id"})})
 * @ORM\Entity
 */
class StructureCategoryEbay
{
    use ArraySerializableTrait;

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
     * @var \DateTime
     *
     * @ORM\Column(name="date_creation", type="datetimetz", nullable=true)
     */
    private $dateCreation;

    /**
     * @var \Utility\Entity\DataSourceRegional
     *
     * @ORM\ManyToOne(targetEntity="Utility\Entity\DataSourceRegional")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="data_source_regional_id", referencedColumnName="id")
     * })
     */
    private $dataSourceRegional;

    /**
     * Set default date
     */
    public function __construct()
    {
        $this->dateCreation = new \DateTime();
    }

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
     * Set dateCreation
     *
     * @param \DateTime $dateCreation
     *
     * @return StructureCategoryEbay
     */
    public function setDateCreation($dateCreation)
    {
        $this->dateCreation = $dateCreation;

        return $this;
    }

    /**
     * Get dateCreation
     *
     * @return \DateTime
     */
    public function getDateCreation()
    {
        return $this->dateCreation;
    }

    /**
     * Set dataSourceRegional
     *
     * @param \Utility\Entity\DataSourceRegional $dataSourceRegional
     *
     * @return StructureCategoryEbay
     */
    public function setDataSourceRegional(\Utility\Entity\DataSourceRegional $dataSourceRegional = null)
    {
        $this->dataSourceRegional = $dataSourceRegional;

        return $this;
    }

    /**
     * Get dataSourceRegional
     *
     * @return \Utility\Entity\DataSourceRegional
     */
    public function getDataSourceRegional()
    {
        return $this->dataSourceRegional;
    }
}
