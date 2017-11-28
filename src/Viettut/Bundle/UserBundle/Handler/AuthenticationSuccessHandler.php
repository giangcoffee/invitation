<?php
/**
 * Created by PhpStorm.
 * User: giang
 * Date: 2/26/17
 * Time: 9:29 PM
 */

namespace Viettut\Bundle\UserBundle\Handler;


use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\SecurityContextInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationFailureHandlerInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;

class AuthenticationSuccessHandler implements AuthenticationSuccessHandlerInterface, AuthenticationFailureHandlerInterface
{

    /**
     * @var string
     */
    protected $cookieDomain;

    /**
     * @var string
     */
    protected $cookiePath;

    /**
     * @var int
     */
    protected $cookieLifetime;

    /**
     * @var RouterInterface
     */
    protected $router;

    /**
     * @var Session
     */
    protected $session;

    /**
     * AuthenticationSuccessHandler constructor.
     * @param RouterInterface $router
     * @param Session $session
     * @param string $cookieDomain
     * @param string $cookiePath
     * @param int $cookieLifetime
     */
    public function __construct(RouterInterface $router, Session $session, $cookieDomain, $cookiePath, $cookieLifetime)
    {
        $this->router  = $router;
        $this->session = $session;
        $this->cookieDomain = $cookieDomain;
        $this->cookiePath = $cookiePath;
        $this->cookieLifetime = $cookieLifetime;
    }

    /**
     * This is called when an interactive authentication attempt succeeds. This
     * is called by authentication listeners inheriting from
     * AbstractAuthenticationListener.
     *
     * @param Request $request
     * @param TokenInterface $token
     *
     * @return Response never null
     */
    public function onAuthenticationSuccess(Request $request, TokenInterface $token)
    {
        $session = $request->getSession();
        $session->set('is_logged_in', true);
        $session->set('logged_in_userid', $token->getUsername());
        $session->save();
        $request->setSession($session);

        // if AJAX login
        if ( $request->isXmlHttpRequest() ) {

            $array = array('success' => true); // data to return via JSON
            $response = new Response( json_encode( $array ) );
            $response->headers->set( 'Content-Type', 'application/json' );

            //set cookies
            $cookie = new Cookie('is_logged_in', true, time() + $this->cookieLifetime, $this->cookiePath, $this->cookieDomain);
            $response->headers->setCookie($cookie);

            $cookie = new Cookie('logged_in_userid', $token->getUsername(), time() + $this->cookieLifetime, $this->cookiePath, $this->cookieDomain);
            $response->headers->setCookie($cookie);

            return $response;

        // if form login
        } else {
            $url = $request->request->get('_target_url', null);
            if ($url == null)  {
                $url = '/';
            }

            $response = new RedirectResponse($url);
            $cookie = new Cookie('is_logged_in', true, time() + $this->cookieLifetime, $this->cookiePath, $this->cookieDomain);
            $response->headers->setCookie($cookie);

            $cookie = new Cookie('logged_in_userid', $token->getUsername(), time() + $this->cookieLifetime, $this->cookiePath, $this->cookieDomain);
            $response->headers->setCookie($cookie);
            return $response;
        }
    }

    /**
     * onAuthenticationFailure
     *
     * @author 	Joe Sexton <joe@webtipblog.com>
     * @param 	Request $request
     * @param 	AuthenticationException $exception
     * @return 	Response
     */
    public function onAuthenticationFailure( Request $request, AuthenticationException $exception )
    {
        // if AJAX login
        if ( $request->isXmlHttpRequest() ) {

            $array = array( 'success' => false, 'message' => $exception->getMessage() );
            $response = new Response( json_encode( $array ) );
            $response->headers->set( 'Content-Type', 'application/json' );

            return $response;

        // if form login
        } else {

            // set authentication exception to session
            $request->getSession()->set(SecurityContextInterface::AUTHENTICATION_ERROR, $exception);

            return new RedirectResponse( $this->router->generate('fos_user_security_login'));
        }
    }


    /**
     * @param InteractiveLoginEvent $event
     */
    public function onSecurityInteractiveLogin(InteractiveLoginEvent $event)
    {
        $token = $event->getAuthenticationToken();
        $request = $event->getRequest();
        $this->onAuthenticationSuccess($request, $token);
    }
}