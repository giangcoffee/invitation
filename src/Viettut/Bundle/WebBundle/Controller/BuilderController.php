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
use Viettut\DomainManager\CardManagerInterface;
use Viettut\Model\Core\CardInterface;
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
        /**
         * @var CardManagerInterface $cardManager
         */
        $cardManager = $this->get('viettut.domain_manager.card');
        $card = $cardManager->getCardByHash($hash);

        if (!$card instanceof CardInterface) {
            throw new NotFoundHttpException('The resource is not found or you don\'t have permission');
        }

        $template = $card->getTemplate();
        return $this->render($template->getPath(), array(
            'data' => $card->getData(),
            'isTemplate' => false,
            'gallery' => $card->getGallery(),
            'date' => $card->getWeddingDate(),
            'id' => $card->getId()
        ));
    }

    /**
     * @Route("/templates/{hash}", name="template_page")
     * @param $request
     * @param $hash
     * @return Response
     */
    public function templateAction(Request $request, $hash)
    {
        $template = $this->get('viettut.domain_manager.template')->getTemplateByHash($hash);
        
        if (!$template instanceof TemplateInterface) {
            throw new NotFoundHttpException('The resource is not found or you don\'t have permission');
        }
        
        return $this->render($template->getPath(), array(
            'data' => $template->getData(),
            'isTemplate' => true,
            'gallery' => $template->getGallery(),
            'date' => $template->getWeddingDate(),
            'id' => $template->getId()
        ));
    }

    /**
     * @Route("/templates/{hash}/preview", name="preview_template_page")
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

        return $this->render('ViettutWebBundle:Builder:preview.htm.twig', array(
            'iframe_src' => sprintf('/app_dev.php/templates/%s', $hash)
        ));
    }
}