<?php
/**
 * Created by PhpStorm.
 * User: giang
 * Date: 26/02/2016
 * Time: 21:01
 */

namespace Viettut\Repository\Core;
use Doctrine\Common\Persistence\ObjectRepository;
use Viettut\Model\User\UserEntityInterface;

interface CardRepositoryInterface extends ObjectRepository
{
    /**
     * @param string $hash
     * @return mixed
     */
    public function getCardByHash($hash);

    /**
     * @param UserEntityInterface $user
     * @return mixed
     */
    public function getCardByUser(UserEntityInterface $user);
}