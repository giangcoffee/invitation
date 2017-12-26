<?php


namespace Viettut\Model\Core;


use DateTime;
use Viettut\Model\ModelInterface;
use Viettut\Model\User\UserEntityInterface;

interface CardInterface extends ModelInterface
{
    const STATUS_GOING = 1;
    const STATUS_NOT_GOING = 3;
    const STATUS_NOT_SURE = 2;

    /**
     * @param $id
     * @return $this
     */
    public function setId($id);

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
    public function getHash();

    /**
     * @param string $hash
     * @return self
     */
    public function setHash($hash);

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
     * @return TemplateInterface
     */
    public function getTemplate();

    /**
     * @param TemplateInterface $template
     * @return self
     */
    public function setTemplate($template);

    /**
     * @return UserEntityInterface
     */
    public function getAuthor();

    /**
     * @param UserEntityInterface $author
     * @return self
     */
    public function setAuthor($author);

    /**
     * @return array
     */
    public function getComments();

    /**
     * @param array $comments
     * @return self
     */
    public function setComments($comments);

    public function addComment($comment);

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

    /**
     * @return string
     */
    public function getVideo(): string;

    /**
     * @param string $video
     * @return self
     */
    public function setVideo($video);

    /**
     * @return boolean
     */
    public function isValidVideo(): bool;

    /**
     * @param boolean $validVideo
     * @return self
     */
    public function setValidVideo($validVideo);

    /**
     * @return string
     */
    public function getVideoId(): string;

    /**
     * @param string $videoId
     * @return self
     */
    public function setVideoId($videoId);

    /**
     * @return LibraryCardInterface|null
     */
    public function getLibraryCard();

    /**
     * @param LibraryCardInterface $libraryCard
     * @return self
     */
    public function setLibraryCard($libraryCard);

    /**
     * @return mixed
     */
    public function getEmbedded();

    /**
     * @param mixed $embedded
     * @return self
     */
    public function setEmbedded($embedded);

    /**
     * @return int
     */
    public function getViews(): int;

    /**
     * @param int $views
     * @return self
     */
    public function setViews($views);

    /**
     * @return DateTime
     */
    public function getPartyDate();

    /**
     * @param DateTime $partyDate
     * @return self
     */
    public function setPartyDate($partyDate);

    /**
     * @return string
     */
    public function getName();

    /**
     * @param string $name
     * @return self
     */
    public function setName($name);

    public function getWeddingDateString();
}