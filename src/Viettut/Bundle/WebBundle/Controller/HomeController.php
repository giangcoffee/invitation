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
use Viettut\Exception\RuntimeException;
use Viettut\Model\Core\PostInterface;
use Viettut\Model\Core\TemplateInterface;
use Viettut\Model\User\UserEntityInterface;

class HomeController extends Controller
{
    /**
     * @Route("/", name="home_page")
     * @param $request
     * @return Response
     */
    public function indexAction(Request $request)
    {
        $pageSize = $this->getParameter('page_size');
        $testimonials = $this->get('viettut.domain_manager.testimonial')->all();
        $posts = $this->get('viettut.domain_manager.post')->getLatestPost($pageSize);
        $templates = $this->get('viettut.domain_manager.template')->all(3,0);
        return $this->render('ViettutWebBundle:Home:index.html.twig', array(
            'testimonials' => $testimonials,
            'posts' => $posts,
            'templates' => $templates
        ));
    }

    /**
     * @Route("/dich-vu", name="services_page")
     * @param $request
     * @return Response
     */
    public function serviceAction(Request $request)
    {
        return $this->render('ViettutWebBundle:Home:services.html.twig');
    }

    /**
     * @Route("/gioi-thieu", name="about_page")
     * @param $request
     * @return Response
     */
    public function aboutAction(Request $request)
    {
        return $this->render('ViettutWebBundle:Home:about.html.twig');
    }

    /**
     * @Route("/lien-he", name="contact_page")
     * @Method({"GET"})
     * @param $request
     * @return Response
     */
    public function contactAction(Request $request)
    {
        return $this->render('ViettutWebBundle:Home:contact.html.twig');
    }

    /**
     * @Route("/thiep-cua-toi", name="my_card_page")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function myCardsAction(Request $request)
    {
        $user = $this->getUser();
        if (!$user instanceof UserEntityInterface) {
            $this->container->get('session')->set('_security.main.target_path', $this->generateUrl('my_card_page'));
            return $this->redirect($this->generateUrl('fos_user_security_login'));
        }

        $cards = $this->get('viettut.repository.card')->getCardByUser($user);
        $templates = $this->get('viettut.repository.template')->findAll();
        return $this->render('ViettutWebBundle:Home:my_cards.html.twig', array('cards' => $cards, 'templates' => $templates));
    }

    /**
     * @Route("/lien-he")
     * @Method({"POST"})
     * @param $request
     * @return Response
     */
    public function receiveMessageAction(Request $request)
    {
        $mailer = $this->get('mailer');
        $body = $request->request->get('message', 'message');
        $subject = $request->request->get('subject', 'subject');
        $from = $request->request->get('email', 'email');
        $message = (new \Swift_Message($subject))
            ->setFrom($this->getParameter('mailer_sender'))
            ->setTo('giang.fet.hut@gmail.com')
            ->setBody($body, 'text/plain')
        ;
        try {
            $mailer->send($message);
        } catch (\Exception $ex) {
            throw new RuntimeException('Can not send email');
        }

        return new Response("", Response::HTTP_NO_CONTENT);
    }

    /**
     * @Route("/mau-thiep", name="templates_page")
     * @param $request
     * @return Response
     */
    public function templateAction(Request $request)
    {
        $templates = $this->get('viettut.repository.template')->findAll();
        return $this->render('ViettutWebBundle:Home:templates.html.twig', array('templates' => $templates));
    }

    /**
     * @Route("/san-pham", name="cards_page")
     * @param $request
     * @return Response
     */
    public function cardsAction(Request $request)
    {
        $pageSize = $this->getParameter('page_size');

        $pagination = $this->get('knp_paginator')->paginate(
            $this->get('viettut.repository.card')->getAllCardQuery(),
            $request->query->getInt('page', 1)/*page number*/,
            $pageSize
        );

        return $this->render('ViettutWebBundle:Home:cards.html.twig', array(
            "pagination" => $pagination
        ));
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
     * @Route("/cau-hoi-thuong-gap", name="faq_page")
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
     * @Route("/blogs", name="posts_page")
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
     * @Route("/blogs/{hash}", name="single_post_page")
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

    /**
     * @Route("/chua-hoan-thanh", name="coming_soon_page")
     *
     * @param Request $request
     * @return Response
     */
    public function comingSoonAction(Request $request)
    {
        return $this->render('ViettutWebBundle:Home:coming_soon.html.twig');
    }
}