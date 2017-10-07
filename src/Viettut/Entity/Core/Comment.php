<?php
/**
 * Created by PhpStorm.
 * User: giang
 * Date: 10/21/15
 * Time: 9:48 PM
 */

namespace Viettut\Entity\Core;
use Viettut\Model\Core\Comment as CommentModel;

class Comment extends CommentModel
{
    protected $id;
    protected $content;
    protected $author;
    protected $card;
    protected $createdAt;
    protected $deletedAt;

    function __construct()
    {
    }
}