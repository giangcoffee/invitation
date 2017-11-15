<?php
/**
 * Created by PhpStorm.
 * User: giang
 * Date: 26/02/2016
 * Time: 21:02
 */

namespace Viettut\Repository\Core;
use Doctrine\DBAL\Types\Type;
use Doctrine\ORM\EntityRepository;
use Viettut\Model\User\UserEntityInterface;

class CardRepository extends EntityRepository implements CardRepositoryInterface
{
    /**
     * @param string $hash
     * @return mixed
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getCardByHash($hash)
    {
        return $this->createQueryBuilder('c')
            ->where('c.hash =:hash')
            ->setParameter('hash', $hash)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function getCardByUser(UserEntityInterface $user)
    {
        return $this->createQueryBuilder('c')
            ->where('c.author = :user')
            ->setParameter('user', $user)
            ->getQuery()
            ->getResult();
    }
}