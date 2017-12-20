<?php


namespace Viettut\Bundle\ApiBundle\EventListener;


use Doctrine\ORM\Event\PreUpdateEventArgs;
use Geocoder\Provider\GoogleMaps\GoogleMaps;
use Geocoder\Query\GeocodeQuery;
use Geocoder\StatefulGeocoder;
use Http\Adapter\Guzzle6\Client;
use Viettut\Model\Core\CardInterface;

class UpdateGeoLocationListener
{

    private $apiKey;

    /**
     * UpdateGeoLocationListener constructor.
     * @param $apiKey
     */
    public function __construct($apiKey)
    {
        $this->apiKey = $apiKey;
    }

    /**
     * @param PreUpdateEventArgs $args
     */
    public function preUpdate(PreUpdateEventArgs $args)
    {
        $entity = $args->getEntity();
        if (!$entity instanceof CardInterface) {
            return;
        }

        if (!$args->hasChangedField('data')) {
            return;
        }

        $this->updateGeoLocation($entity);
    }

    protected function updateGeoLocation(CardInterface $card)
    {
        $data = $card->getData();
        if (empty($data)) {
            return;
        }


        $adapter  = new Client();
        $provider = new GoogleMaps($adapter, null, $this->apiKey);
        $geocoder = new StatefulGeocoder($provider, 'vi');

        if (array_key_exists('place_addr', $data) && !empty($data['place_addr'])) {
            $result = $geocoder->geocodeQuery(GeocodeQuery::create($data['place_addr']));
            if (!$result->isEmpty()) {
                $location = $result->first();
                $coordinate = $location->getCoordinates();
                if ($coordinate) {
                    $card->setLatitude(strval($coordinate->getLatitude()));
                    $card->setLongitude(strval($coordinate->getLongitude()));
                }
            }
        }

        if (array_key_exists('home', $data) && !empty($data['home'])) {
            $result = $geocoder->geocodeQuery(GeocodeQuery::create($data['home']));
            if (!$result->isEmpty()) {
                $location = $result->first();
                $coordinate = $location->getCoordinates();
                if ($coordinate) {
                    $card->setHomeLatitude(strval($coordinate->getLatitude()));
                    $card->setHomeLongitude(strval($coordinate->getLongitude()));
                }
            }
        }
    }
}