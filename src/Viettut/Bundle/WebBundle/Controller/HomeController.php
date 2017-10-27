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
        return $this->render('ViettutWebBundle:Home:index.html.twig');
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
}