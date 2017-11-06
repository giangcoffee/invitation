<?php


namespace Viettut\Services;


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

    private $domain;

    /** @var  string */
    private $httpSchema;

    /** @var  string */
    private $objectIdUrlTemplate;

    /** @var  CardManagerInterface */
    protected $cardManager;

    /**
     * FacebookService constructor.
     * @param string $appId
     * @param string $appSecret
     * @param string $defaultGraphVersion
     * @param string $domain
     * @param string $httpSchema
     * @param string $objectIdUrlTemplate
     * @param CardManagerInterface $cardManager
     */
    public function __construct($appId, $appSecret, $defaultGraphVersion, $domain, $httpSchema, $objectIdUrlTemplate, CardManagerInterface $cardManager)
    {
        $this->appId = $appId;
        $this->appSecret = $appSecret;
        $this->defaultGraphVersion = $defaultGraphVersion;
        $this->domain = $domain;
        $this->httpSchema = $httpSchema;
        $this->objectIdUrlTemplate = $objectIdUrlTemplate;
        $this->cardManager = $cardManager;
    }


    /**
     * @param CardInterface $card
     * @return array|mixed
     */
    public function getCommentsForCard(CardInterface $card)
    {
        $graphObjectId = $this->getGraphObjectIdForCard($card);
        $comments = [];
        try {
            $fb = new \Facebook\Facebook([
                'app_id' => $this->appId,
                'app_secret' => $this->appSecret,
                'default_graph_version' => $this->defaultGraphVersion,
            ]);

            $ac = $fb->getApp()->getAccessToken()->getValue();
            $response = $fb->get(sprintf('/%s/comments', $graphObjectId), $ac);
            if ($response) {
                $body = $response->getBody();
                $body = json_decode($body, true);
                if (is_array($body) && array_key_exists('data', $body)) {
                    $comments = $body['data'];
                }
            }
            return $comments;
        } catch (\Exception $ex) {
        } finally {
            return $comments;
        }
    }

    /**
     * @param CardInterface $card
     * @return null
     */
    public function getGraphObjectIdForCard(CardInterface $card)
    {
        if (!empty($card->getCommentObjectId())) {
            return $card->getCommentObjectId();
        }

        $url = sprintf('%s%s/cards/%s', $this->httpSchema, $this->domain, $card->getHash());
        $request = sprintf($this->objectIdUrlTemplate, urlencode($url));
        $curl = new CurlRestClient();
        $objectId = null;
        $response = $curl->executeQuery($request);
        if (!empty($response)) {
            $response = json_decode($response, true);
            if (is_array($response) && array_key_exists('og_object', $response)) {
                $objectId = $response['og_object']['id'];
                $card->setCommentObjectId($objectId);
                $this->cardManager->save($card);
            }
        }

        return $objectId;
    }
}