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
use Viettut\Entity\Core\Faq;

class FaqRepository extends EntityRepository implements FaqRepositoryInterface
{
    public function search($keyword)
    {
        $rsm = new ResultSetMapping();
        $rsm->addScalarResult('id', 'id')
            ->addScalarResult('question', 'question')
            ->addScalarResult('answer', 'answer')
            ->addScalarResult('created_at', 'createdAt')
        ;

        $sql = "SELECT * FROM viettut_faq
                WHERE MATCH (question) AGAINST (:keyword IN NATURAL LANGUAGE MODE);
                ";

        $query = $this->_em->createNativeQuery($sql, $rsm)->setParameter('keyword', $keyword, Type::STRING);
        $results = $query->execute();
        $faqs = [];

        foreach($results as $result) {
            $faq = new Faq();
            $faq->setId($result['id']);
            $faq->setQuestion($result['question']);
            $faq->setAnswer($result['answer']);

            $faqs[] = $faq;
        }

        return $faqs;
    }
}