<?php


namespace Viettut\Entity\Core;

use Viettut\Model\Core\Card as CardModel;
class Card extends CardModel
{
    protected $id;
    protected $hash;
    protected $data;
    protected $author;
    protected $gallery;
    protected $weddingDate;
    protected $template;
    protected $comments;
    protected $createdAt;
    protected $deletedAt;
    protected $latitude;
    protected $longitude;
    protected $forGroom;
    protected $commentObjectId;
    protected $validVideo;
    protected $video;
}