<?php


namespace Viettut\Bundle\ApiBundle\EventListener;


use Doctrine\ORM\Event\PreUpdateEventArgs;
use Viettut\Exception\InvalidArgumentException;
use Viettut\Model\Core\CardInterface;
use Viettut\Model\Core\LibraryCardInterface;

class UpdateVideoIdListener
{
    const TEMPLATE = '<iframe id="movie" width="100%" src="https://www.youtube.com/embed/$$VIDEO_ID$$?showinfo=0&autohide=1&rel=0&vq=hd1080" height="100%" frameborder="0" allowfullscreen></iframe>';

    /**
     * @param PreUpdateEventArgs $args
     */
    public function preUpdate(PreUpdateEventArgs $args)
    {
        $entity = $args->getEntity();
        if (!$entity instanceof LibraryCardInterface) {
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
                $entity->setEmbedded(str_replace('$$VIDEO_ID$$', $matches[1], self::TEMPLATE));
            } else {
                throw new InvalidArgumentException(sprintf('%s is not a valid Youtube link', $video));
            }
        }
    }
}