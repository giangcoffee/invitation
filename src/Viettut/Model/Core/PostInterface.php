<?php
/**
 * Created by PhpStorm.
 * User: giang
 * Date: 10/21/15
 * Time: 9:07 PM
 */

namespace Viettut\Model\Core;


use Viettut\Model\ModelInterface;
use Viettut\Model\User\UserEntityInterface;

interface PostInterface extends ModelInterface
{
    /**
     * @param int $id
     * @return self
     */
    public function setId($id);

    /**
     * @return \DateTime
     */
    public function getCreatedAt();

    /**
     * @return string
     */
    public function getTitle(): string;

    /**
     * @param string $title
     * @return self
     */
    public function setTitle($title);

    /**
     * @return UserEntityInterface
     */
    public function getAuthor(): UserEntityInterface;

    /**
     * @param UserEntityInterface $author
     * @return self
     */
    public function setAuthor($author);

    /**
     * @return string
     */
    public function getHash(): string;

    /**
     * @param string $hash
     * @return self
     */
    public function setHash($hash);

    /**
     * @return string
     */
    public function getContent(): string;

    /**
     * @param string $content
     * @return self
     */
    public function setContent($content);

    /**
     * @return int
     */
    public function getView(): int;

    /**
     * @param int $view
     * @return self
     */
    public function setView($view);

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
    public function isHasVideo(): bool;

    /**
     * @param boolean $hasVideo
     * @return self
     */
    public function setHasVideo($hasVideo);

    /**
     * @return boolean
     */
    public function isPublished(): bool;

    /**
     * @param boolean $published
     * @return self
     */
    public function setPublished($published);

    /**
     * @return \DateTime
     */
    public function getDeletedAt(): \DateTime;

    /**
     * @return \DateTime
     */
    public function getUpdatedAt(): \DateTime;
}