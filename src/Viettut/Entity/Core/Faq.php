<?php


namespace Viettut\Entity\Core;

use Viettut\Model\Core\Faq as FaqModel;
class Faq extends FaqModel
{
    protected $id;
    protected $question;
    protected $answer;
    protected $createdAt;
}