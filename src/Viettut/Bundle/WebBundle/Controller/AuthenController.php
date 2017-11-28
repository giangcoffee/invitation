<?php
/**
 * Created by PhpStorm.
 * User: giang
 * Date: 10/31/15
 * Time: 10:37 PM
 */

namespace Viettut\Bundle\WebBundle\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Viettut\Exception\RuntimeException;
use Viettut\Model\User\UserEntityInterface;
use Zalo\Authentication\AccessToken;
use Zalo\Zalo;
use Zalo\ZaloConfig;

class AuthenController extends Controller
{
    /**
     * @Route("/facebook/login", name="facebook_login")
     */
    public function facebookLoginAction(Request $request)
    {
        $lecturerManager = $this->get('viettut_user.domain_manager.lecturer');
        $fb = $this->get('viettut.services.facebook_service')->getFacebookApp();

        $helper = $fb->getRedirectLoginHelper();
        try {
            $accessToken = $helper->getAccessToken();
            $fb->setDefaultAccessToken($accessToken);
            $response = $fb->get('/me?fields=id,name,email', $fb->getDefaultAccessToken());
            $userNode = $response->getGraphUser();
            $email = $userNode->getEmail();
            $avatar = sprintf('http://graph.facebook.com/%s/picture?type=normal', $userNode->getId());
            $user = $lecturerManager->findUserByUsernameOrEmail($email);

            if (!$user instanceof UserEntityInterface) {
                $user = $lecturerManager->createNew();

                $user
                    ->setEnabled(true)
                    ->setPlainPassword($userNode->getEmail())
                    ->setUsername($userNode->getEmail())
                    ->setEmail($userNode->getEmail())
                    ->setName($userNode->getName())
                    ->setFacebookId($userNode->getId())
                    ->setAvatar($avatar)
                ;
                $lecturerManager->save($user);
            } else {
                if (!$user->getGoogleId()) {
                    $user->setAvatar($avatar);
                }

                $user->setFacebookId($userNode->getId());
                $lecturerManager->save($user);
            }

            $token = new UsernamePasswordToken($user, $user->getPassword(), 'main', $user->getRoles());

            $this->get("security.token_storage")->setToken($token);
        } catch(\Facebook\Exceptions\FacebookResponseException $e) {
            // When Graph returns an error
            echo 'Graph returned an error: ' . $e->getMessage();
        } catch(\Facebook\Exceptions\FacebookSDKException $e) {
            // When validation fails or other local issues
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
        }

        $targetUrl = $request->query->get('_target_url', null);
        if ($targetUrl) {
            return $this->redirect($targetUrl);
        }

        return $this->redirect($this->generateUrl('home_page'));
    }

    /**
     * @Route("/facebook/album", name="facebook_album")
     */
    public function facebookAlbumAction(Request $request)
    {
        $lecturerManager = $this->get('viettut_user.domain_manager.lecturer');
        $facebookService = $this->get('viettut.services.facebook_service');
        $fb = $facebookService->getFacebookApp();

        $helper = $fb->getRedirectLoginHelper();
        try {
            $accessToken = $helper->getAccessToken();
            $facebookService->getUserAlbums($accessToken);
            $fb->setDefaultAccessToken($accessToken);
            $response = $fb->get('/me?fields=id,name,email', $fb->getDefaultAccessToken());
            $userNode = $response->getGraphUser();
            $email = $userNode->getEmail();
            $avatar = sprintf('http://graph.facebook.com/%s/picture?type=normal', $userNode->getId());
            $user = $lecturerManager->findUserByUsernameOrEmail($email);

            if (!$user instanceof UserEntityInterface) {
                $user = $lecturerManager->createNew();

                $user
                    ->setEnabled(true)
                    ->setPlainPassword($userNode->getEmail())
                    ->setUsername($userNode->getEmail())
                    ->setEmail($userNode->getEmail())
                    ->setName($userNode->getName())
                    ->setFacebookId($userNode->getId())
                    ->setAvatar($avatar)
                ;
                $lecturerManager->save($user);
            } else {
                if (!$user->getGoogleId()) {
                    $user->setAvatar($avatar);
                }

                $user->setFacebookId($userNode->getId());
                $lecturerManager->save($user);
            }

            $token = new UsernamePasswordToken($user, $user->getPassword(), 'main', $user->getRoles());

            $this->get("security.token_storage")->setToken($token);
        } catch(\Facebook\Exceptions\FacebookResponseException $e) {
            // When Graph returns an error
            echo 'Graph returned an error: ' . $e->getMessage();
        } catch(\Facebook\Exceptions\FacebookSDKException $e) {
            // When validation fails or other local issues
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
        }

        return $this->redirect($this->generateUrl('home_page'));
    }

    /**
     * @param Request $request
     * @Route("/zalo/login", name="zalo_login")
     * @throws \Exception
     */
    public function zaloLoginAction(Request $request)
    {
        $lecturerManager = $this->get('viettut_user.domain_manager.lecturer');
        $usernameService = $this->get('viettut.services.username_service');
        $zalo = new Zalo(ZaloConfig::getInstance()->getConfig());
        $helper = $zalo -> getRedirectLoginHelper();
        try {
            $accessToken = $helper->getAccessToken($this->getParameter('zalo_redirect_uri'));
            if (!$accessToken instanceof AccessToken) {
                throw new RuntimeException('Không thể xác thực bằng tài khoản Zalo. Vui lòng thực hiện lại sau');
            }

            $params = ['fields' => "id, name, picture"];
            $response = $zalo->get('/me', $accessToken->getValue(), $params, Zalo::API_TYPE_GRAPH);
            $result = $response->getDecodedBody(); // result
            $id = array_key_exists('id', $result) ? $result['id'] : null;
            $avatar = isset($result['picture']['data']['url']) ? $result['picture']['data']['url'] : null;
            $name = array_key_exists('name', $result) ? $result['name'] : null;
            $username = $usernameService->generateUsername($name);
            $user = $lecturerManager->findUserByZaloId($id);

            if (!$user instanceof UserEntityInterface) {
                $user = $lecturerManager->createNew();

                $user
                    ->setEnabled(true)
                    ->setPlainPassword($id)
                    ->setUsername($username)
                    ->setEmail($name)
                    ->setName($name)
                    ->setZaloId($id)
                    ->setAvatar($avatar)
                ;

                $lecturerManager->save($user);
            }

            $token = new UsernamePasswordToken($user, $user->getPassword(), 'main', $user->getRoles());

            $this->get("security.token_storage")->setToken($token);
        } catch (\Exception $ex) {
            throw new RuntimeException('Không thể xác thực bằng tài khoản Zalo. Vui lòng thực hiện lại sau');
        }
        
        $targetUrl = $request->query->get('_target_url', null);
        if ($targetUrl) {
            return $this->redirect($targetUrl);
        }

        return $this->redirect($this->generateUrl('home_page'));
    }


}