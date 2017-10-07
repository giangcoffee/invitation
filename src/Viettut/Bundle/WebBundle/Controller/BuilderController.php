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

class BuilderController extends Controller
{
    /**
     * @Route("/builder/{hash}", name="builder_page")
     * @param $request
     * @return Response
     */
    public function builderAction(Request $request, $hash)
    {
        return $this->render('ViettutWebBundle:template1:index.html.twig');
    }
}