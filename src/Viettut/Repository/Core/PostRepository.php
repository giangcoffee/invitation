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
}