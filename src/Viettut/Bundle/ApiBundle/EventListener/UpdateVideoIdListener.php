<?php


namespace Viettut\Bundle\ApiBundle\EventListener;


use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Viettut\Exception\InvalidArgumentException;
use Viettut\Model\Core\CardInterface;
use Viettut\Utilities\StringFactory;

class UpdateVideoIdListener
{
    use StringFactory;

    /**
     * @param LifecycleEventArgs $args
     */
    public function prePersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        if (!$entity instanceof CardInterface) {
            return;
        }
        $data = $entity->getData();
        $name = sprintf('%s %s %s thang %s nam %s %s',
            $data['groom_name'],
            $data['bride_name'],
            $entity->getWeddingDate()->format('d'),
            $entity->getWeddingDate()->format('m'),
            $entity->getWeddingDate()->format('Y'),
            uniqid('')
        );

        $entity->setHash($this->getUrlFriendlyString($name));
        if (empty($entity->getGallery())) {
            $entity->setGallery($entity->getTemplate()->getGallery());
        }

        if (preg_match('#https?://(?:www\.)?youtube\.com/watch\?v=([^&]+)#', $entity->getVideo(), $matches)) {
            $entity->setValidVideo(true);
            $entity->setVideoId($matches[1]);
        } else {
            throw new InvalidArgumentException(sprintf('%s is not a valid Youtube link', $entity->getVideo()));
        }
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

        if (!$args->hasChangedField('video')) {
            return;
        }

        if (preg_match('#https?://(?:www\.)?youtube\.com/watch\?v=([^&]+)#', $entity->getVideo(), $matches)) {
            $entity->setValidVideo(true);
            $entity->setVideoId($matches[1]);
        } else {
            throw new InvalidArgumentException(sprintf('%s is not a valid Youtube link', $entity->getVideo()));
        }
    }
}