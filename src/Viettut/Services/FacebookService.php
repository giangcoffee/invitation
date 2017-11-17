<?php


namespace Viettut\Services;


use Facebook\Facebook;
use RestClient\CurlRestClient;
use Viettut\DomainManager\CardManagerInterface;
use Viettut\Model\Core\CardInterface;

class FacebookService implements FacebookServiceInterface
{
    /** @var string */
    private $appId;

    /** @var  string */
    private $appSecret;

    /** @var  string */
    private $defaultGraphVersion;

    /** @var  string */
    private $loginRedirectUrl;

    /** @var  string */
    private $getAlbumRedirectUrl;

    /**
     * FacebookService constructor.
     * @param string $appId
     * @param string $appSecret
     * @param $loginRedirectUrl
     * @param $getAlbumRedirectUrl
     * @param string $defaultGraphVersion
     */
    public function __construct($appId, $appSecret, $loginRedirectUrl, $getAlbumRedirectUrl, $defaultGraphVersion)
    {
        $this->appId = $appId;
        $this->appSecret = $appSecret;
        $this->defaultGraphVersion = $defaultGraphVersion;
        $this->loginRedirectUrl = $loginRedirectUrl;
        $this->getAlbumRedirectUrl = $getAlbumRedirectUrl;
    }

    /**
     * @return string
     */
    public function getAppId(): string
    {
        return $this->appId;
    }

    /**
     * @return string
     */
    public function getAppSecret(): string
    {
        return $this->appSecret;
    }

    /**
     * @return string
     */
    public function getDefaultGraphVersion(): string
    {
        return $this->defaultGraphVersion;
    }


    public function getFacebookApp()
    {
        return new Facebook([
            'app_id' => self::getAppId(),
            'app_secret' => self::getAppSecret(),
            'default_graph_version' => self::getDefaultGraphVersion(),
        ]);
    }

    public function getUserAlbums($token)
    {
        $albums = [];
        try {
            $fb = new Facebook([
                'app_id' => $this->appId,
                'app_secret' => $this->appSecret,
                'default_graph_version' => $this->defaultGraphVersion,
            ]);

            $response = $fb->get('/me/albums', $token);
            if ($response) {
                $body = $response->getBody();
                $body = json_decode($body, true);
                if (is_array($body) && array_key_exists('data', $body)) {
                    $albums = $body['data'];
                }
            }
            return $albums;
        } catch (\Exception $ex) {
        } finally {
            return $albums;
        }
    }

    public function getAlbumPhotos($token, $albumId)
    {
        $photos = [];
        try {
            $fb = new \Facebook\Facebook([
                'app_id' => $this->appId,
                'app_secret' => $this->appSecret,
                'default_graph_version' => $this->defaultGraphVersion,
            ]);

            $response = $fb->get(sprintf('/%s/photos?fields=images', $albumId) , $token);
            if ($response) {
                $body = $response->getBody();
                $body = json_decode($body, true);
                if (is_array($body) && array_key_exists('data', $body)) {
                    $body = $body['data'];
                    if (is_array($body) && array_key_exists('images', $body)) {
                        $photos = $body['images'];
                    }
                }
            }
            return $photos;
        } catch (\Exception $ex) {
        } finally {
            return $photos;
        }
    }

    public function getLoginUrl()
    {
        $fb = $this->getFacebookApp();
        $helper = $fb->getRedirectLoginHelper();
        $permissions = ['email', 'user_likes', 'user_photos']; // optional

        return $helper->getLoginUrl($this->loginRedirectUrl, $permissions);
    }

    public function getAlbumUrl()
    {
        $fb = $this->getFacebookApp();
        $helper = $fb->getRedirectLoginHelper();
        $permissions = ['email', 'user_likes', 'user_photos']; // optional

        return $helper->getLoginUrl($this->getAlbumRedirectUrl, $permissions);
    }
}