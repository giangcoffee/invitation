<?php


namespace Viettut\Entity\Core;

use Viettut\Model\Core\Post as PostModel;
class Post extends PostModel
{
    protected $id;
    protected $title;
    protected $content;
    protected $video;
    protected $view;
    protected $hash;
    protected $hasVideo;
    protected $author;
    protected $deletedAt;
    protected $updatedAt;
    protected $published;
    protected $createdAt;
    protected $summary;
}