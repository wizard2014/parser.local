<?php

namespace Application\Entity;

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
     * @var string
     *
     * @ORM\Column(name="ebay_global_id", type="string", length=50, nullable=false)
     */
    private $ebayGlobalId;

    /**
     * @var string
     *
     * @ORM\Column(name="ebay_language", type="string", length=50, nullable=false)
     */
    private $ebayLanguage;

    /**
     * @var string
     *
     * @ORM\Column(name="ebay_territory", type="string", length=50, nullable=false)
     */
    private $ebayTerritory;

    /**
     * @var string
     *
     * @ORM\Column(name="ebay_site_name", type="string", length=50, nullable=false)
     */
    private $ebaySiteName;

    /**
     * @var integer
     *
     * @ORM\Column(name="ebay_site_id", type="smallint", nullable=false)
     */
    private $ebaySiteId;

    /**
     * @var \Ebay\Entity\DataSourceGlobal
     *
     * @ORM\ManyToOne(targetEntity="Ebay\Entity\DataSourceGlobal")
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
     * Set ebayGlobalId
     *
     * @param string $ebayGlobalId
     *
     * @return DataSourceRegional
     */
    public function setEbayGlobalId($ebayGlobalId)
    {
        $this->ebayGlobalId = $ebayGlobalId;

        return $this;
    }

    /**
     * Get ebayGlobalId
     *
     * @return string
     */
    public function getEbayGlobalId()
    {
        return $this->ebayGlobalId;
    }

    /**
     * Set ebayLanguage
     *
     * @param string $ebayLanguage
     *
     * @return DataSourceRegional
     */
    public function setEbayLanguage($ebayLanguage)
    {
        $this->ebayLanguage = $ebayLanguage;

        return $this;
    }

    /**
     * Get ebayLanguage
     *
     * @return string
     */
    public function getEbayLanguage()
    {
        return $this->ebayLanguage;
    }

    /**
     * Set ebayTerritory
     *
     * @param string $ebayTerritory
     *
     * @return DataSourceRegional
     */
    public function setEbayTerritory($ebayTerritory)
    {
        $this->ebayTerritory = $ebayTerritory;

        return $this;
    }

    /**
     * Get ebayTerritory
     *
     * @return string
     */
    public function getEbayTerritory()
    {
        return $this->ebayTerritory;
    }

    /**
     * Set ebaySiteName
     *
     * @param string $ebaySiteName
     *
     * @return DataSourceRegional
     */
    public function setEbaySiteName($ebaySiteName)
    {
        $this->ebaySiteName = $ebaySiteName;

        return $this;
    }

    /**
     * Get ebaySiteName
     *
     * @return string
     */
    public function getEbaySiteName()
    {
        return $this->ebaySiteName;
    }

    /**
     * Set ebaySiteId
     *
     * @param integer $ebaySiteId
     *
     * @return DataSourceRegional
     */
    public function setEbaySiteId($ebaySiteId)
    {
        $this->ebaySiteId = $ebaySiteId;

        return $this;
    }

    /**
     * Get ebaySiteId
     *
     * @return integer
     */
    public function getEbaySiteId()
    {
        return $this->ebaySiteId;
    }

    /**
     * Set dataSourceGlobal
     *
     * @param \Ebay\Entity\DataSourceGlobal $dataSourceGlobal
     *
     * @return DataSourceRegional
     */
    public function setDataSourceGlobal(\Ebay\Entity\DataSourceGlobal $dataSourceGlobal = null)
    {
        $this->dataSourceGlobal = $dataSourceGlobal;

        return $this;
    }

    /**
     * Get dataSourceGlobal
     *
     * @return \Ebay\Entity\DataSourceGlobal
     */
    public function getDataSourceGlobal()
    {
        return $this->dataSourceGlobal;
    }
}
