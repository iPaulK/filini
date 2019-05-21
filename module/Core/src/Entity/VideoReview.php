<?php


namespace Core\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Zend\Form\Annotation as AT;
use Core\Service\Entity\VideoReview as EntityService;

/**
 * @ORM\Entity(repositoryClass="Core\Repository\VideoReviewRepository")
 * @ORM\Table(name="video_reviews")
 * @ORM\HasLifecycleCallbacks
 * @AT\Name("Video Reviews")
 */
class VideoReview
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
     * @AT\Options({"label":"Title"})
     * @AT\Filter({"name":"StringTrim", "name":"StripTags"})
     * @AT\Validator({"name":"StringLength", "options":{"max":"255"}})
     * @AT\Required({"required":"true" })
     */
    protected $title;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     * @AT\Options({"label":"Text"})
     * @AT\Filter({"name":"StringTrim", "name":"StripTags"})
     * @AT\Validator({"name":"StringLength", "options":{"max":"1024"}})
     * @AT\Required({"required":"false" })
     */
    protected $text;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     * @AT\Options({"label":"Youtube link"})
     * @AT\Filter({"name":"StringTrim", "name":"StripTags"})
     * @AT\Validator({"name":"StringLength", "options":{"max":"1024"}})
     * @AT\Required({"required":"true" })
     */
    protected $youtubeLink;

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
     * @var EntityService
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
     * @return EntityService
     */
    public function getService()
    {
        if (!$this->service) {
            $this->service = new EntityService($this);
        }
        return $this->service;
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
     *
     * @return VideoReview
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
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
     *
     * @return VideoReview
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @param string $text
     *
     * @return VideoReview
     */
    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }

    /**
     * @return string
     */
    public function getYoutubeLink()
    {
        return $this->youtubeLink;
    }

    /**
     * @param string $youtubeLink
     *
     * @return VideoReview
     */
    public function setYoutubeLink($youtubeLink)
    {
        $this->youtubeLink = $youtubeLink;

        return $this;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return VideoReview
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
     * @return VideoReview
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
}