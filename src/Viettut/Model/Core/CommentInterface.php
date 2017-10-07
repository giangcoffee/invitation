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

interface CommentInterface extends ModelInterface
{
    /**
     * @param $id
     * @return $this
     */
    public function setId($id);

    /**
     * Set content
     *
     * @param string $content
     * @return self
     */
    public function setContent($content);

    /**
     * Get content
     *
     * @return string
     */
    public function getContent();

    /**
     * Get deletedAt
     *
     * @return \DateTime
     */
    public function getDeletedAt();

    /**
     * @return UserEntityInterface
     */
    public function getAuthor();

    /**
     * @param UserEntityInterface $author
     * @return self
     */
    public function setAuthor(UserEntityInterface $author);

    /**
     * @return \DateTime
     */
    public function getCreatedAt();

    /**
     * @return CardInterface
     */
    public function getCard();

    /**
     * @param CardInterface $card
     * @return self
     */
    public function setCard($card);
}