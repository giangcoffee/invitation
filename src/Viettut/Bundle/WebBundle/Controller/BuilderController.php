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
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Viettut\DomainManager\CardManagerInterface;
use Viettut\Model\Core\CardInterface;
use Viettut\Model\Core\TemplateInterface;
use Symfony\Component\Security\Core\Security;
use Viettut\Model\User\UserEntityInterface;
use Zalo\Zalo;
use Zalo\ZaloConfig;

class BuilderController extends Controller
{
    /**
     * @Route("/cards/{hash}/edit", name="edit_card_page")
     * @param $request
     * @return Response
     */
    public function builderAction(Request $request, $hash)
    {
        if (!$this->getUser() instanceof UserEntityInterface) {
            $this->container->get('session')->set('_security.main.target_path', $this->generateUrl('edit_card_page', array('hash' => $hash)));
            return $this->redirect($this->generateUrl('fos_user_security_login'));
        }

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
            'forGroom' => $card->isForGroom(),
            'video' => $card->getVideo()
        ));
    }

    /**
     * @Route("/cards/{hash}/guest-book", name="guest_book_page")
     * @param $request
     * @return Response
     */
    public function guestBookAction(Request $request, $hash)
    {
        if (!$this->getUser() instanceof UserEntityInterface) {
            $this->container->get('session')->set('_security.main.target_path', $this->generateUrl('guest_book_page', array('hash' => $hash)));
        }

        /** @var CardManagerInterface $cardManager */
        $cardManager = $this->get('viettut.domain_manager.card');
        $card = $cardManager->getCardByHash($hash);

        if (!$card instanceof CardInterface) {
            throw new NotFoundHttpException('The resource is not found or you don\'t have permission');
        }

        $referrer = $this->generateUrl('card_page', array('hash' => $hash));
        $groom = $card->getData()['groom_name'];
        $bride = $card->getData()['bride_name'];
        $date = $card->getWeddingDate();

        /** @var $session \Symfony\Component\HttpFoundation\Session\Session */
        $session = $request->getSession();

        $authErrorKey = Security::AUTHENTICATION_ERROR;
        $lastUsernameKey = Security::LAST_USERNAME;
        // get the error if any (works with forward and redirect -- see below)
        if ($request->attributes->has($authErrorKey)) {
            $error = $request->attributes->get($authErrorKey);
        } elseif (null !== $session && $session->has($authErrorKey)) {
            $error = $session->get($authErrorKey);
            $session->remove($authErrorKey);
        } else {
            $error = null;
        }

        if (!$error instanceof AuthenticationException) {
            $error = null; // The value does not come from the security component.
        }

        // last username entered by the user
        $lastUsername = (null === $session) ? '' : $session->get($lastUsernameKey);

        $csrfToken = $this->has('security.csrf.token_manager')
            ? $this->get('security.csrf.token_manager')->getToken('authenticate')->getValue()
            : null;

        $facebookAppId = $this->getParameter('facebook_app_id');
        $facebookAppSecret = $this->getParameter('facebook_app_secret');
        $facebookRedirectUri = $this->getParameter('facebook_redirect_uri');
        $fb = new \Facebook\Facebook([
            'app_id' => $facebookAppId,
            'app_secret' => $facebookAppSecret,
            'default_graph_version' => 'v2.9',
        ]);

        $helper = $fb->getRedirectLoginHelper();
        $permissions = ['email', 'user_likes']; // optional
        $facebookLoginUrl = $helper->getLoginUrl($facebookRedirectUri, $permissions);

        $zalo = new Zalo(ZaloConfig::getInstance()->getConfig());
        $helper = $zalo -> getRedirectLoginHelper();
        $zaloLoginUrl = $helper->getLoginUrl($this->getParameter('zalo_redirect_uri'));

        $comments = $card->getComments();
        return $this->render('@ViettutWeb/Builder/guestbook.html.twig', array(
            'referrer' => $referrer,
            'groom' => $groom,
            'bride' => $bride,
            'date' => $date,
            'last_username' => $lastUsername,
            'error' => $error,
            'csrf_token' => $csrfToken,
            'facebookUrl' => $facebookLoginUrl,
            'zaloUrl' => $zaloLoginUrl,
            'id' => $card->getId(),
            'comments' => $comments
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
            'forGroom' => $template->isForGroom(),
            'isTemplate' => true,
            'hash' => $hash
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

        $comments = $card->getComments();
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
            'forGroom' => $card->isForGroom(),
            'isTemplate' => false,
            'hash' => $hash,
            'video' => $card->getVideo()
        ));
    }
}