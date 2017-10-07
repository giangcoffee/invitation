<?php


namespace Viettut\Model\Core;


use Viettut\Model\ModelInterface;
use Viettut\Model\User\UserEntityInterface;

interface CardInterface extends ModelInterface
{
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
}