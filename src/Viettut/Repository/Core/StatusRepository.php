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

class StatusRepository extends EntityRepository implements StatusRepositoryInterface
{
    public function getByCard(CardInterface $card, $limit = null, $offset = null)
    {
        $qb = $this->createQueryBuilder('st')
            ->where('st.card = :card')
            ->setParameter('card', $card->getId(), TYPE::INTEGER)
            ->addOrderBy('st.createdAt', 'desc')
        ;

        if (is_int($limit)) {
            $qb->setMaxResults($limit);
        }

        if (is_int($offset)) {
            $qb->setFirstResult($offset);
        }

        return $qb->getQuery()->getResult();
    }

    public function getGoingForCard(CardInterface $card)
    {
        return $this->createQueryBuilder('st')
            ->where('st.card = :card')
            ->andWhere('st.status = 1')
            ->setParameter('card', $card->getId(), TYPE::INTEGER)
            ->select('count(id)')
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function getStatusForCard(CardInterface $card, $status)
    {
        return $this->createQueryBuilder('st')
            ->where('st.card = :card')
            ->andWhere('st.status = :status')
            ->setParameter('card', $card->getId(), TYPE::INTEGER)
            ->setParameter('status', $status, TYPE::INTEGER)
            ->select('count(id)')
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function checkUniqueUserForCard(CardInterface $card, $uniqueUser)
    {
        return $this->createQueryBuilder('st')
            ->where('st.card = :card')
            ->andWhere('st.uniqueUser = :uniqueUser')
            ->setParameter('card', $card->getId(), TYPE::INTEGER)
            ->setParameter('uniqueUser', $uniqueUser, TYPE::INTEGER)
            ->getQuery()
            ->getFirstResult();
    }
}