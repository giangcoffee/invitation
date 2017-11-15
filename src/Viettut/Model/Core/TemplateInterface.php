<?php


namespace Viettut\Model\Core;


use DateTime;
use Viettut\Model\ModelInterface;

interface TemplateInterface extends ModelInterface
{
    /**
     * @param int $id
     * @return self
     */
    public function setId($id);

    /**
     * @return string
     */
    public function getName();

    /**
     * @param string $name
     * @return self
     */
    public function setName($name);

    /**
     * @return string
     */
    public function getHash();

    /**
     * @param string $hash
     * @return self
     */
    public function setHash($hash);

    /**
     * @return string
     */
    public function getPath();

    /**
     * @param string $path
     * @return self
     */
    public function setPath($path);

    /**
     * @return array
     */
    public function getData();

    /**
     * @param array $data
     * @return self
     */
    public function setData($data);

    /**
     * Get deletedAt
     *
     * @return \DateTime
     */
    public function getDeletedAt();

    /**
     * @return \DateTime
     */
    public function getCreatedAt();

    /**
     * @return string
     */
    public function getThumbnail();

    /**
     * @param string $thumbnail
     * @return self
     */
    public function setThumbnail($thumbnail);

    /**
     * @return array
     */
    public function getGallery();

    /**
     * @param array $gallery
     * @return self
     */
    public function setGallery($gallery);

    /**
     * @return array
     */
    public function getColumns();

    /**
     * @param array $columns
     * @return self
     */
    public function setColumns($columns);

    /**
     * @param $path
     * @return $this
     */
    public function addImage($path);

    /**
     * @return DateTime
     */
    public function getWeddingDate();

    /**
     * @param DateTime $weddingDate
     * @return self
     */
    public function setWeddingDate($weddingDate);

    /**
     * @return mixed
     */
    public function getLongitude();

    /**
     * @param mixed $longitude
     * @return self
     */
    public function setLongitude($longitude);

    /**
     * @return mixed
     */
    public function getLatitude();

    /**
     * @param mixed $latitude
     * @return self
     */
    public function setLatitude($latitude);

    /**
     * @return mixed
     */
    public function getHomeLongitude();

    /**
     * @param mixed $homeLongitude
     * @return self
     */
    public function setHomeLongitude($homeLongitude);

    /**
     * @return mixed
     */
    public function getHomeLatitude();

    /**
     * @param mixed $homeLatitude
     * @return self
     */
    public function setHomeLatitude($homeLatitude);

    /**
     * @return boolean
     */
    public function isForGroom();

    /**
     * @param boolean $forGroom
     */
    public function setForGroom($forGroom);
}