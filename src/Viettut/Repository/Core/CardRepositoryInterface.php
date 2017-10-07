<?php
/**
 * Created by PhpStorm.
 * User: giang
 * Date: 26/02/2016
 * Time: 21:01
 */

namespace Viettut\Repository\Core;
use Doctrine\Common\Persistence\ObjectRepository;

interface CardRepositoryInterface extends ObjectRepository
{
    /**
     * @param string $hash
     * @return mixed
     */
    public function getCardByHash($hash);
}