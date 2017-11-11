<?php
/**
 * Created by PhpStorm.
 * User: giang
 * Date: 10/21/15
 * Time: 9:01 PM
 */

namespace Viettut\Repository\Core;
use Doctrine\Common\Persistence\ObjectRepository;
use Viettut\Model\Core\CardInterface;

interface CommentRepositoryInterface extends ObjectRepository
{
    /**
     * @param CardInterface $card
     * @param null $limit
     * @param null $offset
     * @return mixed
     */
    public function getByCard(CardInterface $card, $limit = null, $offset = null);
}