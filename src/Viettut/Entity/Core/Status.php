<?php
/**
 * Created by PhpStorm.
 * User: giang
 * Date: 10/21/15
 * Time: 9:48 PM
 */

namespace Viettut\Entity\Core;
use Viettut\Model\Core\Status as StatusModel;

class Status extends StatusModel
{
    protected $id;
    protected $uniqueUser;
    protected $card;
    protected $status;
    protected $createdAt;

    function __construct()
    {
    }
}