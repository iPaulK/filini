<?php

namespace Core\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Zend\Form\Annotation as AT;
use Doctrine\Common\Collections\ArrayCollection as ArrayCollection;
use Core\Service\Entity\Product as EntityService;

/**
 * This class represents Product, either Sofa or ...
 * It is abstract because we never have a Product entity, it's either Sofa or ...
 *
 * @ORM\Entity(repositoryClass="Core\Repository\ProductRepository")
 * @ORM\HasLifecycleCallbacks
 * @ORM\Table(name="products", uniqueConstraints={@ORM\UniqueConstraint(name="id", columns={"id"})})
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="discr", type="string", length=32)
 * @ORM\DiscriminatorMap({
 *      "sofa" = "Core\Entity\Product\Sofa",
 *      "chair" = "Core\Entity\Product\Chair",
 *      "stool" = "Core\Entity\Product\Stool",
 *      "bed" = "Core\Entity\Product\Bed",
 * })
 */
abstract class Product
{
    const STATUS_ENABLED = 1;
    const STATUS_DISABLED = 2;

    const TYPE_SOFA = 'sofa';
    const TYPE_CHAIR = 'chair';
    const TYPE_STOOL = 'stool';
    const TYPE_BED = 'bed';

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
     * @AT\Options({"label":"Name"})
     * @AT\Filter({"name":"StringTrim", "name":"StripTags"})
     * @AT\Validator({"name":"StringLength", "options":{"max":"255"}})
     * @AT\Required({"required":"true" })
     */
    protected $name;

    /**
     * @var string $slug
     *
     * @ORM\Column(type="string", length=255, unique=true)
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
     * @AT\Options({"label":"Status", "required":true, "value_options":{
     *      \Core\Entity\Product::STATUS_ENABLED :"Enabled",
     *      \Core\Entity\Product::STATUS_DISABLED :"Disabled"
     * }})
     * @AT\Required({"required":"true"})
     */
    protected $status;

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
     * @var Category
     *
     * @ORM\ManyToOne(targetEntity="Core\Entity\Category", inversedBy="products")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id", onDelete="SET NULL")
     * @AT\Type("DoctrineORMModule\Form\Element\EntitySelect")
     * @AT\Options({"label":"Category", "property":"name", "target_class":"Core\Entity\Category"})
     * @AT\Required({"required":"true" })
     **/
    protected $category;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", length=5000)
     * @AT\Options({"label":"Description"})
     * @AT\Validator({"name":"StringLength", "options":{"max":"5000"}})
     * @AT\Attributes({"type":"textarea" })
     * @AT\Required({"required":"true" })
     */
    protected $description;

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
     * @var bool
     *
     * @var boolean
     * @ORM\Column(name="is_in_stock", type="boolean")
     * @AT\Type("Zend\Form\Element\Checkbox")
     * @AT\Options({"label":"In Stock"})
     */
    protected $isInStock;

    /**
     * @var int
     *
     * @ORM\ManyToOne(targetEntity="Core\Entity\ConversionType")
     * @ORM\JoinColumn(name="conversion_id", referencedColumnName="id", onDelete="SET NULL")
     * @AT\Type("select")
     * @AT\Options({"label":"Conversion Type", "required":true, "value_options":{
     *      0: "No conversion type"
     * }})
     * @AT\Required({"required":"true"})
     */
    protected $conversionType;

    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="Core\Entity\Image")
     * @ORM\JoinTable(name="product_images_linker")
     * @AT\Exclude
     */
    protected $images;

    /**
     * @var int
     *
     * @ORM\OneToOne(targetEntity="Core\Entity\MoneyRate")
     * @ORM\JoinColumn(name="money_rate_id", referencedColumnName="id", onDelete="SET NULL")
     * @AT\Type("DoctrineORMModule\Form\Element\EntitySelect")
     * @AT\Options({"label":"Money Rate", "property":"name", "target_class":"Core\Entity\MoneyRate"})
     * @AT\Required({"required":"true"})
     */
    protected $rateType;

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
     * @var \Core\Service\Entity\Product
     *
     * @AT\Exclude
     */
    protected $service;

    /** @var array|null */
    protected $schemas = null;

    /** @var array|null */
    protected $pictures = null;

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
     * @return \Core\Service\Entity\Product
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
     * @return Product
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
     * @return Product
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
     * @return Product
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
     * Set price
     *
     * @param float $price
     *
     * @return Product
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return float
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Product
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
     * Set metaTitle
     *
     * @param string $metaTitle
     *
     * @return Product
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
     * @return Product
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
     * @return Product
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
     * Set isInStock
     *
     * @param boolean $isInStock
     *
     * @return Product
     */
    public function setIsInStock($isInStock)
    {
        $this->isInStock = $isInStock;

        return $this;
    }

    /**
     * Get isInStock
     *
     * @return boolean
     */
    public function getIsInStock()
    {
        return $this->isInStock;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Product
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
     * @return Product
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
     * Set category
     *
     * @param \Core\Entity\Category $category
     *
     * @return Product
     */
    public function setCategory(\Core\Entity\Category $category = null)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return \Core\Entity\Category
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set rate type
     *
     * @param MoneyRate $rateType
     *
     * @return Product
     */
    public function setRateType(\Core\Entity\MoneyRate $rateType = null)
    {
        $this->rateType = $rateType;

        return $this;
    }

    /**
     * Get rate type
     *
     * @return int
     */
    public function getRateType()
    {
        return $this->rateType;
    }

    /**
     * Set conversion type
     *
     * @param \Core\Entity\ConversionType $conversionType
     *
     * @return Product
     */
    public function setConversionType(\Core\Entity\ConversionType $conversionType = null)
    {
        $this->conversionType = $conversionType;

        return $this;
    }

    /**
     * Get conversion type
     *
     * @return \Core\Entity\ConversionType
     */
    public function getConversionType()
    {
        return $this->conversionType;
    }

    /**
     * Add image
     *
     * @param \Core\Entity\Image $image
     *
     * @return Product
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
    public function getImages($picturesOnly = false)
    {
        if (!$picturesOnly) {
            return $this->images;
        }

        if ($this->pictures === null) {
            $this->pictures = [];
            foreach ($this->images as $image) {
                /** @var \Core\Entity\Image $image */
                if ($image->getImageType() == 'product') {
                    $this->pictures[] = $image;
                }
            }
        }

        return $this->pictures;
    }

    /**
     * Get schemas
     *
     * @return array
     */
    public function getSchemas()
    {
        if ($this->schemas === null) {
            $this->schemas = [];
            foreach ($this->images as $image) {
                /** @var \Core\Entity\Image $image */
                if ($image->getImageType() == 'product_schema') {
                    $this->schemas[] = $image;
                }
            }
        }

        return $this->schemas;
    }
}
