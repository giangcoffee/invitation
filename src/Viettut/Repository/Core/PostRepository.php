<?php
/**
 * Created by PhpStorm.
 * User: giang
 * Date: 26/02/2016
 * Time: 21:02
 */

namespace Viettut\Repository\Core;
use Doctrine\ORM\EntityRepository;

class PostRepository extends EntityRepository implements PostRepositoryInterface
{
    public function getAllPostQuery()
    {
        return $this->createQueryBuilder('p')->getQuery();
    }

    public function getByHash($hash)
    {
        return $this->createQueryBuilder('p')
            ->where('p.hash = :hash')
            ->setParameter('hash', $hash)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function getLatestPost($pageSize)
    {
        return $this->createQueryBuilder('p')
            ->addOrderBy('p.id', 'desc')
            ->setMaxResults($pageSize)
            ->getQuery()
            ->getResult();
    }
}