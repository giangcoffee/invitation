<?php


namespace Viettut\Bundle\ApiBundle\EventListener;


use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Viettut\Exception\InvalidArgumentException;
use Viettut\Model\Core\CardInterface;
use Viettut\Utilities\StringFactory;

class UpdateVideoIdListener
{
    const TEMPLATE = '<iframe id="movie" width="100%" src="http://www.youtube.com/embed/$$VIDEO_ID$$?showinfo=0&autohide=1&rel=0&vq=hd1080" height="100%" frameborder="0" allowfullscreen></iframe>';
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
        if ($entity->isForGroom()) {
            $name = sprintf('%s %s %s thang %s nam %s %s',
                $data['groom_name'],
                $data['bride_name'],
                $entity->getWeddingDate()->format('d'),
                $entity->getWeddingDate()->format('m'),
                $entity->getWeddingDate()->format('Y'),
                uniqid('')
            );
        } else {
            $name = sprintf('%s %s %s thang %s nam %s %s',
                $data['bride_name'],
                $data['groom_name'],
                $entity->getWeddingDate()->format('d'),
                $entity->getWeddingDate()->format('m'),
                $entity->getWeddingDate()->format('Y'),
                uniqid('')
            );
        }

        $entity->setHash($this->getUrlFriendlyString($name));
        if (empty($entity->getGallery())) {
            $entity->setGallery($entity->getTemplate()->getGallery());
        }

        $video = $entity->getVideo();
        if (!empty($video) && empty($entity->getEmbedded())) {
            if (preg_match('#https?://(?:www\.)?youtube\.com/watch\?v=([^&]+)#', $video, $matches)) {
                $entity->setValidVideo(true);
                $entity->setVideoId($matches[1]);
                $entity->setEmbedded(str_replace('$$VIDEO_ID$$', $matches[1], self::TEMPLATE));
            } else {
                throw new InvalidArgumentException(sprintf('%s is not a valid Youtube link', $video));
            }
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

        $video = $entity->getVideo();
        if (!empty($video)) {
            if (preg_match('#https?://(?:www\.)?youtube\.com/watch\?v=([^&]+)#', $video, $matches)) {
                $entity->setValidVideo(true);
                $entity->setVideoId($matches[1]);
            } else {
                throw new InvalidArgumentException(sprintf('%s is not a valid Youtube link', $video));
            }
        }
    }
}