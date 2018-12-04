<?php

namespace Core\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Zend\Form\Annotation as AT;
use Doctrine\Common\Collections\ArrayCollection as ArrayCollection;
use Core\Service\Entity\OurWorkCategory as EntityService;

/**
 * @ORM\Entity(repositoryClass="Core\Repository\OurWorkCategoryRepository")
 * @ORM\HasLifecycleCallbacks
 * @ORM\Table(name="our_work_categories")
 * @AT\Name("OurWorkCategory")
 */
class OurWorkCategory
{
    const STATUS_ENABLED = 1;
    const STATUS_DISABLED = 2;

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
     * @ORM\Column(type="string", length=255)
     * @AT\Options({"label":"Category Name: "})
     * @AT\Filter({"name":"StringTrim", "name":"StripTags"})
     * @AT\Validator({"name":"StringLength", "options":{"max":"255"}})
     * @AT\Required({"required":"true" })
     */
    protected $name;

    /**
     * @var string $slug
     *
     * @ORM\Column(type="string", length=255)
     * @AT\Options({"label":"Slug", "allow_empty":true})
     * @AT\Filter({"name":"StringTrim", "name":"StripTags"})
     * @AT\Validator({"name":"StringLength", "options":{"max":"255"}})
     * @AT\Validator({"name":"Regex", "options":{
     *     "pattern":"/^[a-z0-9]+(?:-[a-z0-9]+)*$/i"
     * }})
     * @AT\Required({"required":"true"})
     */
    protected $slug;

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="integer", length=1)
     * @AT\Type("select")
     * @AT\Options({"label":"Status: ", "required":true, "value_options":{
     *      \Core\Entity\Category::STATUS_ENABLED :"Enabled",
     *      \Core\Entity\Category::STATUS_DISABLED :"Disabled"
     * }})
     * @AT\Required({"required":"true"})
     */
    protected $status;

    /**
     * @ORM\OneToMany(targetEntity="Category", mappedBy="parent")
     * @AT\Exclude
     **/
    protected $children;

    /**
     * @ORM\ManyToOne(targetEntity="Core\Entity\Category", inversedBy="children")
     * @ORM\JoinColumn(name="parent_id", referencedColumnName="id", nullable=true )
     * @AT\Options({"label":"Parent Category: "})
     * @AT\Required({"required":"true"})
     * @AT\Exclude
     **/
    protected $parent;

    /**
     * @var string
     *
     * @ORM\Column(name="meta_title", type="string", length=255, nullable=true)
     * @AT\Filter({"name":"StringTrim", "name":"StripTags"})
     * @AT\Options({"label":"Meta Title"})
     * @AT\Validator({"name":"StringLength", "options":{"max":"250"}})
     * @AT\Required({"required":"false"})
     */
    protected $metaTitle;

    /**
     * @var string
     *
     * @ORM\Column(name="meta_keywords", type="text", length=500, nullable=true)
     * @AT\Filter({"name":"StringTrim", "name":"StripTags"})
     * @AT\Options({"label":"Meta Keywords"})
     * @AT\Validator({"name":"StringLength", "options":{"max":"500"}})
     * @AT\Attributes({"type":"textarea" })
     * @AT\Required({"required":"false"})
     */
    protected $metaKeywords;

    /**
     * @var string
     *
     * @ORM\Column(name="meta_description", type="text", length=5000, nullable=true)
     * @AT\Filter({"name":"StringTrim", "name":"StripTags"})
     * @AT\Options({"label":"Meta Description"})
     * @AT\Validator({"name":"StringLength", "options":{"max":"5000"}})
     * @AT\Attributes({"type":"textarea" })
     * @AT\Required({"required":"false" })
     */
    protected $metaDescription;

    /**
     * @var \Doctrine\Common\Collections\Collection
     * @ORM\OneToMany(targetEntity="Core\Entity\OurWork", mappedBy="ourWorkCategory")
     * @AT\Exclude
     **/
    protected $ourWorks;

    /**
     * @var DateTime
     *
     * @ORM\Column(name="created_at", type="datetime")
     * @AT\Exclude
     */
    protected $createdAt;

    /**
     * @var DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime")
     * @AT\Exclude
     */
    protected $updatedAt;

    /**
     * @var \Core\Service\Entity\OurWorkCategory
     *
     * @AT\Exclude
     */
    protected $service;

    public function __construct()
    {
        $this->createdAt = new DateTime();
        $this->updatedAt = new DateTime();

        $this->children = new ArrayCollection();
        $this->ourWorks = new ArrayCollection();
    }

    /**
     * Operations before update
     *
     * @ORM\PreUpdate
     */
    public function preUpdate()
    {
        $this->updatedAt = new DateTime();
    }

    /**
     * @return \Core\Service\Entity\OurWorkCategory
     */
    public function getService()
    {
        if (!$this->service) {
            $this->service = new EntityService($this);
        }
        return $this->service;
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
     * @return Category
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
     * Set slug
     *
     * @param string $slug
     *
     * @return Category
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set status
     *
     * @param integer $status
     *
     * @return Category
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return integer
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set metaTitle
     *
     * @param string $metaTitle
     *
     * @return Category
     */
    public function setMetaTitle($metaTitle)
    {
        $this->metaTitle = $metaTitle;

        return $this;
    }

    /**
     * Get metaTitle
     *
     * @return string
     */
    public function getMetaTitle()
    {
        return $this->metaTitle;
    }

    /**
     * Set metaKeywords
     *
     * @param string $metaKeywords
     *
     * @return Category
     */
    public function setMetaKeywords($metaKeywords)
    {
        $this->metaKeywords = $metaKeywords;

        return $this;
    }

    /**
     * Get metaKeywords
     *
     * @return string
     */
    public function getMetaKeywords()
    {
        return $this->metaKeywords;
    }

    /**
     * Set metaDescription
     *
     * @param string $metaDescription
     *
     * @return Category
     */
    public function setMetaDescription($metaDescription)
    {
        $this->metaDescription = $metaDescription;

        return $this;
    }

    /**
     * Get metaDescription
     *
     * @return string
     */
    public function getMetaDescription()
    {
        return $this->metaDescription;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Category
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
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     *
     * @return Category
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Add child
     *
     * @param \Core\Entity\Category $child
     *
     * @return Category
     */
    public function addChild(\Core\Entity\Category $child)
    {
        $this->children[] = $child;

        return $this;
    }

    /**
     * Remove child
     *
     * @param \Core\Entity\Category $child
     */
    public function removeChild(\Core\Entity\Category $child)
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
     * @param \Core\Entity\Category $parent
     *
     * @return Category
     */
    public function setParent(\Core\Entity\Category $parent = null)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Get parent
     *
     * @return \Core\Entity\Category
     */
    public function getParent()
    {
        return $this->parent;
    }
    
    /**
     * Add our work
     *
     * @param \Core\Entity\OurWork $ourWorks
     *
     * @return OurWorkCategory
     */
    public function addOurWork(\Core\Entity\OurWork $ourWork)
    {
        $this->ourWorks[] = $product;

        return $this;
    }

    /**
     * Remove our work
     *
     * @param \Core\Entity\OurWork $ourWork
     */
    public function removeOurWork(\Core\Entity\OurWork $ourWork)
    {
        $this->ourWorks->removeElement($product);
    }

    /**
     * Get ourWorks
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getOurWorks()
    {
        return $this->ourWorks;
    }
}
