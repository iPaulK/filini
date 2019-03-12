<?php

namespace Core\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Zend\Form\Annotation as AT;
use Doctrine\Common\Collections\ArrayCollection as ArrayCollection;
use Core\Service\Entity\Category as EntityService;

/**
 * @ORM\Entity(repositoryClass="Core\Repository\PromotionRepository")
 * @ORM\Table(name="promotions")
 * @ORM\HasLifecycleCallbacks
 * @AT\Name("Promotion")
 */
class Promotion
{
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 2;

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
     * @AT\Options({"label":"Title"})
     * @AT\Filter({"name":"StringTrim", "name":"StripTags"})
     * @AT\Validator({"name":"StringLength", "options":{"max":"255"}})
     * @AT\Required({"required":"true" })
     */
    protected $title;

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
     * @ORM\Column(name="status", type="integer", length=1)
     * @AT\Type("select")
     * @AT\Options({"label":"Status", "required":true, "value_options":{
     *      \Core\Entity\Promotion::STATUS_ACTIVE :"Active",
     *      \Core\Entity\Promotion::STATUS_INACTIVE :"Inactive"
     * }})
     * @AT\Required({"required":"true"})
     */
    protected $status;

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
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param DateTime $createdAt
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @param DateTime $updatedAt
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
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


}