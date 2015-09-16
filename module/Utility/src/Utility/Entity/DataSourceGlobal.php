<?php

namespace Utility\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DataSourceGlobal
 *
 * @ORM\Table(name="data_source_global", uniqueConstraints={@ORM\UniqueConstraint(name="data_source_global_unique", columns={"name"})})
 * @ORM\Entity
 */
class DataSourceGlobal
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="data_source_global_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=50, nullable=false)
     */
    private $name;

    /**
     * @var array
     *
     * @ORM\Column(name="filter_set", type="json_array", nullable=true)
     */
    private $filterSet;

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
     * Set name
     *
     * @param string $name
     *
     * @return DataSourceGlobal
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set filterSet
     *
     * @param array $filterSet
     *
     * @return DataSourceGlobal
     */
    public function setFilterSet($filterSet)
    {
        $this->filterSet = $filterSet;

        return $this;
    }

    /**
     * Get filterSet
     *
     * @return array
     */
    public function getFilterSet()
    {
        return $this->filterSet;
    }
}
