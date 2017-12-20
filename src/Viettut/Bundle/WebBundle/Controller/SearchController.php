<?php
/**
 * Created by PhpStorm.
 * User: giang
 * Date: 24/02/2016
 * Time: 22:02
 */

namespace Viettut\Bundle\WebBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use FOS\RestBundle\Controller\Annotations as Rest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class SearchController extends Controller
{
    /**
     * @Route("/public/search", name="public_search")
     * @param $request
     * @Template()
     */
    public function searchAction(Request $request)
    {
        $keyword = $request->query->get('q');
        $cards = $this->get('viettut.repository.card')->search($keyword);
        $templates = $this->get('viettut.repository.template')->search($keyword);
        $posts = $this->get('viettut.repository.post')->search($keyword);
        $faqs = $this->get('viettut.repository.faq')->search($keyword);

        return $this->render('ViettutWebBundle:Search:search.html.twig', array(
            'cards' => $cards,
            'templates' => $templates,
            'posts' => $posts,
            'faqs' => $faqs,
            'keyword' => $keyword,
            'totalMatch' => count($cards) + count($templates) + count($posts) + count($faqs)
        ));
    }
}