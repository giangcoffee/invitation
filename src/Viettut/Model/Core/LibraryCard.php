<?php
/**
 * Created by PhpStorm.
 * User: giang
 * Date: 10/21/15
 * Time: 9:24 PM
 */

namespace Viettut\Model\Core;


use DateTime;
use Viettut\Model\User\UserEntityInterface;

class LibraryCard implements LibraryCardInterface
{
    /** @var integer */
    protected $id;

    /** @var array */
    protected $gallery;

    /** @var DateTime */
    protected $createdAt;

    /** @var  string */
    protected $video;

    /** @var  string */
    protected $videoId;

    /** @var  bool */
    protected $validVideo;

    protected $cards;

    function __construct()
    {
        $this->gallery = [];
        $this->video = '';
        $this->videoId = '';
        $this->validVideo = false;
    }

    /**
     * @param $id
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return array
     */
    public function getGallery()
    {
        return $this->gallery;
    }

    /**
     * @param array $gallery
     * @return self
     */
    public function setGallery($gallery)
    {
        $this->gallery = $gallery;
        return $this;
    }

    /**
     * @param $path
     * @return $this
     */
    public function addImage($path)
    {
        if (empty($this->gallery)) {
            $this->gallery = [];
        }

        $this->gallery[] = $path;

        return $this;
    }

    /**
     * @return string
     */
    public function getVideo(): string
    {
        if ($this->video === null) {
            return '';
        }

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
     * @return string
     */
    public function getVideoId(): string
    {
        return $this->videoId;
    }

    /**
     * @param string $videoId
     * @return self
     */
    public function setVideoId($videoId)
    {
        $this->videoId = $videoId;
        return $this;
    }

    /**
     * @return boolean
     */
    public function isValidVideo(): bool
    {
        return $this->validVideo;
    }

    /**
     * @param boolean $validVideo
     * @return self
     */
    public function setValidVideo($validVideo)
    {
        $this->validVideo = $validVideo;
        return $this;
    }

    function __toString()
    {
        return 'library_card_' . $this->id;
    }
}