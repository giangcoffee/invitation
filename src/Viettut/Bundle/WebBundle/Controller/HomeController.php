<?php
/**
 * Created by PhpStorm.
 * User: giang
 * Date: 10/31/15
 * Time: 10:42 PM
 */

namespace Viettut\Bundle\WebBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Viettut\Model\Core\PostInterface;
use Viettut\Model\Core\TemplateInterface;

class HomeController extends Controller
{
    /**
     * @Route("/", name="home_page")
     * @param $request
     * @return Response
     */
    public function indexAction(Request $request)
    {
        $testimonials = $this->get('viettut.domain_manager.testimonial')->all();
        return $this->render('ViettutWebBundle:Home:index.html.twig', array(
            'testimonials' => $testimonials
        ));
    }

    /**
     * @Route("/services", name="services_page")
     * @param $request
     * @return Response
     */
    public function serviceAction(Request $request)
    {
        return $this->render('ViettutWebBundle:Home:services.html.twig');
    }

    /**
     * @Route("/about", name="about_page")
     * @param $request
     * @return Response
     */
    public function aboutAction(Request $request)
    {
        return $this->render('ViettutWebBundle:Home:about.html.twig');
    }

    /**
     * @Route("/contact", name="contact_page")
     * @param $request
     * @return Response
     */
    public function contactAction(Request $request)
    {
        return $this->render('ViettutWebBundle:Home:contact.html.twig');
    }

    /**
     * @Route("/templates", name="templates_page")
     * @param $request
     * @return Response
     */
    public function templateAction(Request $request)
    {
        $templates = $this->get('viettut.repository.template')->findAll();
        return $this->render('ViettutWebBundle:Home:templates.html.twig', array('templates' => $templates));
    }

    /**
     * @Route("/price", name="price_page")
     * @param $request
     * @return Response
     */
    public function priceAction(Request $request)
    {
        return $this->render('ViettutWebBundle:Home:price.html.twig');
    }

    /**
     * @Route("/faq", name="faq_page")
     * @param $request
     * @return Response
     */
    public function faqAction(Request $request)
    {
        $faqs = $this->get('viettut.domain_manager.faq')->all();
        return $this->render('ViettutWebBundle:Home:faq.html.twig', array(
            'faqs' => $faqs
        ));
    }

    /**
     * @Route("/posts", name="posts_page")
     * @param $request
     * @return Response
     */
    public function postAction(Request $request)
    {
        $pageSize = $this->getParameter('page_size');

        $pagination = $this->get('knp_paginator')->paginate(
            $this->get('viettut.repository.post')->getAllPostQuery(),
            $request->query->getInt('page', 1)/*page number*/,
            $pageSize
        );

        return $this->render('ViettutWebBundle:Home:posts.html.twig', array(
            "pagination" => $pagination
        ));
    }

    /**
     * @Route("/posts/{hash}", name="posts_page")
     *
     * @param Request $request
     * @param $hash
     * @return Response
     */
    public function singlePostAction(Request $request, $hash)
    {
        $post = $this->get('viettut.domain_manager.post')->getByHash($hash);
        if (!$post instanceof PostInterface) {
            throw new NotFoundHttpException('The resource not found or you do not have permission');
        }

        return $this->render('ViettutWebBundle:Home:single_post.html.twig', array(
            "post" => $post
        ));
    }
}