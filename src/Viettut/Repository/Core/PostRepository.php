<?php
/**
 * Created by PhpStorm.
 * User: giang
 * Date: 26/02/2016
 * Time: 21:02
 */

namespace Viettut\Repository\Core;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\ResultSetMapping;
use Viettut\Bundle\UserBundle\Entity\User;
use Viettut\Entity\Core\Post;
use Doctrine\DBAL\Types\Type;

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

    public function search($keyword)
    {
        $rsm = new ResultSetMapping();
        $rsm->addScalarResult('id', 'id')
            ->addScalarResult('title', 'title')
            ->addScalarResult('hash', 'hash')
            ->addScalarResult('content', 'content')
            ->addScalarResult('summary', 'summary')
            ->addScalarResult('view', 'view')
            ->addScalarResult('published', 'published')
            ->addScalarResult('video', 'video')
            ->addScalarResult('has_video', 'hasVideo')
            ->addScalarResult('created_at', 'createdAt')
            ->addScalarResult('deleted_at', 'deletedAt')
            ->addScalarResult('author_id', 'author')
        ;

        $sql = "SELECT * FROM viettut_post
                WHERE MATCH (title) AGAINST (:keyword IN NATURAL LANGUAGE MODE);
                ";

        $query = $this->_em->createNativeQuery($sql, $rsm)->setParameter('keyword', $keyword, Type::STRING);
        $results = $query->execute();
        $posts = [];
        $lecturerManager = $this->_em->getRepository(User::class);
        foreach($results as $result) {
            $post = new Post();
            $post->setId($result['id']);
            $post->setTitle($result['title']);
            $post->setHash($result['hash']);
            $post->setContent($result['content']);
            $post->setSummary($result['summary']);
            $post->setView($result['view']);
            $post->setVideo($result['video']);
            $post->setPublished(filter_var($result['published'], FILTER_VALIDATE_BOOLEAN));
            $post->setHasVideo(filter_var($result['hasVideo'], FILTER_VALIDATE_BOOLEAN));

            $author = $lecturerManager->find($result['author']);
            $post->setAuthor($author);
            $posts[] = $post;
        }

        return $posts;
    }
}