<?php


namespace Viettut\Entity\Core;

use Viettut\Model\Core\LibraryCard as LibraryCardModel;
class LibraryCard extends LibraryCardModel
{
    protected $id;
    protected $gallery;
    protected $createdAt;
    protected $video;
    protected $videoId;
    protected $validVideo;
    protected $cards;
    protected $embedded;
}