<?php

namespace User\Entity;

use BjyAuthorize\Acl\HierarchicalRoleInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * Role
 *
 * @ORM\Table(name="user_role", uniqueConstraints={@ORM\UniqueConstraint(name="role_id_unique", columns={"role_id"})}, indexes={@ORM\Index(name="IDX_2DE8C6A3727ACA70", columns={"parent_id"})})
 * @ORM\Entity
 */
class Role implements HierarchicalRoleInterface
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="user_role_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="role_id", type="string", length=255, nullable=false)
     */
    private $roleId;

    /**
     * @var integer
     *
     * @ORM\Column(name="is_default", type="smallint", nullable=false)
     */
    private $isDefault;

    /**
     * @var \User\Entity\Role
     *
     * @ORM\ManyToOne(targetEntity="User\Entity\Role")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="parent_id", referencedColumnName="id")
     * })
     */
    private $parent;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="User\Entity\User", mappedBy="role")
     */
    private $user;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->user = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set roleId
     *
     * @param string $roleId
     *
     * @return Role
     */
    public function setRoleId($roleId)
    {
        $this->roleId = $roleId;

        return $this;
    }

    /**
     * Get roleId
     *
     * @return string
     */
    public function getRoleId()
    {
        return $this->roleId;
    }

    /**
     * Set isDefault
     *
     * @param integer $isDefault
     *
     * @return Role
     */
    public function setIsDefault($isDefault)
    {
        $this->isDefault = $isDefault;

        return $this;
    }

    /**
     * Get isDefault
     *
     * @return integer
     */
    public function getIsDefault()
    {
        return $this->isDefault;
    }

    /**
     * Set parent
     *
     * @param \User\Entity\Role $parent
     *
     * @return Role
     */
    public function setParent(\User\Entity\Role $parent = null)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Get parent
     *
     * @return \User\Entity\Role
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Add user
     *
     * @param \User\Entity\User $user
     *
     * @return Role
     */
    public function addUser(\User\Entity\User $user)
    {
        $this->user[] = $user;

        return $this;
    }

    /**
     * Remove user
     *
     * @param \User\Entity\User $user
     */
    public function removeUser(\User\Entity\User $user)
    {
        $this->user->removeElement($user);
    }

    /**
     * Get user
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUser()
    {
        return $this->user;
    }
}
