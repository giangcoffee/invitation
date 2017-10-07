<?php


namespace Viettut\Entity\Core;

use Viettut\Model\Core\Subscriber as SubscriberModel;
class Subscriber extends SubscriberModel
{
    protected $id;
    protected $email;
    protected $createdAt;
    protected $deletedAt;
}