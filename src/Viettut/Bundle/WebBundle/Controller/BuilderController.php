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
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Viettut\DomainManager\CardManagerInterface;
use Viettut\Model\Core\CardInterface;
use Viettut\Model\Core\TemplateInterface;
use Symfony\Component\Security\Core\Security;
use Viettut\Model\User\UserEntityInterface;
use Viettut\Utilities\DateUtil;

class BuilderController extends Controller
{
    use DateUtil;
    /**
     * @Route("/cards/{hash}/edit", name="edit_card_page")
     * @param $request
     * @return Response
     */
    public function builderAction(Request $request, $hash)
    {
        $user = $this->getUser();
        if (!$user instanceof UserEntityInterface) {
            return $this->redirect($this->generateUrl('fos_user_security_login', array('_target_url' => $request->getUri())));
        }

        /** @var CardManagerInterface $cardManager */
        $cardManager = $this->get('viettut.domain_manager.card');
        $card = $cardManager->getCardByHash($hash);

        if (!$card instanceof CardInterface) {
            throw new NotFoundHttpException('The resource is not found or you don\'t have permission');
        }

        if ($card->getAuthor()->getId() != $user->getId()) {
            throw new NotFoundHttpException('The resource is not found or you don\'t have permission');
        }

        $template = $card->getTemplate();
        return $this->render('ViettutWebBundle:Builder:edit.htm.twig', array(
            'data' => $card->getData(),
            'columns' => $template->getColumns(),
            'gallery' => $card->getGallery(),
            'date' => $card->getWeddingDate(),
            'partyDate' => $card->getPartyDate(),
            'id' => $card->getId(),
            'name' => $template->getName(),
            'hash' => $card->getHash(),
            'forGroom' => $card->isForGroom(),
            'video' => $card->getVideo(),
            'embed' => $card->getEmbedded()
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

        $targetUrl = $request->getUri();
        $socialService = $this->get('viettut.services.social_service');
        $facebookLoginUrl = $socialService->getFacebookLoginUrl($targetUrl);
        $zaloLoginUrl = $socialService->getZaloLoginUrl($targetUrl);
        $googleLoginUrl = $socialService->getGoogleLoginUrl($targetUrl);

        $comments = $this->get('viettut.repository.comment')->getByCard($card);
        return $this->render('@ViettutWeb/Builder/guestbook.html.twig', array(
            'referrer' => $referrer,
            'groom' => $groom,
            'bride' => $bride,
            'date' => $date,
            'last_username' => $lastUsername,
            'error' => $error,
            'csrf_token' => $csrfToken,
            'facebookUrl' => $facebookLoginUrl,
            'googleUrl' => $googleLoginUrl,
            'zaloUrl' => $zaloLoginUrl,
            'id' => $card->getId(),
            'comments' => $comments,
            'hash' => $card->getHash()
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
        $data = $template->getData();
        $description = "
            On a spring day,
            Two loving people are about to start a new life.
            Even if you are busy, bless the first start of the two
            If you encourage me, I will be more joy.";

        if (array_key_exists('greeting', $data) && !empty($data['greeting'])) {
            $description = $data['greeting'];
        }

        return $this->render($template->getPath(), array(
            'data' => $data,
            'name' => $template->getName(),
            'gallery' => $gallery,
            'date' => $template->getWeddingDate(),
            'dateAl' => $this->getLunarDateString($template->getWeddingDate()),
            'weddingDate' => $template->getWeddingDate(),
            'lat' => $template->getLatitude(),
            'lon' => $template->getLongitude(),
            'homeLon' => $template->getHomeLongitude(),
            'homeLat' => $template->getHomeLatitude(),
            'forGroom' => $template->isForGroom(),
            'isTemplate' => true,
            'hash' => $hash,
            'id' => $template->getId(),
            'voted' => true,
            'description' => $description
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
        $description = "
            On a spring day,
            Two loving people are about to start a new life.
            Even if you are busy, bless the first start of the two
            If you encourage me, I will be more joy.";

        if (array_key_exists('greeting', $data) && !empty($data['greeting'])) {
            $description = $data['greeting'];
        }

        $name = sprintf('Hôn lễ của %s và %s-%s', $data['groom_name'], $data['bride_name'], $card->getWeddingDate()->format('d-m-Y'));
        $gallery = $card->getGallery();
        $card->setViews($card->getViews() + 1);
        $cardManager->save($card);
        $userVoted = false;
        if (!array_key_exists('user_unique_id', $_COOKIE)) {
            $uniqueUser = uniqid('user', true);
            setcookie("user_unique_id", uniqid('user', true), time() + 604800); //cookie expire in 7 day
        } else {
            $uniqueUser = $_COOKIE['user_unique_id'];
        }

        $statuses = $this->get('viettut.repository.status')->checkUniqueUserForCard($card, $uniqueUser);
        if (count($statuses) > 0) {
            $userVoted = true;
        }

        return $this->render($template->getPath(), array (
            'data' => $data,
            'gallery' => $gallery,
            'date' => $card->getPartyDate(),
            'dateAl' => $this->getLunarDateString($card->getPartyDate()),
            'weddingDate' => $card->getWeddingDate(),
            'lon' => $card->getLongitude(),
            'lat' => $card->getLatitude(),
            'homeLon' => $card->getHomeLongitude(),
            'homeLat' => $card->getHomeLatitude(),
            'name' => $name,
            'comments' => $comments,
            'forGroom' => $card->isForGroom(),
            'isTemplate' => false,
            'hash' => $hash,
            'embed' => $card->getEmbedded(),
            'id' => $card->getId(),
            'voted' => $userVoted,
            'description' => $description
        ));
    }
}