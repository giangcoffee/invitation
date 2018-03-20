<?php
/**
 * Created by PhpStorm.
 * User: giang
 * Date: 26/02/2016
 * Time: 20:55
 */

namespace Viettut\Model\Core;


use Viettut\Model\User\UserEntityInterface;

class Post implements PostInterface
{
    /**
     * @var integer
     */
    protected $id;

    /**
     * @var string
     */
    protected $title;

    /**
     * @var string
     */
    protected $hash;

    /**
     * @var string
     */
    protected $content;

    /** @var  string */
    protected $summary;

    /**
     * @var int
     */
    protected $view;

    /**
     * @var string
     */
    protected $video;

    /**
     * @var bool
     */
    protected $hasVideo;

    /**
     * @var bool
     */
    protected $published;

    /**
     * @var UserEntityInterface
     */
    protected $author;

    /**
     * @var string
     */
    protected $thumbnail;

    /**
     * @var \DateTime
     */
    protected $deletedAt;

    /**
     * @var \DateTime
     */
    protected $updatedAt;

    /**
     * @var \DateTime
     */
    protected $createdAt;

    /**
     * Subscriber constructor.
     */
    public function __construct()
    {
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
     * @return self
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return self
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return UserEntityInterface
     */
    public function getAuthor(): UserEntityInterface
    {
        return $this->author;
    }

    /**
     * @param UserEntityInterface $author
     * @return self
     */
    public function setAuthor($author)
    {
        $this->author = $author;
        return $this;
    }

    /**
     * @return string
     */
    public function getHash(): string
    {
        return $this->hash;
    }

    /**
     * @param string $hash
     * @return self
     */
    public function setHash($hash)
    {
        $this->hash = $hash;
        return $this;
    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @param string $content
     * @return self
     */
    public function setContent($content)
    {
        $this->content = $content;
        return $this;
    }

    /**
     * @return string
     */
    public function getSummary(): string
    {
        return $this->summary;
    }

    /**
     * @param string $summary
     * @return self
     */
    public function setSummary($summary)
    {
        $this->summary = $summary;
        return $this;
    }

    /**
     * @return int
     */
    public function getView(): int
    {
        return $this->view;
    }

    /**
     * @param int $view
     * @return self
     */
    public function setView($view)
    {
        $this->view = $view;
        return $this;
    }

    /**
     * @return string
     */
    public function getVideo(): string
    {
        return $this->video;
    }

    /**
     * @param string $video
     * @return self
     */
    public function setVideo($video)
    {
        $this->video = $video;
        return $this;
    }

    /**
     * @return boolean
     */
    public function isHasVideo(): bool
    {
        return $this->hasVideo;
    }

    /**
     * @param boolean $hasVideo
     * @return self
     */
    public function setHasVideo($hasVideo)
    {
        $this->hasVideo = $hasVideo;
        return $this;
    }

    /**
     * @return boolean
     */
    public function isPublished(): bool
    {
        return $this->published;
    }

    /**
     * @param boolean $published
     * @return self
     */
    public function setPublished($published)
    {
        $this->published = $published;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDeletedAt(): \DateTime
    {
        return $this->deletedAt;
    }

    /**
     * @return \DateTime
     */
    public function getUpdatedAt(): \DateTime
    {
        return $this->updatedAt;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @return string
     */
    public function getThumbnail(): string
    {
        return $this->thumbnail;
    }

    /**
     * @param string $thumbnail
     * @return self
     */
    public function setThumbnail($thumbnail)
    {
        $this->thumbnail = $thumbnail;
        return $this;
    }
}