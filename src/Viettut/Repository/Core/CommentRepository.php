<?php
/**
 * Created by PhpStorm.
 * User: giang
 * Date: 10/21/15
 * Time: 9:01 PM
 */

namespace Viettut\Repository\Core;
use Doctrine\DBAL\Types\Type;
use Doctrine\ORM\EntityRepository;
use Viettut\Model\Core\CardInterface;

class CommentRepository extends EntityRepository implements CommentRepositoryInterface
{
    public function getByCard(CardInterface $card, $limit = null, $offset = null)
    {
        $qb = $this->createQueryBuilder('cm')
            ->where('cm.card = :card')
            ->setParameter('card', $card->getId(), TYPE::INTEGER)
            ->addOrderBy('cm.createdAt', 'desc')
        ;

        if (is_int($limit)) {
            $qb->setMaxResults($limit);
        }

        if (is_int($offset)) {
            $qb->setFirstResult($offset);
        }

        return $qb->getQuery()->getResult();
    }
}