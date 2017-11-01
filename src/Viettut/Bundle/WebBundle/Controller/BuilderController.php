<?php
/**
 * Created by PhpStorm.
 * User: giang
 * Date: 10/31/15
 * Time: 10:42 PM
 */

namespace Viettut\Bundle\WebBundle\Controller;

use RestClient\CurlRestClient;
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
     * @Route("/cards/{hash}/edit", name="edit_card_page")
     * @param $request
     * @return Response
     */
    public function builderAction(Request $request, $hash)
    {
        /** @var CardManagerInterface $cardManager */
        $cardManager = $this->get('viettut.domain_manager.card');
        $card = $cardManager->getCardByHash($hash);

        if (!$card instanceof CardInterface) {
            throw new NotFoundHttpException('The resource is not found or you don\'t have permission');
        }

        $template = $card->getTemplate();
        return $this->render('ViettutWebBundle:Builder:edit.htm.twig', array(
            'data' => $card->getData(),
            'columns' => $template->getColumns(),
            'gallery' => $card->getGallery(),
            'date' => $card->getWeddingDate(),
            'id' => $card->getId(),
            'name' => $template->getName(),
            'hash' => $card->getHash(),
            'forGroom' => $card->isForGroom()
        ));
    }

    public function guestBookAction(Request $request, $hash)
    {
        /** @var CardManagerInterface $cardManager */
        $cardManager = $this->get('viettut.domain_manager.card');
        $card = $cardManager->getCardByHash($hash);

        if (!$card instanceof CardInterface) {
            throw new NotFoundHttpException('The resource is not found or you don\'t have permission');
        }
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

        $gallery = $template->getGallery();
        $first = array_slice($gallery, 0, 5);
        $second = array_slice($gallery, 5, 4);
        $rest = array_slice($gallery, 9);
        return $this->render($template->getPath(), array(
            'data' => $template->getData(),
            'name' => $template->getName(),
            'gallery' => $gallery,
            'first' => $first,
            'second' => $second,
            'rest' => $rest,
            'date' => $template->getWeddingDate(),
            'lat' => $template->getLatitude(),
            'lon' => $template->getLongitude(),
            'forGroom' => $template->isForGroom()
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

        // get object id
        $domain = $this->getParameter('domain');
        $url = sprintf('http://%s%s', $domain, $request->getPathInfo());
        $url = urlencode($url);
        $request = sprintf('https://graph.facebook.com/?id=%s', $url);
        $curl = new CurlRestClient();
        $objectId = null;
        $response = $curl->executeQuery($request);
        if (!empty($response)) {
            $response = json_decode($response, true);
            if (is_array($response) && array_key_exists('og_object', $response)) {
                $objectId = $response['og_object']['id'];
            }
        }

        $comments = [];
        if ($objectId != null) {
            $appId = $this->getParameter('facebook_app_id');
            $appSecret = $this->getParameter('facebook_app_secret');

            $fb = new \Facebook\Facebook([
                'app_id' => $appId,
                'app_secret' => $appSecret,
                'default_graph_version' => 'v2.9',
            ]);
            $ac = $fb->getApp()->getAccessToken()->getValue();
            $response = $fb->get(sprintf('/%s/comments', $objectId), $ac);
            if (!empty($response)) {
                $response = json_decode($response, true);
                if (is_array($response) && array_key_exists('data', $response)) {
                    $comments = $response['data'];
                }
            }
        }
        $template = $card->getTemplate();
        $data = $card->getData();
        $name = sprintf('%s-%s-%s', $data['groom_name'], $data['bride_name'], $card->getWeddingDate()->format('Ymd'));
        $gallery = $card->getGallery();
        $first = array_slice($gallery, 0, 5);
        $second = array_slice($gallery, 5, 4);
        $rest = array_slice($gallery, 9);

        return $this->render($template->getPath(), array (
            'data' => $data,
            'gallery' => $gallery,
            'first' => $first,
            'second' => $second,
            'rest' => $rest,
            'date' => $card->getWeddingDate(),
            'lon' => $card->getLongitude(),
            'lat' => $card->getLatitude(),
            'name' => $name,
            'comments' => $comments,
            'forGroom' => $card->isForGroom()
        ));
    }
}