<?php


namespace Viettut\Bundle\ApiBundle\EventListener;


use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Geocoder\Provider\GoogleMaps\GoogleMaps;
use Geocoder\Query\GeocodeQuery;
use Geocoder\StatefulGeocoder;
use Http\Adapter\Guzzle6\Client;
use Viettut\Model\Core\CardInterface;

class UpdateGeoLocationListener
{
    /**
     * @param LifecycleEventArgs $args
     */
    public function prePersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        if (!$entity instanceof CardInterface) {
            return;
        }

        $this->updateGeoLocation($entity);
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
        $adapter  = new Client();
        $provider = new GoogleMaps($adapter, null, 'AIzaSyDxhMSp7eUxSr3lJocnsQIsP4p_Wanqpnk');
        $geocoder = new StatefulGeocoder($provider, 'vi');

        $result = $geocoder->geocodeQuery(GeocodeQuery::create($data['place_addr']));
        if (!$result->isEmpty()) {
            $location = $result->first();
            $coordinate = $location->getCoordinates();
            if ($coordinate) {
                $card->setLatitude(strval($coordinate->getLatitude()));
                $card->setLongitude(strval($coordinate->getLongitude()));
            }
        }

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