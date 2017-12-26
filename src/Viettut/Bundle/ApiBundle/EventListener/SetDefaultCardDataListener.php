<?php


namespace Viettut\Bundle\ApiBundle\EventListener;


use Doctrine\ORM\Event\LifecycleEventArgs;
use Viettut\Bundle\UserBundle\Entity\User;
use Viettut\Entity\Core\Comment;
use Viettut\Exception\InvalidArgumentException;
use Viettut\Model\Core\CardInterface;
use Viettut\Utilities\StringFactory;

class SetDefaultCardDataListener
{
    const TEMPLATE = '<iframe id="movie" width="100%" src="https://www.youtube.com/embed/$$VIDEO_ID$$?showinfo=0&autohide=1&rel=0&vq=hd1080" height="100%" frameborder="0" allowfullscreen></iframe>';
    const DEFAULT_WEDDING_VIDEO_ID = 'Q9aUb6FJdhk';
    const DEFAULT_BIRTHDAY_VIDEO_ID = 'aSjy4h9GHS0';
    const DEFAULT_EXHIBITION_VIDEO_ID = 'JIRrGBnwBek';
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
        $template = $entity->getTemplate();

        $templateData = $template->getData();

        $name = '';
        $userRepository = $args->getEntityManager()->getRepository(User::class);
        $thiepdo = $userRepository->find(18);
        switch ($entity->getTemplate()->getType()) {
            case 1:
                $templateData['bride_name'] = $data['bride_name'];
                $templateData['groom_name'] = $data['groom_name'];
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
                $comment = new Comment();
                $comment->setAuthor($thiepdo)->setCard($entity)->setContent('Thiệp Đỏ xin chúc hai bạn một đám cưới hạnh phúc và viên mãn !');
                $entity->addComment($comment);

                break;
            case 2:
                $templateData['event'] = $data['event'];
                $name = sprintf('%s %s thang %s nam %s %s',
                    $data['event'],
                    $entity->getWeddingDate()->format('d'),
                    $entity->getWeddingDate()->format('m'),
                    $entity->getWeddingDate()->format('Y'),
                    uniqid(''));

                $comment = new Comment();
                $comment->setAuthor($thiepdo)->setCard($entity)->setContent('Thiệp Đỏ chúc quý vị một ngày thành công rực rỡ !');
                $entity->addComment($comment);
                break;
            case 3:
                $templateData['title'] = $data['title'];
                $templateData['name'] = $data['name'];
                $name = sprintf('%s của %s %s thang %s nam %s %s',
                    $data['title'],
                    $data['name'],
                    $entity->getWeddingDate()->format('d'),
                    $entity->getWeddingDate()->format('m'),
                    $entity->getWeddingDate()->format('Y'),
                    uniqid(''));

                $comment = new Comment();
                $comment->setAuthor($thiepdo)->setCard($entity)->setContent('Thiệp Đỏ chúc con một sinh nhật vui vẻ và hạnh phúc !');
                $entity->addComment($comment);
                break;
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
            switch ($entity->getTemplate()->getType()) {
                case 1:
                    $entity->setEmbedded(str_replace('$$VIDEO_ID$$', self::DEFAULT_WEDDING_VIDEO_ID, self::TEMPLATE));
                    break;
                case 2:
                    $entity->setEmbedded(str_replace('$$VIDEO_ID$$', self::DEFAULT_EXHIBITION_VIDEO_ID, self::TEMPLATE));
                    break;
                case 3:
                    $entity->setEmbedded(str_replace('$$VIDEO_ID$$', self::DEFAULT_BIRTHDAY_VIDEO_ID, self::TEMPLATE));
                    break;
            }
        }

        $entity
            ->setData($templateData)
            ->setLongitude($template->getLongitude())
            ->setLatitude($template->getLatitude())
            ->setHomeLatitude($template->getHomeLatitude())
            ->setHomeLongitude($template->getHomeLongitude())
        ;
    }
}