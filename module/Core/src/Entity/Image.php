<?php

namespace Core\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="images")
 * @ORM\HasLifecycleCallbacks()
 */
class Image
{
    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\Column(name="id", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var File
     *
     * @ORM\ManyToOne(targetEntity="Core\Entity\File", cascade={"persist"})
     * @ORM\JoinColumn(name="file_id", referencedColumnName="id", onDelete="CASCADE")
     **/
    protected $file;

    /**
     * @var int
     *
     * @ORM\Column(name="width", type="integer")
     */
    protected $width;

    /**
     * @var int
     *
     * @ORM\Column(name="height", type="integer")
     */
    protected $height;

    /**
     * @var DateTime
     *
     * @ORM\Column(name="created_at", type="datetime")
     */
    protected $createdAt;

    /**
     * @var DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime")
     */
    protected $updatedAt;

    /**
     * @var string
     *
     * @ORM\Column(name="image_type", type="string", length=128, nullable=true)
     */
    private $imageType;

    /**
     * Initializes variables
     */
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
     * Get image relative url
     *
     * @param string $preset string
     *
     * @return string
     */
    public function getRelativeUrl($preset = '')
    {
        $file = $this->file;
        if (! $file) {
            return '';
        }
        $preset = $preset ?: $file->getId();
        $url = $file->getPath() . $file->getId() . DIRECTORY_SEPARATOR . $preset;
        if ($ext = pathinfo($file->getName(), PATHINFO_EXTENSION)) {
            $url .= '.' . $ext;
        }
        return $url;
    }

    /**
     * Get image absolute url
     *
     * @param string $preset string
     *
     * @return string
     */
    public function getAbsoluteUrl($preset = '')
    {
        $relative = $this->getRelativeUrl($preset);
        if ($relative === '') {
            return '';
        }
        $scheme = isset($_SERVER['REQUEST_SCHEME']) ? $_SERVER['REQUEST_SCHEME'] : 'http';
        $root = sprintf('%s://%s', $scheme, $_SERVER['SERVER_NAME']);
        $base = dirname($_SERVER['PHP_SELF']);
        $url = rtrim($root, '/') . '/' . trim($base, '/') . '/' . ltrim($relative, '/');
        return $url;
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
     * Set width
     *
     * @param integer $width
     *
     * @return Image
     */
    public function setWidth($width)
    {
        $this->width = $width;

        return $this;
    }

    /**
     * Get width
     *
     * @return integer
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * Set height
     *
     * @param integer $height
     *
     * @return Image
     */
    public function setHeight($height)
    {
        $this->height = $height;

        return $this;
    }

    /**
     * Get height
     *
     * @return integer
     */
    public function getHeight()
    {
        return $this->height;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Image
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
     * @return Image
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
     * Set file
     *
     * @param \Core\Entity\File $file
     *
     * @return Image
     */
    public function setFile(\Core\Entity\File $file = null)
    {
        $this->file = $file;

        return $this;
    }

    /**
     * Get file
     *
     * @return \Core\Entity\File
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * Set imageType
     *
     * @param string $imageType
     *
     * @return User
     */
    public function setImageType($imageType)
    {
        $this->imageType = $imageType;

        return $this;
    }

    /**
     * Get imageType
     *
     * @return string
     */
    public function getImageType()
    {
        return $this->imageType;
    }
}
