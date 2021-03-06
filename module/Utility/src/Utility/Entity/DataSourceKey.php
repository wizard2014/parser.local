<?php

namespace Utility\Entity;

use Doctrine\ORM\Mapping as ORM;
use Utility\Entity\Traits\TimestampableTrait;

/**
 * DataSourceKey
 *
 * @ORM\Table(name="data_source_key", indexes={@ORM\Index(name="IDX_14519431A76ED395", columns={"user_id"}), @ORM\Index(name="IDX_14519431C61772EE", columns={"data_source_global_id"})})
 * @ORM\Entity
 */
class DataSourceKey
{
    use TimestampableTrait;

    /**
     * @var string
     *
     * @ORM\Column(name="access_key", type="string", length=255, nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $accessKey;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_valid", type="boolean", nullable=false)
     */
    private $isValid = true;

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
     * Set accessKey
     *
     * @param string $accessKey
     *
     * @return DataSourceKey
     */
    public function setAccessKey($accessKey)
    {
        $this->accessKey = $accessKey;

        return $this;
    }

    /**
     * Get accessKey
     *
     * @return string
     */
    public function getAccessKey()
    {
        return $this->accessKey;
    }

    /**
     * Set isValid
     *
     * @param boolean $isValid
     *
     * @return DataSourceKey
     */
    public function setIsValid($isValid)
    {
        $this->isValid = $isValid;

        return $this;
    }

    /**
     * Get isValid
     *
     * @return boolean
     */
    public function getIsValid()
    {
        return $this->isValid;
    }

    /**
     * Set user
     *
     * @param \User\Entity\User $user
     *
     * @return DataSourceKey
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
     * @return DataSourceKey
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
