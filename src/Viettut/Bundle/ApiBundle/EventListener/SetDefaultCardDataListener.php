<?php


namespace Viettut\Bundle\ApiBundle\EventListener;


use Doctrine\ORM\Event\LifecycleEventArgs;
use Viettut\Exception\InvalidArgumentException;
use Viettut\Model\Core\CardInterface;
use Viettut\Utilities\StringFactory;

class SetDefaultCardDataListener
{
    const TEMPLATE = '<iframe id="movie" width="100%" src="https://www.youtube.com/embed/$$VIDEO_ID$$?showinfo=0&autohide=1&rel=0&vq=hd1080" height="100%" frameborder="0" allowfullscreen></iframe>';
    const DEFAULT_VIDEO_ID = 'Q9aUb6FJdhk';
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
        } else if (empty($video) && empty($entity->getEmbedded())) {
            $entity->setEmbedded(str_replace('$$VIDEO_ID$$', self::DEFAULT_VIDEO_ID, self::TEMPLATE));
        }

        $template = $entity->getTemplate();

        $templateData = $template->getData();
        $templateData['bride_name'] = $data['bride_name'];
        $templateData['groom_name'] = $data['groom_name'];

        $entity
            ->setData($templateData)
            ->setLongitude($template->getLongitude())
            ->setLatitude($template->getLatitude())
            ->setHomeLatitude($template->getHomeLatitude())
            ->setHomeLongitude($template->getHomeLongitude())
        ;
    }
}