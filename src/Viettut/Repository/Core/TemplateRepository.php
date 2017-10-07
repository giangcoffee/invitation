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

class TemplateRepository extends EntityRepository implements TemplateRepositoryInterface
{
    /**
     * @param string $hash
     * @return mixed
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getTemplateByHash($hash)
    {
        return $this->createQueryBuilder('t')
            ->where('t.hash =:hash')
            ->setParameter('hash', $hash)
            ->getQuery()
            ->getOneOrNullResult();
    }
}