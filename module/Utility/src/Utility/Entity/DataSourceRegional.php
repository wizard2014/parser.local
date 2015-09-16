<?php

namespace Utility\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DataSourceRegional
 *
 * @ORM\Table(name="data_source_regional", uniqueConstraints={@ORM\UniqueConstraint(name="data_source_regional_unique", columns={"region", "url"})}, indexes={@ORM\Index(name="IDX_FC75A937C61772EE", columns={"data_source_global_id"})})
 * @ORM\Entity
 */
class DataSourceRegional
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="data_source_regional_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="region", type="string", length=50, nullable=false)
     */
    private $region;

    /**
     * @var string
     *
     * @ORM\Column(name="url", type="string", length=255, nullable=false)
     */
    private $url;

    /**
     * @var array
     *
     * @ORM\Column(name="property_set", type="json_array", nullable=true)
     */
    private $propertySet;

    /**
     * @var \Utility\Entity\DataSourceGlobal
     *
     * @ORM\ManyToOne(targetEntity="Utility\Entity\DataSourceGlobal")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="data_source_global_id", referencedColumnName="id")
     * })
     */
    private $dataSourceGlobal;

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
     * Set region
     *
     * @param string $region
     *
     * @return DataSourceRegional
     */
    public function setRegion($region)
    {
        $this->region = $region;

        return $this;
    }

    /**
     * Get region
     *
     * @return string
     */
    public function getRegion()
    {
        return $this->region;
    }

    /**
     * Set url
     *
     * @param string $url
     *
     * @return DataSourceRegional
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set propertySet
     *
     * @param array $propertySet
     *
     * @return DataSourceRegional
     */
    public function setPropertySet($propertySet)
    {
        $this->propertySet = $propertySet;

        return $this;
    }

    /**
     * Get propertySet
     *
     * @return array
     */
    public function getPropertySet()
    {
        return $this->propertySet;
    }

    /**
     * Set dataSourceGlobal
     *
     * @param \Utility\Entity\DataSourceGlobal $dataSourceGlobal
     *
     * @return DataSourceRegional
     */
    public function setDataSourceGlobal(\Utility\Entity\DataSourceGlobal $dataSourceGlobal = null)
    {
        $this->dataSourceGlobal = $dataSourceGlobal;

        return $this;
    }

    /**
     * Get dataSourceGlobal
     *
     * @return \Utility\Entity\DataSourceGlobal
     */
    public function getDataSourceGlobal()
    {
        return $this->dataSourceGlobal;
    }
}
