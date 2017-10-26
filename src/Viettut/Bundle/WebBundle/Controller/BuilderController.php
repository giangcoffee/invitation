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
        return $this->render('ViettutWebBundle:Builder:preview.htm.twig', array(
            'data' => $card->getData(),
            'columns' => $template->getColumns(),
            'gallery' => $card->getGallery(),
            'date' => $card->getWeddingDate(),
            'id' => $card->getId(),
            'name' => $template->getName(),
            'hash' => $card->getHash()
        ));
    }

    /**
     * @Route("/template/{hash}", name="template_page")
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

        $gallery = $template->getGallery();
        $first = array_slice($gallery, 0, 5);
        $second = array_slice($gallery, 5, 4);
        $rest = array_slice($gallery, 9);
        return $this->render($template->getPath(), array(
            'columns' => $template->getColumns(),
            'data' => $template->getData(),
            'name' => $template->getName(),
            'first' => $first,
            'second' => $second,
            'rest' => $rest,
            'date' => $template->getWeddingDate(),
            'comments' => [],
            'isCard' => false,
            'isTemplate' => true,
            'id' => $template->getId()
        ));
    }

    /**
     * @Route("/cards/{hash}", name="card_page")
     * @param $request
     * @param $hash
     * @return Response
     */
    public function cardAction(Request $request, $hash)
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
        return $this->render($template->getPath(), array (
            'data' => $card->getData(),
            'columns' => $template->getColumns(),
            'gallery' => $card->getGallery(),
            'date' => $card->getWeddingDate(),
            'comments' => $card->getComments(),
            'id' => $card->getId(),
            'isCard' => true,
            'isTemplate' => false
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

        return $this->render('ViettutWebBundle:Builder:iframe.htm.twig', array(
            'columns' => $template->getColumns(),
            'iframe_src' => sprintf('/app_dev.php/template/%s', $hash)
        ));
    }
}