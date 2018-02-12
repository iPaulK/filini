<?php

namespace Core\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Zend\Form\Annotation as AT;
use Doctrine\Common\Collections\ArrayCollection as ArrayCollection;
use Core\Service\Entity\OurWork as EntityService;

/**
 * @ORM\Entity(repositoryClass="Core\Repository\OurWorkRepository")
 * @ORM\HasLifecycleCallbacks
 * @ORM\Table(name="our_works")
 * @AT\Name("OrWork")
 */
class OurWork
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
     * @AT\Options({"label":"Name: "})
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
     * @var string
     *
     * @ORM\Column(name="description", type="text", length=5000)
     * @AT\Filter({"name":"StringTrim", "name":"StripTags"})
     * @AT\Options({"label":"Descrition"})
     * @AT\Validator({"name":"StringLength", "options":{"max":"5000"}})
     * @AT\Attributes({"type":"textarea" })
     * @AT\Required({"required":"true" })
     */
    protected $description;

    /**
     * @var float
     *
     * @ORM\Column(name="price", type="decimal", precision=12, scale=4, nullable=true)
     * @AT\Filter({"name":"StringTrim", "name":"StripTags"})
     * @AT\Validator({"name":"StringLength", "options":{"max":"9"}})
     * @AT\Validator({"name":"Float"})
     * @AT\Options({"label":"Price"})
     * @AT\Attributes({"value":"0"})
     * @AT\Required({"required":"true" })
     */
    protected $price;

    /**
     * @var OurWorkCategory
     *
     * @ORM\ManyToOne(targetEntity="Core\Entity\OurWorkCategory", inversedBy="ourWorks")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id", onDelete="SET NULL")
     * @AT\Type("DoctrineORMModule\Form\Element\EntitySelect")
     * @AT\Options({"label":"Category", "property":"name", "target_class":"Core\Entity\OurWorkCategory"})
     * @AT\Required({"required":"true" })
     **/
    protected $ourWorkCategory;

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
     * @AT\Options({"label":"Meta Descrition"})
     * @AT\Validator({"name":"StringLength", "options":{"max":"5000"}})
     * @AT\Attributes({"type":"textarea" })
     * @AT\Required({"required":"false" })
     */
    protected $metaDescription;

    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="Core\Entity\Image")
     * @ORM\JoinTable(name="our_work_images_linker")
     * @AT\Exclude
     */
    protected $images;

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
     * @var \Core\Service\Entity\Category
     *
     * @AT\Exclude
     */
    protected $service;

    public function __construct()
    {
        $this->createdAt = new DateTime();
        $this->updatedAt = new DateTime();

        $this->images = new ArrayCollection();
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
     * @return \Core\Service\Entity\Category
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
     * @return OurWork
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
     * @return OurWork
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
     * @return OurWork
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
     * Set description
     *
     * @param string $description
     *
     * @return OurWork
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
     * Set price
     *
     * @param string $price
     *
     * @return OurWork
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return string
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set ourWorkCategory
     *
     * @param \Core\Entity\OurWorkCategory $ourWorkCategory
     *
     * @return Product
     */
    public function setOurWorkCategory(\Core\Entity\OurWorkCategory $ourWorkCategory = null)
    {
        $this->ourWorkCategory = $ourWorkCategory;

        return $this;
    }

    /**
     * Get ourWorkCategory
     *
     * @return \Core\Entity\OurWorkCategory
     */
    public function getOurWorkCategory()
    {
        return $this->ourWorkCategory;
    }

    /**
     * Set metaTitle
     *
     * @param string $metaTitle
     *
     * @return OurWork
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
     * @return OurWork
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
     * @return OurWork
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
     * @return OurWork
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
     * @return OurWork
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
     * Add image
     *
     * @param \Core\Entity\Image $image
     *
     * @return OurWork
     */
    public function addImage(\Core\Entity\Image $image)
    {
        $this->images[] = $image;

        return $this;
    }

    /**
     * Remove image
     *
     * @param \Core\Entity\Image $image
     */
    public function removeImage(\Core\Entity\Image $image)
    {
        $this->images->removeElement($image);
    }

    /**
     * Get images
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getImages()
    {
        return $this->images;
    }
}