<?php
namespace Core\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Zend\Form\Annotation as AT;
use Doctrine\Common\Collections\ArrayCollection as ArrayCollection;

/**
 * @ORM\Entity(repositoryClass="Core\Repository\RoleRepository")
 * @ORM\Table(name="roles")
 */
class Role
{
    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\Column(name="id", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @AT\Exclude
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=50)
     * @AT\Options({"label":"Name"})
     * @AT\Filter({"name":"StringTrim", "name":"StripTags"})
     * @AT\Validator({"name":"StringLength", "options":{"max":"50"}})
     * @AT\Required({"required":"true" })
     */
    protected $name;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", length=255)
     * @AT\Filter({"name":"StringTrim", "name":"StripTags"})
     * @AT\Options({"label":"Description"})
     * @AT\Validator({"name":"StringLength", "options":{"max":"255"}})
     * @AT\Attributes({"type":"textarea" })
     * @AT\Required({"required":"true" })
     */
    protected $description;

    /**
     * @ORM\OneToMany(targetEntity="Core\Entity\Role", mappedBy="parent")
     * @AT\Exclude
     **/
    protected $children;

    /**
     * @ORM\ManyToOne(targetEntity="Core\Entity\Role", inversedBy="children")
     * @ORM\JoinColumn(name="parent_id", referencedColumnName="id", nullable=true)
     * @AT\Options({"label":"Parent Role"})
     * @AT\Attributes({"required":false})
     * @AT\Required(false)
     **/
    protected $parent;
    
    /**
     * @ORM\ManyToMany(targetEntity="Core\Entity\Permission", inversedBy="roles")
     * @ORM\JoinTable(name="role_permission",
     *      joinColumns={@ORM\JoinColumn(name="role_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="permission_id", referencedColumnName="id")}
     *      )
     * @AT\Exclude
     */
    protected $permissions;

    /**
     * @var DateTime
     *
     * @ORM\Column(name="created_at", type="datetime")
     * @AT\Exclude
     */
    protected $createdAt;

    /**
     * Initializes variables
     */
    public function __construct()
    {
        $this->createdAt = new DateTime();

        $this->children = new ArrayCollection();
        $this->permissions = new ArrayCollection();
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
     * Set name
     *
     * @param string $name
     *
     * @return Role
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
     * Set description
     *
     * @param string $description
     *
     * @return Role
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Role
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    
    /**
     * Add child
     *
     * @param \Core\Entity\Role $child
     *
     * @return Role
     */
    public function addChild(\Core\Entity\Role $child)
    {
        $this->children[] = $child;

        return $this;
    }

    /**
     * Remove child
     *
     * @param \Core\Entity\Role $child
     */
    public function removeChild(\Core\Entity\Role $child)
    {
        $this->children->removeElement($child);
    }

    /**
     * Get children
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * Set parent
     *
     * @param \Core\Entity\Role $parent
     *
     * @return Role
     */
    public function setParent(\Core\Entity\Role $parent = null)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Get parent
     *
     * @return \Core\Entity\Role
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Add permission
     *
     * @param \Core\Entity\Permission $permission
     *
     * @return Role
     */
    public function addPermission(\Core\Entity\Permission $permission)
    {
        $this->permissions[] = $permission;

        return $this;
    }

    /**
     * Remove permission
     *
     * @param \Core\Entity\Permission $permission
     */
    public function removePermission(\Core\Entity\Permission $permission)
    {
        $this->permissions->removeElement($permission);
    }

    /**
     * Get permissions
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPermissions()
    {
        return $this->permissions;
    }
}
