<?php

namespace Core\Entity\Product;

use Doctrine\ORM\Mapping as ORM;
use Zend\Form\Annotation as AT;
use Doctrine\Common\Collections\ArrayCollection as ArrayCollection;
use Core\Entity\Product as ProductEntity;

/**
 * @ORM\Entity
 * @ORM\Table(name="products")
 * @AT\Name("Chair")
 */
class Chair extends ProductEntity
{
    /**
     * @var float
     *
     * @ORM\Column(name="weight", type="float", precision=2, scale=2, nullable=true)
     * @AT\Filter({"name":"StringTrim", "name":"StripTags"})
     * @AT\Validator({"name":"StringLength", "options":{"max":"9"}})
     * @AT\Validator({"name":"float"})
     * @AT\Options({"label":"Weight (mm.)"})
     * @AT\Attributes({"value":"0"})
     * @AT\Required({"required":"true" })
     */
    protected $weight;

    /**
     * @var float
     *
     * @ORM\Column(name="height", type="float", precision=2, scale=2, nullable=true)
     * @AT\Filter({"name":"StringTrim", "name":"StripTags"})
     * @AT\Validator({"name":"StringLength", "options":{"max":"9"}})
     * @AT\Validator({"name":"float"})
     * @AT\Options({"label":"Height (mm.)"})
     * @AT\Attributes({"value":"0"})
     * @AT\Required({"required":"true" })
     */
    protected $height;


    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Set weight
     *
     * @param float $weight
     *
     * @return Sofa
     */
    public function setWeight($weight)
    {
        $this->weight = $weight;

        return $this;
    }

    /**
     * Get weight
     *
     * @return float
     */
    public function getWeight()
    {
        return $this->weight;
    }

    /**
     * Set height
     *
     * @param float $height
     *
     * @return Sofa
     */
    public function setHeight($height)
    {
        $this->height = $height;

        return $this;
    }

    /**
     * Get height
     *
     * @return float
     */
    public function getHeight()
    {
        return $this->height;
    }
}
