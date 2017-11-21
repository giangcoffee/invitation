<?php
/**
 * Created by PhpStorm.
 * User: giang
 * Date: 10/21/15
 * Time: 9:24 PM
 */

namespace Viettut\Model\Core;


use Viettut\Model\User\UserEntityInterface;

class Status implements StatusInterface
{
    /**
     * @var integer
     */
    protected $id;

    /**
     * @var string
     */
    protected $uniqueUser;

    /** @var  int */
    protected $status;

    /**
     * @var CardInterface
     */
    protected $card;

    /**
     * @var \DateTime
     */
    protected $createdAt;


    function __construct()
    {
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
     * @return CardInterface
     */
    public function getCard()
    {
        return $this->card;
    }

    /**
     * @param CardInterface $card
     * @return self
     */
    public function setCard($card)
    {
        $this->card = $card;
        return $this;
    }

    /**
     * @return string
     */
    public function getUniqueUser(): string
    {
        return $this->uniqueUser;
    }

    /**
     * @param string $uniqueUser
     * @return self
     */
    public function setUniqueUser($uniqueUser)
    {
        $this->uniqueUser = $uniqueUser;
        return $this;
    }

    /**
     * @return int
     */
    public function getStatus(): int
    {
        return $this->status;
    }

    /**
     * @param int $status
     * @return self
     */
    public function setStatus($status)
    {
        $this->status = $status;
        return $this;
    }

    function __toString()
    {
        return 'comment_' . $this->id;
    }
}