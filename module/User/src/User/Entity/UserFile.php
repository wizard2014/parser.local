<?php

namespace User\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * UserFile
 *
 * @ORM\Table(name="user_file", indexes={@ORM\Index(name="IDX_F61E7AD9A76ED395", columns={"user_id"}), @ORM\Index(name="IDX_F61E7AD9C61772EE", columns={"data_source_global_id"})})
 * @ORM\Entity
 */
class UserFile
{
    /**
     * @var string
     *
     * @ORM\Column(name="name_file", type="string", length=50, nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $nameFile;

    /**
     * @var string
     *
     * @ORM\Column(name="path_file", type="string", length=50, nullable=false)
     */
    private $pathFile;

    /**
     * @var \DateTime
     *
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(name="date_creation", type="datetimetz", nullable=true)
     */
    private $dateCreation;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_expiration", type="datetimetz", nullable=true)
     */
    private $dateExpiration;

    /**
     * @var integer
     *
     * @ORM\Column(name="qty_downloaded", type="integer", nullable=false)
     */
    private $qtyDownloaded = '0';

    public function __construct()
    {
        if (is_null($this->dateExpiration)) {
            $this->dateExpiration = (new \DateTime())->modify('+1 month');
        }
    }

    /**
     * @var \User\Entity\User
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="User\Entity\User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user_id", referencedColumnName="user_id")
     * })
     */
    private $user;

    /**
     * @var \Utility\Entity\DataSourceGlobal
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="Utility\Entity\DataSourceGlobal")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="data_source_global_id", referencedColumnName="id")
     * })
     */
    private $dataSourceGlobal;

    /**
     * Set nameFile
     *
     * @param string $nameFile
     *
     * @return UserFile
     */
    public function setNameFile($nameFile)
    {
        $this->nameFile = $nameFile;

        return $this;
    }

    /**
     * Get nameFile
     *
     * @return string
     */
    public function getNameFile()
    {
        return $this->nameFile;
    }

    /**
     * Set pathFile
     *
     * @param string $pathFile
     *
     * @return UserFile
     */
    public function setPathFile($pathFile)
    {
        $this->pathFile = $pathFile;

        return $this;
    }

    /**
     * Get pathFile
     *
     * @return string
     */
    public function getPathFile()
    {
        return $this->pathFile;
    }

    /**
     * Set dateCreation
     *
     * @param \DateTime $dateCreation
     *
     * @return UserFile
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
     * Set dateExpiration
     *
     * @param \DateTime $dateExpiration
     *
     * @return UserFile
     */
    public function setDateExpiration($dateExpiration)
    {
        $this->dateExpiration = $dateExpiration;

        return $this;
    }

    /**
     * Get dateExpiration
     *
     * @return \DateTime
     */
    public function getDateExpiration()
    {
        return $this->dateExpiration;
    }

    /**
     * Set qtyDownloaded
     *
     * @param integer $qtyDownloaded
     *
     * @return UserFile
     */
    public function setQtyDownloaded($qtyDownloaded)
    {
        $this->qtyDownloaded = $qtyDownloaded;

        return $this;
    }

    /**
     * Get qtyDownloaded
     *
     * @return integer
     */
    public function getQtyDownloaded()
    {
        return $this->qtyDownloaded;
    }

    /**
     * Set user
     *
     * @param \User\Entity\User $user
     *
     * @return UserFile
     */
    public function setUser(\User\Entity\User $user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \User\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set dataSourceGlobal
     *
     * @param \Utility\Entity\DataSourceGlobal $dataSourceGlobal
     *
     * @return UserFile
     */
    public function setDataSourceGlobal(\Utility\Entity\DataSourceGlobal $dataSourceGlobal)
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
