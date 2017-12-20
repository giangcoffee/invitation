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
use Viettut\Entity\Core\Template;

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

    public function search($keyword)
    {
        $rsm = new ResultSetMapping();
        $rsm->addScalarResult('id', 'id')
            ->addScalarResult('name', 'name')
            ->addScalarResult('hash', 'hash')
            ->addScalarResult('data', 'data')
            ->addScalarResult('path', 'path')
            ->addScalarResult('wedding_date', 'weddingDate')
            ->addScalarResult('longitude', 'longitude')
            ->addScalarResult('home_longitude', 'homeLongitude')
            ->addScalarResult('latitude', 'latitude')
            ->addScalarResult('home_latitude', 'homeLatitude')
            ->addScalarResult('for_groom', 'forGroom')
            ->addScalarResult('columns', 'columns')
            ->addScalarResult('gallery', 'gallery')
            ->addScalarResult('thumbnail', 'thumbnail')
            ->addScalarResult('created_at', 'createdAt')
            ->addScalarResult('deleted_at', 'deletedAt')
        ;

        $sql = "SELECT * FROM viettut_template
                WHERE MATCH (name) AGAINST (:keyword IN NATURAL LANGUAGE MODE);
                ";

        $query = $this->_em->createNativeQuery($sql, $rsm)->setParameter('keyword', $keyword, Type::STRING);
        $results = $query->execute();
        $templates = [];

        foreach($results as $result) {
            $template = new Template();
            $template->setId($result['id']);
            $template->setName($result['name']);
            $template->setHash($result['hash']);
            $template->setData($result['data']);
            $template->setWeddingDate(new \DateTime($result['weddingDate']));
            $template->setPath($result['path']);
            $template->setColumns($result['columns']);
            $template->setThumbnail($result['thumbnail']);
            $template->setGallery($result['gallery']);
            $template->setForGroom(filter_var($result['forGroom'], FILTER_VALIDATE_BOOLEAN));
            $template->setLongitude($result['longitude']);
            $template->setLatitude($result['latitude']);
            $template->setHomeLongitude($result['homeLongitude']);
            $template->setHomeLatitude($result['homeLatitude']);

            $templates[] = $template;
        }

        return $templates;
    }
}