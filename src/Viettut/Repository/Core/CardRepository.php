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
use Doctrine\ORM\Query\ResultSetMapping;
use Viettut\Bundle\UserBundle\Entity\User;
use Viettut\Entity\Core\Card;
use Viettut\Entity\Core\LibraryCard;
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

    public function search($keyword)
    {
        $rsm = new ResultSetMapping();
        $rsm->addScalarResult('id', 'id')
            ->addScalarResult('name', 'name')
            ->addScalarResult('template_id', 'template')
            ->addScalarResult('hash', 'hash')
            ->addScalarResult('data', 'data')
            ->addScalarResult('wedding_date', 'weddingDate')
            ->addScalarResult('party_date', 'partyDate')
            ->addScalarResult('views', 'views')
            ->addScalarResult('longitude', 'longitude')
            ->addScalarResult('home_longitude', 'homeLongitude')
            ->addScalarResult('latitude', 'latitude')
            ->addScalarResult('home_latitude', 'homeLatitude')
            ->addScalarResult('for_groom', 'forGroom')
            ->addScalarResult('library_card_id', 'libraryCard')
            ->addScalarResult('created_at', 'createdAt')
            ->addScalarResult('deleted_at', 'deletedAt')
            ->addScalarResult('author_id', 'author')
        ;

        $sql = "SELECT * FROM viettut_card
                WHERE MATCH (name) AGAINST (:keyword IN NATURAL LANGUAGE MODE);
                ";

        $query = $this->_em->createNativeQuery($sql, $rsm)->setParameter('keyword', $keyword, Type::STRING);
        $results = $query->execute();
        $cards = [];

        $lecturerManager = $this->_em->getRepository(User::class);
        $templateRepository = $this->_em->getRepository(LibraryCard::class);
        foreach($results as $result) {
            $card = new Card();
            $card->setId($result['id']);
            $card->setName($result['name']);
            $card->setHash($result['hash']);
            $card->setData($result['data']);
            $card->setWeddingDate(new \DateTime($result['weddingDate']));
            $card->setPartyDate(new \DateTime($result['partyDate']));
            $card->setForGroom(filter_var($result['forGroom'], FILTER_VALIDATE_BOOLEAN));
            $card->setLongitude($result['longitude']);
            $card->setLatitude($result['latitude']);
            $card->setHomeLongitude($result['homeLongitude']);
            $card->setHomeLatitude($result['homeLatitude']);
            $card->setViews(filter_var($result['views'], FILTER_VALIDATE_INT));

            $author = $lecturerManager->find($result['author']);
            $template = $templateRepository->find($result['libraryCard']);
            $card->setAuthor($author)->setTemplate($template);

            $cards[] = $card;
        }

        return $cards;
    }

    public function getAllCardQuery()
    {
        return $this->createQueryBuilder('c')->getQuery();
    }

    public function getAllPublicCardQuery()
    {
        return $this->createQueryBuilder('c')->where('c.public = 1')->getQuery();
    }
}