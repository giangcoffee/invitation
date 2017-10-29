<?php


namespace Viettut\Model\Core;


use DateTime;

class Template implements TemplateInterface
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $hash;

    /**
     * @var string
     */
    protected $path;

    /**
     * @var array
     */
    protected $data;

    /**
     * @var string
     */
    protected $thumbnail;

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
    protected $columns;

    /**
     * @var \DateTime
     */
    protected $createdAt;

    /**
     * @var bool
     */
    protected $forGroom;

    /**
     * @var \DateTime
     */
    protected $deletedAt;

    protected $longitude;

    protected $latitude;

    /**
     * Template constructor.
     */
    public function __construct()
    {
        $this->forGroom = true;
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
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return self
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
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
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @param string $path
     * @return self
     */
    public function setPath($path)
    {
        $this->path = $path;
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
     * @return string
     */
    public function getThumbnail()
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
     * @return array
     */
    public function getColumns()
    {
        return $this->columns;
    }

    /**
     * @param array $columns
     * @return self
     */
    public function setColumns($columns)
    {
        $this->columns = $columns;
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
}