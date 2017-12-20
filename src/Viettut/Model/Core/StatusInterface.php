<?php
/**
 * Created by PhpStorm.
 * User: giang
 * Date: 10/21/15
 * Time: 9:07 PM
 */

namespace Viettut\Model\Core;


use Viettut\Model\ModelInterface;

interface StatusInterface extends ModelInterface
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
     * @return CardInterface
     */
    public function getCard();

    /**
     * @param CardInterface $card
     * @return self
     */
    public function setCard($card);

    /**
     * @return string
     */
    public function getUniqueUser(): string;

    /**
     * @param string $uniqueUser
     * @return self
     */
    public function setUniqueUser($uniqueUser);

    /**
     * @return int
     */
    public function getStatus(): int;

    /**
     * @param int $status
     * @return self
     */
    public function setStatus($status);
}