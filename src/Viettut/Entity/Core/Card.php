<?php


namespace Viettut\Entity\Core;

use Viettut\Model\Core\Card as CardModel;
class Card extends CardModel
{
    protected $id;
    protected $hash;
    protected $data;
    protected $author;
    protected $createdAt;
    protected $deletedAt;
}