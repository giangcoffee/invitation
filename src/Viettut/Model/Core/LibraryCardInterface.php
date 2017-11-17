<?php


namespace Viettut\Model\Core;


use Viettut\Model\ModelInterface;

interface LibraryCardInterface extends ModelInterface
{
    /**
     * @param $id
     * @return $this
     */
    public function setId($id);

    /**
     * @return \DateTime
     */
    public function getCreatedAt();

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
     * @param $path
     * @return $this
     */
    public function addImage($path);

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
     * @return mixed
     */
    public function getEmbedded();

    /**
     * @param mixed $embedded
     * @return self
     */
    public function setEmbedded($embedded);
}