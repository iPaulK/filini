<?php

namespace Core\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Zend\Form\Annotation as AT;
use Core\Service\Entity\Category as EntityService;

/**
 * @ORM\Entity(repositoryClass="Core\Repository\ConversionTypeRepository")
 * @ORM\Table(name="conversion_types")
 * @ORM\HasLifecycleCallbacks
 * @AT\Name("Conversion Type")
 */
class ConversionType
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
     * @ORM\Column(type="string", length=255)
     * @AT\Options({"label":"Name"})
     * @AT\Filter({"name":"StringTrim", "name":"StripTags"})
     * @AT\Validator({"name":"StringLength", "options":{"max":"255"}})
     * @AT\Required({"required":"true" })
     */
    protected $name;

    /**
     * @ORM\ManyToOne(targetEntity="Core\Entity\Image")
     * @ORM\JoinColumn(name="thumbnail_id", referencedColumnName="id", onDelete="SET NULL")
     * @AT\Type("Zend\Form\Element\Hidden")
     * @AT\Options({"label":"Thumbnail"})
     */
    protected $thumbnail;

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
     * @var \Core\Service\Entity\ConversionType
     *
     * @AT\Exclude
     */
    protected $service;

    public function __construct()
    {
        $this->createdAt = new DateTime();
        $this->updatedAt = new DateTime();
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
     * @return ConversionType
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
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return ConversionType
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
     * @return ConversionType
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
     * Set thumbnail
     *
     * @param \Core\Entity\Image $thumbnail
     *
     * @return ConversionType
     */
    public function setThumbnail(\Core\Entity\Image $thumbnail = null)
    {
        $this->thumbnail = $thumbnail;

        return $this;
    }

    /**
     * Get thumbnail
     *
     * @return \Core\Entity\Image
     */
    public function getThumbnail()
    {
        return $this->thumbnail;
    }
}
