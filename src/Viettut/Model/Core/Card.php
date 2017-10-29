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

class Card implements CardInterface
{
    /**
     * @var integer
     */
    protected $id;

    /**
     * @var string
     */
    protected $hash;

    /**
     * @var array
     */
    protected $data;

    /**
     * @var TemplateInterface
     */
    protected $template;

    /**
     * @var UserEntityInterface
     */
    protected $author;

    /**
     * @var array
     */
    protected $gallery;

    /**
     * @var DateTime
     */
    protected $weddingDate;

    /**
     * @var array
     */
    protected $comments;

    /**
     * @var \DateTime
     */
    protected $createdAt;

    /**
     * @var \DateTime
     */
    protected $deletedAt;

    protected $longitude;

    protected $latitude;


    /**
     * @var bool
     */
    protected $forGroom;


    function __construct()
    {
        $this->forGroom = true;
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
     * Get deletedAt
     *
     * @return \DateTime
     */
    public function getDeletedAt()
    {
        return $this->deletedAt;
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
     * @return string
     */
    public function getHash()
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
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param array $data
     * @return self
     */
    public function setData($data)
    {
        $this->data = $data;
        return $this;
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
     * @return TemplateInterface
     */
    public function getTemplate()
    {
        return $this->template;
    }

    /**
     * @param TemplateInterface $template
     * @return self
     */
    public function setTemplate($template)
    {
        $this->template = $template;
        return $this;
    }

    /**
     * @return UserEntityInterface
     */
    public function getAuthor()
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
     * @return array
     */
    public function getComments()
    {
        return $this->comments;
    }

    /**
     * @param array $comments
     * @return self
     */
    public function setComments($comments)
    {
        $this->comments = $comments;
        return $this;
    }

    /**
     * @return DateTime
     */
    public function getWeddingDate()
    {
        return $this->weddingDate;
    }

    /**
     * @param DateTime $weddingDate
     * @return self
     */
    public function setWeddingDate($weddingDate)
    {
        $this->weddingDate = $weddingDate;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * @param mixed $longitude
     * @return self
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * @param mixed $latitude
     * @return self
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;
        return $this;
    }


    /**
     * @return boolean
     */
    public function isForGroom()
    {
        return $this->forGroom;
    }

    /**
     * @param boolean $forGroom
     */
    public function setForGroom($forGroom)
    {
        $this->forGroom = $forGroom;
    }

    function __toString()
    {
        return 'card_' . $this->id;
    }
}