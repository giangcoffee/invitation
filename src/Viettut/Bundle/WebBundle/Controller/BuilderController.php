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

    /**
     * @Route("/templates/{hash}/preview", name="preview_page")
     * @param $request
     * @param $hash
     * @return Response
     */
    public function previewTemplateAction(Request $request, $hash)
    {
        $template = $this->get('viettut.domain_manager.template')->getTemplateByHash($hash);
        
        if (!$template instanceof TemplateInterface) {
            throw new NotFoundHttpException('The resource is not found or you don\'t have permission');
        }
        
        return $this->render($template->getPath(), array('template' => $template));
    }
}